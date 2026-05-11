# Simple Text Insert By KWWD

Simple Text Insert is a lightweight WordPress plugin that lets you define reusable text snippets — HTML, shortcodes, or plain text — and insert them into the editor with a single click. Works with both the **Classic Editor (TinyMCE)** and **Gutenberg block editor**.

## Features

- **Unlimited Snippets** — Create as many text snippets as you need from the Settings page
- **Classic Editor Support** — Paste-icon button in the TinyMCE toolbar with a dropdown of all snippets
- **Gutenberg Block Support** — Each snippet registers as its own block under the Widgets category; search by name in the block inserter
- **Editable Per Post** — In Gutenberg, the inserted content appears in an editable textarea; change it per-post without affecting the original snippet
- **Shortcode & HTML Ready** — Supports any content your post body accepts: shortcodes, styled HTML, disclaimers, image credits, etc.
- **Simple Settings** — Manage everything from **Settings → Simple Text Insert**

## Requirements

- WordPress 6.0+ (for Gutenberg block support)
- Classic Editor plugin (optional — the TinyMCE button works with or without it)

## Installation

1. Upload the `kwwd-simple-text-insert` folder to `/wp-content/plugins/` or use the "Upload Plugins" interface 
2. Activate the plugin through the **Plugins** screen
3. Go to **Settings → Simple Text Insert** to add your snippets

## Usage

### Classic Editor

A paste-icon button appears in the TinyMCE toolbar. Click it to expand a dropdown, then select a snippet to insert its text at the cursor position.

### Gutenberg

Open the block inserter (the **+** button) and search for your snippet's name. Each snippet is a block in the **Widgets** category. When inserted, the content appears in an editable textarea.

## Snippet Examples

```
[author-post-bio style="grey"]
```

```html
<div class="PhotoCredit">
  <strong>Featured Image:</strong>
  <a href="#Link" target="_blank" rel="nofollow">Link Text</a>
</div>
[disclaimer]
```

## Changelog

### 1.2.2
- Standardised variable names and captialisation across functions

### 1.2.1
- Added the README.md file
- Minor text changes to ensure consistency across the plugin

### 1.2.0
- Gutenberg blocks are now editable per post (content shows in a textarea)
- Fixed API version for WP 6.9+ compatibility
- Generated unique slugs to prevent block name collisions
- Refactored data passing to use wp_localize_script

### 1.1.0
- Added Gutenberg block editor support (each snippet as a block + variations)
- Moved shared data injection to main plugin file

### 1.0.0
- Initial release with Classic Editor (TinyMCE) support

## License

GPL v3+
