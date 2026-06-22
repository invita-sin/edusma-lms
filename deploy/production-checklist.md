# Production Checklist

## Server Requirements
- [ ] Ubuntu 24.04 LTS
- [ ] PHP 8.3+ with extensions: mbstring, pdo_mysql, bcmath, xml, gd, zip, intl
- [ ] MySQL 8.0+
- [ ] Redis 7+
- [ ] Composer 2.x
- [ ] Node.js 20+ (for building assets)
- [ ] Nginx
- [ ] Supervisor

## Application Setup
- [ ] Clone repository to `/var/www/edusma`
- [ ] Copy `.env.example` to `.env` and configure:
  - [ ] APP_ENV=production
  - [ ] APP_DEBUG=false
  - [ ] DB credentials
  - [ ] Redis credentials
  - [ ] MAIL configuration
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Run `npm ci && npm run build`
- [ ] Run `php artisan key:generate`
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan db:seed --force`
- [ ] Run `php artisan storage:link`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `php artisan filament:assets`

## Configuration
- [ ] Set proper file permissions: `chown -R www-data:www-data storage bootstrap/cache`
- [ ] Configure Nginx (see `deploy/nginx.conf`)
- [ ] Configure Supervisor (see `deploy/supervisor.conf`)
- [ ] Set up SSL certificate via Let's Encrypt
- [ ] Configure Redis for cache and queue
- [ ] Set up cron: `* * * * * cd /var/www/edusma && php artisan schedule:run >> /dev/null 2>&1`

## Security
- [ ] Change default passwords
- [ ] Enable firewall (UFW)
- [ ] Disable root SSH login
- [ ] Enable fail2ban
- [ ] Regular security updates

## Monitoring
- [ ] Set up log rotation
- [ ] Configure health check endpoint
- [ ] Set up Sentry or similar error tracking
- [ ] Monitor queue workers via Supervisor

## Backup
- [ ] Daily database backup
- [ ] Daily file backup (storage)
- [ ] Test restore procedure
