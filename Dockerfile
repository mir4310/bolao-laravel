# ========================== STAGE 1 ===========================
# Estágio 1: Composer
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# Baixa as dependências sem gerar o autoloader ainda
RUN composer install --no-interaction --prefer-dist --no-autoloader --no-dev --no-scripts --ignore-platform-reqs

# Copia todo o código para dentro do Estágio 1
COPY . .
# Gera o autoloader otimizado aqui mesmo (ignorando scripts que precisariam do banco de dados/extensões)
RUN composer dump-autoload --optimize --no-dev --no-scripts

# ========================== STAGE 2 ===========================
# Estágio 2: Node (Vite Build)
#FROM node:20-alpine AS frontend
#WORKDIR /app
#COPY . . 
#RUN npm install && npm run build

# ========================== STAGE 3 ===========================
# Estágio 3: Imagem Final 
FROM php:8.4-apache

# Instala dependências nativas no Debian
RUN apt-get update && apt-get install -y \
    npm \
    nodejs \
    nano \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Ativa o Opcache e aplica as configurações otimizadas para o Laravel
# Deve setar enable pra 1 para ativar

RUN docker-php-ext-enable opcache
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'max_execution_time=60'; \
} > /usr/local/etc/php/conf.d/opcache.ini
    
WORKDIR /var/www/html

# Copia os arquivos da sua aplicação
COPY . .

# 👉 NOVIDADE: Copia a pasta vendor já com o autoload gerado do Estágio 1
COPY --from=vendor /app/vendor/ ./vendor/

# Executa o VITE
RUN rm -rf public/build 
RUN npm install
RUN npm run build
# Copia os assets compilados do Vite do Estágio 2
# Remove qualquer resquício de pasta build local trazida pelo comando acima
# RUN rm -rf public/build
# COPY --from=frontend /app/public/ ./public/

# Como não precisamos mais rodar o composer aqui, apenas ajustamos as permissões!
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# 2. Atualiza a raiz do site (DocumentRoot) em todas as configurações
# 3. Altera AllowOverride para All para ler o seu arquivo .htaccess
# 4. Injeta as diretivas HTTPS de forma segura e limpa dentro do bloco <VirtualHost>
RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf /etc/apache2/sites-available/*.conf \
    && sed -i '/<\/VirtualHost>/i \    SetEnv HTTPS On\n    PassEnv HTTPS' /etc/apache2/sites-available/000-default.conf
    
# Limpa os caches internos do Laravel antes de iniciar o Apache
RUN php artisan config:clear && php artisan view:clear

EXPOSE 80

CMD ["apache2-foreground"]
