#!/bin/sh
set -e

echo "🚀 Iniciando Laravel..."

# -------------------------------------------------------
# Permissões
# -------------------------------------------------------
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# -------------------------------------------------------
# Otimizações de produção do Laravel
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
# Aguarda o PHP-FPM estar pronto na porta 9000
# antes de subir o Nginx
# -------------------------------------------------------
echo "⏳ Aguardando PHP-FPM ficar disponível na porta 9000..."

TIMEOUT=30  # segundos máximos de espera
WAITED=0

while ! nc -z 127.0.0.1 9000; do
    if [ "$WAITED" -ge "$TIMEOUT" ]; then
        echo "❌ PHP-FPM não respondeu após ${TIMEOUT}s — abortando."
        exit 1
    fi
    sleep 1
    WAITED=$((WAITED + 1))
    echo "   ... aguardando (${WAITED}s)"
done

echo "✅ PHP-FPM pronto!"

# -------------------------------------------------------
# Inicia o Nginx em foreground
# -------------------------------------------------------
echo "▶ Iniciando Nginx..."
exec nginx -g "daemon off;"