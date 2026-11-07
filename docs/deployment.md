# Deployment

## Scheduler

Laravel 11 schedules routes from `routes/console.php`. In demo mode (`APP_DEMO=true`), `demo:reset` runs daily at 03:30 to refresh data.

Production:

```bash
* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1
```

Docker Compose includes a `scheduler` service running `php artisan schedule:work`.

## Queues

Set `QUEUE_CONNECTION=redis` and run workers:

```bash
php artisan queue:work redis --sleep=3 --tries=3
```

The `queue` Compose service and `docker/supervisor/supervisord.conf` provide the same for containers.

## Reverb

Configure Redis and start the websocket server:

```bash
php artisan reverb:start --host=0.0.0.0 --port=8081
```

The `reverb` Compose service exposes port `8081`. Point `REVERB_*` env vars at your public hostname in production.

## Backups

- **Database:** nightly MySQL dumps (`mysqldump`) or managed snapshots
- **Media:** sync `storage/app` / S3 bucket if `FILESYSTEM_DISK=s3`
- **Demo resets:** do not enable `APP_DEMO` in production; `demo:reset` runs `migrate:fresh --seed`

## Demo command

```bash
php artisan demo:reset --force
```

Refuses to run unless `APP_DEMO=true`.
