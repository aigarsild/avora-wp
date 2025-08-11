# Avora WP - Lightweight WordPress Setup

This is a lightweight WordPress project built with **Bedrock**, **Vite**, and **Tailwind CSS** following modern development practices.

## 🚀 Quick Start

### 1. Set up Environment Variables

Copy the environment configuration and set up your environment:

```bash
# Create your .env file (manually create since it's in gitignore)
# Set these values in your .env file:
WP_ENV=development
WP_HOME=http://avora-wp.test
WP_SITEURL=${WP_HOME}/wp

DB_NAME=avora_wp
DB_USER=root
DB_PASSWORD=
DB_HOST=127.0.0.1

# Generate your security keys at: https://roots.io/salts.html
AUTH_KEY='your-auth-key-here'
SECURE_AUTH_KEY='your-secure-auth-key-here'
LOGGED_IN_KEY='your-logged-in-key-here'
NONCE_KEY='your-nonce-key-here'
AUTH_SALT='your-auth-salt-here'
SECURE_AUTH_SALT='your-secure-auth-salt-here'
LOGGED_IN_SALT='your-logged-in-salt-here'
NONCE_SALT='your-nonce-salt-here'
```

### 2. Database Setup

The database `avora_wp` has already been created. If you need to recreate it:

```bash
mysql -u root -e "CREATE DATABASE avora_wp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. Serve with Laravel Valet

```bash
cd web
valet link avora-wp     # serves http://avora-wp.test from web/ subfolder
valet secure avora-wp   # optional: enable HTTPS
```

### 4. Install WordPress

1. Visit: `http://avora-wp.test/wp/wp-admin/install.php`
2. Complete the WordPress installation form
3. Go to **Settings → Permalinks** and click Save to generate `.htaccess`

### 5. Activate Your Theme

1. Go to **Appearance → Themes** in WordPress admin
2. Activate the **Avora WP** theme

## 🛠 Development

### Theme Development

The custom theme is located in `web/app/themes/avora-wp/` and includes:

- **Vite** for fast builds and hot module replacement
- **Tailwind CSS** for utility-first styling
- **Modern PHP** with clean, maintainable code

### Building Assets

```bash
cd web/app/themes/avora-wp

# Development with hot reloading
npm run dev

# Production build
npm run build
```

### File Structure

```
web/app/themes/avora-wp/
├── src/
│   ├── main.js         # JavaScript entry point
│   └── style.css       # CSS with Tailwind directives
├── dist/               # Built assets (auto-generated)
├── functions.php       # Theme functionality
├── style.css          # Theme header file
├── index.php          # Main template
├── header.php         # Site header
├── footer.php         # Site footer
└── package.json       # Dependencies and scripts
```

## 📦 Features

- ✅ **Bedrock** - Modern WordPress boilerplate
- ✅ **Vite** - Fast build tool with HMR
- ✅ **Tailwind CSS** - Utility-first CSS framework
- ✅ **Clean Code** - Modern PHP practices
- ✅ **Git Ready** - Proper .gitignore setup
- ✅ **Responsive Design** - Mobile-first approach
- ✅ **Performance Optimized** - Minimal, fast-loading assets

## 🔧 Configuration

### Adding Plugins

```bash
# Add plugins via Composer
composer require wpackagist-plugin/plugin-name

# Example: Add Advanced Custom Fields
composer require wpackagist-plugin/advanced-custom-fields
```

### Environment Variables

- `WP_ENV=development` - Sets WordPress to development mode
- `WP_HOME` - Your site URL
- `WP_SITEURL` - WordPress core URL (should be WP_HOME/wp)
- Database credentials for your local setup

## 🎨 Customization

The theme is built with Tailwind CSS utility classes. You can:

1. **Modify styles** in `src/style.css`
2. **Add JavaScript** in `src/main.js`
3. **Customize templates** in the theme root
4. **Configure Tailwind** in `tailwind.config.js`

## 📝 Next Steps

1. Create your `.env` file with the configuration above
2. Install WordPress via the web interface
3. Start building your amazing site!

---

**Happy coding!** 🎉
