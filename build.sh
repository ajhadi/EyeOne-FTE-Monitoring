#!/usr/bin/env bash
# Build script for Render deployment
# exit on error
set -o errexit

echo "🚀 Starting build process..."

# Install PHP dependencies (production only)
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install Node dependencies
echo "📦 Installing Node.js dependencies..."
npm install

# Build frontend assets
echo "🏗️ Building frontend assets..."
npm run build

# Create storage directories BEFORE cache
echo "📁 Setting up storage directories..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Clear any existing cache first
echo "🧹 Clearing old cache..."
php artisan cache:clear || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Then optimize Laravel caches
echo "🔧 Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed successfully!"

# Set permissions for Laravel
echo "🔒 Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Run database migrations (WITHOUT seed - database sudah ada data!)
echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "🎉 Deployment ready!"
