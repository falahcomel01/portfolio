# Release Checklist

## Environment

- Copy `.env.production.example` to `.env`
- Set `APP_KEY` with `php artisan key:generate`
- Confirm `APP_ENV=production`
- Confirm `APP_DEBUG=false`
- Confirm `APP_URL` matches the real domain
- Confirm `FORCE_HTTPS=true` when the site is served behind HTTPS
- Confirm production database credentials are correct

## Server setup

- Confirm Node.js version matches `.nvmrc`
- Prefer `npm ci` instead of `npm install` on deployment
- Install PHP 8.3+
- Install Composer dependencies with `composer install --no-dev --optimize-autoloader`
- Install Node dependencies and build assets with `npm ci` then `npm run build`
- Ensure `storage` and `bootstrap/cache` are writable
- Run `php artisan storage:link`

## Database

- Run `php artisan migrate --force`
- Confirm tables `sessions`, `cache`, `jobs`, and `failed_jobs` exist when using database drivers
- Verify admin user exists and `email_verified_at` is filled

## Laravel optimization

- Run `php artisan optimize`
- Run `php artisan config:cache`
- Run `php artisan route:cache`
- Run `php artisan view:cache`

## Smoke test

- Open landing page and confirm assets load
- Test login and logout
- Test contact form submit
- Test CV download
- Test create, update, and delete for skills, projects, certificates, experiences, educations, organizations, and contacts
- Confirm uploaded images render from `/storage/...`

## Security checks

- Confirm HTTPS is active
- Confirm session cookie is secure in production
- Confirm no debug page is exposed
- Confirm mail credentials are not log-only in production
