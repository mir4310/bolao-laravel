#!/bin/sh
set -e

echo "🚀 Iniciando Laravel..."

# -------------------------------------------------------
# Garante que storage e cache têm permissão correta
# mesmo com volumes montados em runtime
# -------------------------------------------------------
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# -------------------------------------------------------
# Otimizações de produção do Laravel
# (feitas aqui pois dependem das env vars do container)
# -------------------------------------------------------
php artisan config:cache
php artisan route:cache
php artisan view:cache

# -------------------------------------------------------
# Inicia o PHP-FPM em background
# -------------------------------------------------------
echo "▶ Iniciando PHP-FPM..."
php-fpm --daemonize

# -------------------------------------------------------
# Inicia o Nginx em foreground
# (processo principal — mantém o container vivo)
# -------------------------------------------------------
echo "▶ Iniciando Nginx..."
exec nginx -g "daemon off;"