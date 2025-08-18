# Avora WordPress Production Deployment Guide

This guide will walk you through deploying your Bedrock WordPress site to production step by step.

## Prerequisites

Before starting, ensure you have:
- ✅ A production server with PHP 8.1+ and MySQL/MariaDB
- ✅ SSH access to your server
- ✅ A domain name pointed to your server
- ✅ SSL certificate (Let's Encrypt recommended)
- ✅ Composer installed on the server
- ✅ Node.js and npm installed on the server

## Step 1: Prepare Your Local Environment

### 1.1 Build Production Assets
```bash
# Navigate to your theme directory
cd web/app/themes/avora-wp

# Install dependencies (if not already done)
npm install

# Build production assets
npm run build
```

### 1.2 Optimize PHP Dependencies
```bash
# In your project root
composer install --no-dev --optimize-autoloader
```

## Step 2: Server Setup

### 2.1 Verify Existing Setup
Your server already has a Bedrock structure configured:
```bash
# SSH into your server
ssh virt139545@sn-69-6.tll07.zoneas.eu

# Verify the existing structure
ll ~/
# Should show:
# bedrock/ (your WordPress installation directory)
# public_html -> /data05/virt139545/bedrock/web (symlink to web root)
```

The bedrock folder is already created and your web server is configured to serve from `bedrock/web` via the symlink.

### 2.2 Web Server Configuration (Managed Hosting)

Your hosting provider manages the web server configuration automatically. The `public_html` symlink already points to the correct web root.

**Optional**: Create `~/bedrock/web/.htaccess` for WordPress URL rewriting (if needed):
```apache
# BEGIN WordPress
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
# END WordPress
```

**Note**: Your hosting provider handles SSL, compression, and security headers automatically.

## Step 3: Database Setup

### 3.1 Create Database (Managed Hosting)

**For shared hosting**: Use your hosting provider's control panel to create the database and user. You typically don't have direct MySQL root access.

1. **Log into your hosting control panel**
2. **Navigate to MySQL/Database section**
3. **Create a new database** (e.g., `avora_wp_prod`)
4. **Create a database user** with a secure password
5. **Grant all privileges** to the user for that database
6. **Note down the database details** for your `.env` file

**Alternative** (if you have MySQL access):
```bash
# Login to MySQL (if available)
mysql -u your_username -p

# Create database
CREATE DATABASE avora_wp_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3.2 Import Development Database (Optional)
```bash
# Export from development
mysqldump -u dev_user -p dev_database > avora_dev_export.sql

# Import to production
mysql -u avora_wp_user -p avora_wp_prod < avora_dev_export.sql
```

## Step 4: Deploy Code

### 4.1 Upload Files
Choose one of these methods:

#### Method A: Git Clone (Recommended)
```bash
# On your server
cd ~/bedrock
git clone https://github.com/yourusername/avora-wp.git .

# Install dependencies
composer install --no-dev --optimize-autoloader

# Build theme assets
cd web/app/themes/avora-wp
npm ci --production=false
npm run build
```

#### Method B: SCP/SFTP Upload
```bash
# From your local machine (exclude node_modules and .git)
rsync -av --exclude 'node_modules' --exclude '.git' --exclude '.env*' /Users/aigarsild/avora-wp/ virt139545@sn-69-6.tll07.zoneas.eu:~/bedrock/
```

### 4.2 Set Proper Permissions
```bash
# On your server - adjust permissions as needed for your hosting setup
# Your hosting provider may handle this automatically
find ~/bedrock -type d -exec chmod 755 {} \;
find ~/bedrock -type f -exec chmod 644 {} \;
chmod 600 ~/bedrock/.env
```

## Step 5: Environment Configuration

### 5.1 Create Production .env File
```bash
# On your server
cd ~/bedrock
cp .env.example .env
nano .env
```

### 5.2 Configure .env File
Update the following values in your `.env` file:

```env
# Environment
WP_ENV=production

# Database
DB_NAME=d139972sd608763
DB_USER=d139972sa555055
DB_PASSWORD=g6HcDLK578GQ7xd5ec
DB_HOST=d139972.mysql.zonevs.eu
DB_PREFIX=wp_

# URLs (CRITICAL: Replace with your actual domain)
WP_HOME=https://yourdomain.com
WP_SITEURL=https://yourdomain.com/wp

# Generate new salts at https://roots.io/salts/
AUTH_KEY='generate-unique-key-here'
SECURE_AUTH_KEY='generate-unique-key-here'
LOGGED_IN_KEY='generate-unique-key-here'
NONCE_KEY='generate-unique-key-here'
AUTH_SALT='generate-unique-salt-here'
SECURE_AUTH_SALT='generate-unique-salt-here'
LOGGED_IN_SALT='generate-unique-salt-here'
NONCE_SALT='generate-unique-salt-here'

# Optional optimizations
DISABLE_WP_CRON=true
WP_DEBUG_LOG=false
```

### 5.3 Generate WordPress Salts
Visit https://roots.io/salts/ and replace the salt values in your `.env` file with newly generated ones.

## Step 6: WordPress Installation

### 6.1 Complete WordPress Setup
1. Visit `https://yourdomain.com/wp/wp-admin/install.php`
2. Follow the WordPress installation wizard
3. Create your admin user account

### 6.2 Update Site URLs (if migrating from development)
```bash
# If you imported a development database, update URLs
wp search-replace 'http://localhost:3000' 'https://yourdomain.com' --path='~/bedrock/web/wp'
```

## Step 7: Post-Deployment Optimization

### 7.1 Set Up Server Cron
```bash
# Edit crontab
crontab -e

# Add WordPress cron job (runs every 15 minutes)
*/15 * * * * cd ~/bedrock/web && php wp-cron.php > /dev/null 2>&1
```

### 7.2 Install WordPress CLI (if not already installed)
```bash
# Check if WP-CLI is already available
wp --version

# If not installed, install locally (no sudo access on shared hosting)
curl -O https://raw.githubusercontent.com/wp-cli/wp-cli/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mkdir -p ~/bin
mv wp-cli.phar ~/bin/wp

# Add to PATH (add this to your ~/.bashrc or ~/.zshrc)
echo 'export PATH="$HOME/bin:$PATH"' >> ~/.bashrc
source ~/.bashrc
```

### 7.3 Configure WordPress Settings
```bash
# Set permalink structure
wp rewrite structure '/%postname%/' --path='~/bedrock/web/wp'

# Flush rewrite rules
wp rewrite flush --path='~/bedrock/web/wp'

# Update file permissions
wp core update-db --path='~/bedrock/web/wp'
```

## Step 8: Security Hardening

### 8.1 Disable Directory Browsing
Ensure your web server configuration prevents directory browsing.

### 8.2 Hide WordPress Version
Add to your theme's `functions.php`:
```php
// Hide WordPress version
remove_action('wp_head', 'wp_generator');
```

### 8.3 Regular Updates
Set up automatic security updates:
```bash
# Enable automatic updates for WordPress core security updates
wp config set WP_AUTO_UPDATE_CORE minor --type=constant --path='~/bedrock/web/wp'
```

## Step 9: Performance Optimization

### 9.1 Install Caching Plugin (Optional)
Consider installing a caching plugin like W3 Total Cache or WP Rocket for better performance.

### 9.2 Enable Object Caching (Advanced)
If you have Redis or Memcached available:
```bash
# Install Redis plugin
wp plugin install redis-cache --activate --path='~/bedrock/web/wp'
```

## Step 10: Monitoring and Maintenance

### 10.1 Set Up Backups
Create a backup script `~/bedrock/backup.sh`:
```bash
#!/bin/bash
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="~/backups/avora-wp"
PROJECT_DIR="~/bedrock"

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u avora_wp_user -p avora_wp_prod | gzip > $BACKUP_DIR/database_$BACKUP_DATE.sql.gz

# Files backup
tar -czf $BACKUP_DIR/files_$BACKUP_DATE.tar.gz -C $PROJECT_DIR web/app/uploads

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.gz" -mtime +7 -delete
```

### 10.2 Set Up Monitoring
Consider setting up:
- Uptime monitoring (UptimeRobot, Pingdom)
- Error logging and monitoring
- Performance monitoring

## Troubleshooting Common Issues

### Issue 1: 500 Internal Server Error
- Check your hosting provider's error logs (usually in control panel)
- Verify file permissions: `find ~/bedrock -type f -exec chmod 644 {} \;`
- Check `.env` file configuration and syntax
- Ensure all dependencies are installed: `composer install --no-dev`
- Verify PHP version compatibility

### Issue 2: Assets Not Loading
- Verify Vite build completed successfully
- Check web server static file configuration
- Ensure proper permissions on `~/bedrock/web/app/themes/avora-wp/dist/` directory

### Issue 3: Database Connection Error
- Verify database credentials in `.env`
- Check if database server is running
- Confirm user has proper permissions

### Issue 4: SSL Issues
- Verify certificate installation
- Check if FORCE_SSL_ADMIN is causing issues
- Ensure WP_HOME and WP_SITEURL use https://

## Deployment Checklist (Shared Hosting)

- [ ] ✅ Production server configured (managed by hosting provider)
- [ ] Database created via hosting control panel
- [ ] Code deployed to `~/bedrock/` directory
- [ ] Dependencies installed: `composer install --no-dev`
- [ ] Assets built: `npm run build`
- [ ] `.env` file configured with production values
- [ ] WordPress salts generated and updated
- [ ] File permissions set: `chmod 644` files, `chmod 755` directories
- [ ] ✅ SSL certificate (managed by hosting provider)
- [ ] WordPress installation completed via web interface
- [ ] URLs updated (if migrating from development)
- [ ] Optional: Cron jobs configured
- [ ] Optional: `.htaccess` file created
- [ ] Backups configured (hosting provider + custom)
- [ ] Monitoring set up
- [ ] Performance optimization completed

## Support

If you encounter issues during deployment:
1. Check the error logs first
2. Verify all configuration files
3. Ensure all dependencies are properly installed
4. Review the Bedrock documentation: https://roots.io/bedrock/

Remember to keep your production environment secure and regularly updated!
