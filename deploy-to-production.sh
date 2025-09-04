#!/bin/bash

# Avora WordPress Production Deployment Script
# This script automates the deployment process to the production server

set -e  # Exit on any error

echo "🚀 Starting deployment to production server..."

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Server details
SERVER_USER="virt139545"
SERVER_HOST="avora.ee"
BEDROCK_ROOT="~/domeenid/www.avora.ee"
THEME_DIR="web/app/themes/avora-wp"

echo -e "${BLUE}📡 Connecting to server: ${SERVER_USER}@${SERVER_HOST}${NC}"

# Execute deployment commands on the server
ssh ${SERVER_USER}@${SERVER_HOST} << 'ENDSSH'
set -e  # Exit on any error

echo "📂 Navigating to Bedrock root directory..."
cd ~/domeenid/www.avora.ee

echo "📥 Pulling latest changes from GitHub..."
git pull --ff-only origin main

echo "📦 Installing/updating PHP dependencies..."
composer install --no-dev --optimize-autoloader

echo "📁 Navigating to theme directory..."
cd web/app/themes/avora-wp

echo "🔧 Installing npm dependencies..."
npm ci --production=false

echo "🏗️  Building theme assets..."
npm run build

echo "🧹 Resetting OPcache..."
php -r 'if(function_exists("opcache_reset")) { opcache_reset(); echo "OPcache reset successfully\n"; } else { echo "OPcache not enabled\n"; }'

echo "🔄 Flushing WordPress permalinks..."
cd ~/domeenid/www.avora.ee
wp --path=web/wp rewrite flush --hard

echo "✅ Deployment completed successfully!"
ENDSSH

# Check if SSH command was successful
if [ $? -eq 0 ]; then
    echo -e "${GREEN}🎉 Deployment completed successfully!${NC}"
    echo -e "${GREEN}✅ All changes have been deployed to production${NC}"
    echo -e "${BLUE}🌐 Website: https://avora.ee${NC}"
else
    echo -e "${RED}❌ Deployment failed! Check the error messages above.${NC}"
    exit 1
fi