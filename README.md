# Ondoc

# This is File Mangement System, zip files and store in folder
## Requirements
- Your PHP version must be >= 8.1+ 
- Redis Server


## Installation Instructions

- Clone the repository with git
- Run `composer install`
- Run `cp .env.example .env`
- Run `php artisan key:generate`
- Set your database configration to .env 
- Set your email configration to .env 
- Run `php artisan migrate --seed`
- Run `php artisan jwt:secret`
- Run `npm install`
- Run `npm run dev` or ` npm run production`


### Set ENV
REDIS_CLIENT=predis

### SET configuration (optional)
APP_TIMEZONE=
FILESYSTEM_DISK=

