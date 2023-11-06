#!/bin/bash
set -e

echo "Deploying application"

git pull origin dev

#Install composer dependencies
#composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader#

composer update

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Run migration & seeder
# php artisan migrate:fresh --seed

yarn install && yarn dev

echo "Deploy complete"
