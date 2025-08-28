## Server Setup Documentation

The server now uses a **hybrid symlink structure** that works with git pulls:

### Current Structure:
- **Web server document root:** /htdocs/ 
- **Git repository:** Uses standard Bedrock /web/ structure
- **WordPress core:** /web/wp/
- **Templates:** /web/app/themes/avora-wp/
- **Uploads:** /web/app/uploads/

### Symlinks in /htdocs/:
- htdocs/index.php -> ../web/index.php
- htdocs/wp -> ../web/wp  
- htdocs/app -> ../web/app

### WordPress Uploads Fix (Aug 18, 2025):
**Issue:** "Unable to create directory uploads/2025/08. Is its parent directory writable by the server?"

**Root Cause:** Circular symlink and missing uploads directory

**Fix Applied:**
```bash
# Remove circular symlinks
rm web/app/uploads

# Create proper uploads directory
mkdir -p web/app/uploads
chmod 775 web/app/uploads

# Pre-create year/month structure
mkdir -p web/app/uploads/2025/08
chmod 775 web/app/uploads/2025 web/app/uploads/2025/08
```

### This means:
✅ Git pulls will work correctly (updates /web/ structure)
✅ Web server serves from /htdocs/ via symlinks  
✅ WordPress templates are in version control
✅ WordPress uploads work with proper permissions
✅ No manual server changes needed after git pull

### URLs working:
- ✅ https://avora.ee/ (homepage)
- ✅ https://avora.ee/projekt/forest-retreat-resort/ (projects)
- ✅ https://avora.ee/app/uploads/ (images)
- ✅ WordPress media uploads (2025/08/ structure)


