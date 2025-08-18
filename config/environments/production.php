<?php

/**
 * Configuration overrides for WP_ENV === 'production'
 */

use Roots\WPConfig\Config;

/**
 * Production-specific configurations
 * Most settings are inherited from application.php
 */

// Ensure indexing is allowed in production (remove the disallow indexing)
Config::define('DISALLOW_INDEXING', false);

// Performance optimizations
Config::define('WP_CACHE', true);
Config::define('COMPRESS_CSS', true);
Config::define('COMPRESS_SCRIPTS', true);
Config::define('ENFORCE_GZIP', true);

// Security enhancements
Config::define('FORCE_SSL_ADMIN', true);
Config::define('WP_POST_REVISIONS', 3); // Limit revisions to save database space

// Disable XML-RPC (often not needed and can be a security risk)
Config::define('XMLRPC_ENABLED', false);


