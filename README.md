# Avora WP - Modern WordPress Theme

A pixel-perfect WordPress theme converted from the [AVORA static website](https://github.com/aigarsild/avora), built with modern development tools and Estonian real estate company branding.

## 🏗️ Tech Stack

- **WordPress** - Bedrock boilerplate for modern WP development
- **Vite** - Fast build tool with hot module replacement
- **CSS Custom Properties** - For exact brand color and spacing system
- **Poppins Font** - Google Fonts integration
- **Estonian Language** - Full localization support

## 🎨 Design System

### Brand Colors
```css
--color-primary: #14213D    /* Dark blue primary */
--color-accent: #FCA311     /* Orange accent */
--color-gray: #E5E5E5       /* Light gray */
--color-white: #fff         /* Pure white */
```

### Typography
- **Font Family**: Poppins (200, 400, 500, 700, 900)
- **H1**: 40px / Extra Bold
- **H2**: 36px / Bold  
- **H3**: 28px / Bold
- **Body**: 18px / Light

### Spacing System
- **XS**: 8px
- **SM**: 10px 
- **MD**: 15px
- **LG**: 20px
- **XL**: 30px
- **XXL**: 40px
- **XXXL**: 60px
- **Huge**: 80px
- **Section**: 100px

## 🚀 Features

- ✅ **Pixel-Perfect Conversion** - Exact match to original static site
- ✅ **Responsive Design** - Mobile-first approach with breakpoint at 768px
- ✅ **Modern WordPress** - Bedrock boilerplate with Composer dependency management
- ✅ **Fast Development** - Vite build system with hot reloading
- ✅ **Estonian Content** - All original Estonian language content preserved
- ✅ **SEO Optimized** - Proper meta tags, favicon setup, and semantic HTML
- ✅ **Performance** - Optimized assets and minimal WordPress features
- ✅ **Accessibility** - Proper ARIA labels and semantic structure

## 📱 Sections

### Hero Section
- 70vh height with curved image overlay (border-radius: 0 0 800px 0)
- Two-column grid layout (desktop) / stacked (mobile)
- Estonian headline: "Loome väärtust, läbi kinnisvara"

### Stats Section  
- Three-column grid showcasing company metrics
- 40+ projects, 7 years experience, 87+ satisfied clients
- Top border separator with proper spacing

### Quote Section
- Full viewport height dark section
- Company description in Estonian
- Centered text with optimal line length

### Feature Section
- Two-column layout with circular image (500px diameter)
- Quality and precision messaging
- 90vh height for visual impact

### Footer
- Two-column grid with logo and contact information
- Social media links (Facebook, Instagram)
- Estonian business registration details
- Copyright in Estonian: "Kõik õigused kaitstud"

## 🛠️ Installation

### Prerequisites
- PHP 8.0+
- MySQL 8.0+
- Node.js 18+
- Composer
- Laravel Valet (for local development)

### Setup
1. **Clone the repository**
   ```bash
   git clone https://github.com/aigarsild/avora-wp.git
   cd avora-wp
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Create environment file**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials and WordPress salts
   ```

4. **Create database**
   ```bash
   mysql -u root -e "CREATE DATABASE avora_wp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

5. **Install theme dependencies**
   ```bash
   cd web/app/themes/avora-wp
   npm install
   npm run build
   ```

6. **Set up Valet (macOS)**
   ```bash
   cd web
   valet link avora-wp
   valet secure avora-wp  # Optional HTTPS
   ```

7. **Install WordPress**
   - Visit: `https://avora-wp.test/wp/wp-admin/install.php`
   - Complete WordPress installation
   - Activate the "Avora WP" theme

## 🎯 Development

### Theme Development
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
│   ├── main.js           # JavaScript entry point
│   └── style.css         # Main CSS with original styles
├── dist/                 # Built assets (auto-generated)
├── images/               # All original images and icons
├── 404.php              # Error page template
├── footer.php           # Site footer
├── functions.php        # Theme functionality
├── header.php           # Site header with favicons
├── index.php            # Homepage template
├── page.php             # Static page template
├── single.php           # Blog post template
└── style.css            # WordPress theme header
```

## 🌐 Original Static Site

This WordPress theme is a pixel-perfect conversion of the original static website:
- **Repository**: [github.com/aigarsild/avora](https://github.com/aigarsild/avora)
- **Technology**: Pure HTML/CSS with modern design patterns
- **Content**: Estonian real estate development company

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🏢 About AVORA

AVORA is an Estonian capital-based real estate development company specializing in residential construction. They create thoughtfully designed living environments in Tallinn and Harju County, focusing on quality materials and innovative construction methods to build homes that last generations.

- **Website**: [avora.ee](https://avora.ee)
- **Phone**: +372 5084851
- **Email**: info@avora.ee
- **Address**: Tartu mnt 84a, Kesklinna linnaosa, Tallinn, Harju maakond, 10112

---

**Built with ❤️ in Estonia**