#!/bin/sh
set -e

# Configure port for Railway / Render / Fly.io (default to 8080)
PORT=${PORT:-8080}
echo "Starting container on port $PORT..."
sed -i "s/PORT_PLACEHOLDER/$PORT/g" /etc/nginx/http.d/default.conf

# Setup SQLite if DB_CONNECTION is sqlite
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    echo "Configuring SQLite database..."
    mkdir -p /var/www/html/database
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
    fi
    chown -R www-data:www-data /var/www/html/database
fi

# Ensure storage and bootstrap/cache permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage symlink
php artisan storage:link --no-interaction || true

# Run database migrations
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force --no-interaction || echo "Migration skipped or failed"
fi

# Seed database if requested (e.g. DB_SEED=true)
if [ "${DB_SEED:-false}" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force --no-interaction || echo "Seeding skipped or failed"
fi

# Optimize application
echo "Caching configuration and routes..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Application is ready. Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
