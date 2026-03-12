#!/bin/bash

cd /var/www/app

echo "Starting deploy..."
php artisan down

echo "Pulling code..."
git pull origin main

echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "Installing Node dependencies..."
npm install

echo "Building frontend..."
npm run build

echo "Running migrations..."
php artisan migrate --force

echo "Optimizing Laravel..."
php artisan optimize

echo "Restarting queues..."
php artisan queue:restart

echo "Finishing deploy..."
php artisan up

echo "Deploy finished!"