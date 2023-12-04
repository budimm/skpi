# SKPI Web Form

## Apa system yang dibutuhkan?

- PHP 7.3
- MySQL
- Composer

## Installation

- `git clone git@github.com:AchmadBudy/skpi.git` atau download zip
- masuk ke folder skpi dan install composer `composer install --no-dev`
- Rubah nama file env ke .env dan sesuaikan isinya dengan konfigurasi database.
- ubah configurasi env
  - `CI_ENVIRONMENT = production`
  - `app.baseURL = isi dengan url anda`
  - `database.default.hostname = isi dengan hostname database anda`
  - `database.default.database = isi dengan nama database anda`
  - `database.default.username = isi dengan username database anda`
  - `database.default.password = isi dengan password database anda`
  - `database.default.DBDriver = MySQLi`
- jalankan migration `php spark migrate --all`
- jalankan seed `php spark db:seed UserSeeder`

- dengan begitu anda sudah bisa login dengan email `admin@gmail.com` dan password `password`
