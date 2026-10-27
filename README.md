# Clinic Metrics Desk

Clinic Metrics Desk is a small, admin-only reporting workspace for clinic appointment operations. It provides a daily status overview, a weekly no-show rate, practitioner appointment totals, and an appointment list with date and status filters.

## Features

- Laravel 13, Inertia, Vue 3, and Tailwind CSS.
- A single seeded admin account; public account registration is disabled.
- Practitioner directory and appointment status tracking (`booked`, `done`, `no_show`, `cancelled`).
- Dashboard totals for today and a weekly no-show rate.
- Appointment list with date range, status filters, and pagination.
- SQLite by default; no Redis service is required.

## Privacy

This project is a synthetic demo. Seed data uses Faker-generated practitioner names and appointment dates/statuses only. It does not collect patient names, patient identifiers, clinical notes, diagnoses, billing details, or real clinic data. Do not add real patient information.

The weekly no-show rate is calculated as `no_show / (done + no_show) × 100`; pending bookings and cancelled appointments are excluded from the rate.

## Requirements

- PHP 8.3 or newer with the SQLite extension
- Composer
- Node.js and npm

## Local setup

```sh
composer install
cp .env.example .env
php -r "touch('database/database.sqlite');"
php artisan key:generate
npm ci
php artisan migrate:fresh --seed
npm run build
```

For Windows PowerShell, use `Copy-Item .env.example .env` instead of `cp`.

The seeder creates six synthetic practitioners, 80 synthetic appointments over a 14-day window, and the demo admin account. To refresh the demo data later, run:

```sh
php artisan migrate:fresh --seed
```

Run the app and frontend development server in separate terminals:

```sh
php artisan serve
npm run dev
```

Open [http://localhost:8000](http://localhost:8000).

## Demo login

- Email: `admin@clinicmetrics.test`
- Password: `password`

These credentials are for local demonstration only. Change the seeded password before any deployment.

## Tests and checks

```sh
php artisan test
npm run types:check
npm run build
```

PHP static analysis can be run with:

```sh
php -d memory_limit=1G vendor/bin/phpstan analyse
```
