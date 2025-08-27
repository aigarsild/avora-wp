#!/bin/bash

# AVORA Production Deployment Script
# This script pulls the latest changes and rebuilds assets on production

echo "🚀 Starting AVORA Production Deployment..."

# Server connection details
SERVER="virt139545@sn-69-6.tll07.zoneas.eu"
SERVER_PATH="~/domeenid/www.avora.ee/htdocs"

echo "📥 Pulling latest changes from Git..."

# SSH to server and run deployment commands
ssh $SERVER << 'ENDSSH'
cd ~/domeenid/www.avora.ee/htdocs

echo "📦 Pulling latest code..."
git pull origin main

echo "🔧 Installing/updating dependencies..."
composer install --no-dev --optimize-autoloader

echo "🎨 Building theme assets..."
cd web/app/themes/avora-wp
npm ci --production=false
npm run build

echo "🔐 Setting proper permissions..."
cd ~/domeenid/www.avora.ee/htdocs
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod 600 .env

echo "✅ Deployment completed successfully!"
echo "🌐 Website: https://avora.ee"
ENDSSH

echo "🎉 Production deployment completed!"
echo "🌐 Visit your website: https://avora.ee"
