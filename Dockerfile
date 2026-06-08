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

# Estágio 2: Node (Vite Build)
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm install
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# Estágio 3: Imagem Final 
FROM php:8.4-apache

# Instala dependências nativas no Debian
RUN apt-get update && apt-get install -y \
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

WORKDIR /var/www/html

# Copia os arquivos da sua aplicação
COPY . .

# 👉 NOVIDADE: Copia a pasta vendor já com o autoload gerado do Estágio 1
COPY --from=vendor /app/vendor/ ./vendor/

# Copia os assets compilados do Vite do Estágio 2
COPY --from=frontend /app/public/build/ ./public/build/

# Como não precisamos mais rodar o composer aqui, apenas ajustamos as permissões!
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && printf '\nSetEnv HTTPS On\nPassEnv HTTPS\n' >> /etc/apache2/apache2.conf
    
EXPOSE 80

CMD ["apache2-foreground"]
