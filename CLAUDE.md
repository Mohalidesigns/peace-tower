# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Peace Tower is a marketing website for a luxury residential building in Ikoyi, Lagos, Nigeria. It is a static PHP site with no framework, no database, and no build step.

## Running Locally

Serve via XAMPP (or any PHP-capable web server) with the document root at this directory. Pages are accessed directly by filename (e.g., `/aboutus`, `/interior`). PHP's built-in `mail()` function is used by the contact form, so a mail server or SMTP relay must be configured for form submissions to work.

## Architecture

**Template pattern:** Each page (index.php, aboutus.php, interior.php, exterior.php, floorplan.php, contact-us.php) includes `header.php` and `footer.php` via PHP `include`. There is no routing framework; URLs map directly to PHP files.

**Form handling:** `contact-us.php` POSTs to `send.php`, which sanitizes input with `filter_input()`, validates the email, sends via `mail()` to `info@peace-tower.com`, and redirects to `thank-you.html` on success.

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
| `send.php` | Contact form POST handler (sanitize, validate, mail) |
| `asset/js/theme.js` | Navbar scroll behavior, slider init, Animsition config, form AJAX |
| `asset/css/style.css` | Main theme styles |
| `asset/css/responsive.css` | Responsive breakpoints |

## Known Issues

- `theme.js` contains an AJAX form handler that posts to `mail.php`, which does not exist. The actual form handler is `send.php` (used via standard form POST, not AJAX).
- Laravel Blade templates exist in `/auth`, `/layouts`, and `/emails` directories but are not integrated with the active site. These appear to be scaffolding from a planned but unused Laravel integration.

## Adding a New Page

1. Create `newpage.php`
2. Include `header.php` at the top and `footer.php` at the bottom, following the pattern in existing pages
3. Add navigation links in `header.php` (both the desktop navbar and the mobile side menu)
