# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Peace Tower is a marketing website for a luxury residential building in Ikoyi, Lagos, Nigeria. It is a static PHP site with no framework, no database, and no build step.

## Running Locally

Serve via XAMPP (or any PHP-capable web server) with the document root at this directory. Apache `mod_rewrite` must be enabled for clean URLs. Copy `smtp_config.php` from a team member or create it with the SMTP constants (see below) for the contact form to work.

## Architecture

**Template pattern:** Each page (index.php, aboutus.php, interior.php, exterior.php, floorplan.php, contact-us.php) includes `header.php` and `footer.php` via PHP `include`. There is no routing framework; `.htaccess` rewrites clean URLs (e.g., `/aboutus`) to their `.php` files and 301-redirects any `.php` URLs to the clean version.

**Form handling:** `contact-us.php` POSTs to `/send`, which sanitizes input with `filter_input()`, validates the email, and sends via PHPMailer over SMTP (SSL, port 465). SMTP credentials are loaded from `smtp_config.php` (gitignored). On success or error, the user is redirected back to `/contact-us` with a `?sent=1` or `?error=1` query parameter, and `contact-us.php` displays a dismissible notification banner accordingly.

**Frontend stack:**
- Bootstrap 4 (grid, navbar, responsive utilities)
- jQuery 3.3.1
- Revolution Slider (hero carousel on homepage)
- Owl Carousel, Isotope, Magnific Popup, Animsition (page transitions), Parallax
- Google Fonts: Heebo, Oswald
- Icon fonts: Linear Icons, Ionicons, Elegant Icons

**Assets:** All third-party libraries are vendored under `asset/vendors/`. CSS is in `asset/css/` (style.css is the main theme, responsive.css handles breakpoints). Custom JS is in `asset/js/theme.js`.

**Theme colors:** Primary gold accent is `#c5a47e`.

## Key Files

| File | Purpose |
|------|---------|
| `index.php` | Homepage with Revolution Slider hero, feature sections, galleries |
| `header.php` | Desktop navbar + mobile side menu (included by all pages) |
| `footer.php` | Footer with contact info, copyright, scripts |
| `send.php` | Contact form POST handler (sanitize, validate, send via PHPMailer) |
| `smtp_config.php` | SMTP credentials (gitignored, not in repo) |
| `.htaccess` | Apache rewrite rules for clean URLs (strips .php extensions) |
| `phpmailer/` | Vendored PHPMailer library |
| `asset/js/theme.js` | Navbar scroll behavior, slider init, Animsition config, form AJAX |
| `asset/css/style.css` | Main theme styles |
| `asset/css/responsive.css` | Responsive breakpoints |

## SMTP Configuration

`smtp_config.php` is not tracked in git. To set up the contact form, create this file in the project root:

```php
<?php
define('SMTP_HOST', 'mail.peace-tower.com');
define('SMTP_PORT', 465);
define('SMTP_USER', 'info@peace-tower.com');
define('SMTP_PASS', '...');
define('SMTP_FROM', 'info@peace-tower.com');
define('SMTP_FROM_NAME', 'Peace Tower');
```

## Known Issues

- Laravel Blade templates exist in `/auth`, `/layouts`, and `/emails` directories but are not integrated with the active site. These appear to be scaffolding from a planned but unused Laravel integration.

## Adding a New Page

1. Create `newpage.php`
2. Include `header.php` at the top and `footer.php` at the bottom, following the pattern in existing pages
3. Add navigation links in `header.php` (both the desktop navbar and the mobile side menu)
