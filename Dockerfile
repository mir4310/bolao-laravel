# ========================== STAGE 1 ===========================
# Estágio 1: Composer
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --no-autoloader \
    --no-dev \
    --no-scripts \
    --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --no-dev --no-scripts

# ========================== STAGE 2 ===========================
# Estágio 3: Imagem Final — PHP-FPM + Nginx
FROM php:8.5-fpm

# ---------------------------------------------------------------
# 1. Dependências do sistema
# ---------------------------------------------------------------
RUN apt-get update && apt-get install -y \
    nginx \
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

# ---------------------------------------------------------------
# 2. Configuração do PHP-FPM
#    Garante que o FPM escute em socket TCP (necessário pro nginx)
# ---------------------------------------------------------------
RUN sed -i 's/listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf

# ---------------------------------------------------------------
# 3. Configuração do Nginx
# ---------------------------------------------------------------
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# ---------------------------------------------------------------
# 4. Aplicação
# ---------------------------------------------------------------
WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor/ ./vendor/

# Build do frontend (Vite)
RUN rm -rf public/build \
    && npm install \
    && npm run build \
    && rm -rf node_modules  # remove node_modules da imagem final

# Permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Limpa caches do Laravel
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# ---------------------------------------------------------------
# 5. Script de entrypoint — sobe PHP-FPM + Nginx juntos
# ---------------------------------------------------------------
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]