# WP Rocket E2E Test Helper

A WordPress plugin that assists in running [Playwright](https://playwright.dev/) end-to-end (E2E) tests for the [WP Rocket](https://wp-rocket.me/) caching plugin efficiently and reliably.

---

## Overview

The **WP Rocket E2E Test Helper** plugin provides a dedicated admin interface and a set of utilities that Playwright test suites can interact with to:

- Verify that WP Rocket cache files are generated correctly.
- Simulate different WP Rocket filter return values without modifying the codebase.
- Track WP Rocket version information required by upgrade/downgrade test scenarios.
- Surface WP Rocket–related warnings and errors from `debug.log` directly in the WordPress admin.

---

## Requirements

- **WordPress** 5.0 or higher
- **PHP** 7.4 or higher
- **WP Rocket** installed (the helper plugin will display a warning if WP Rocket is not active, and some features will return `false` results)
- **Composer** (for development / dependency installation)

---

## Installation

### From source

1. Clone or download this repository into your WordPress plugins directory:

   ```bash
   git clone https://github.com/wp-media/wp-rocket-e2e-test-helper.git wp-content/plugins/wp-rocket-e2e-test-helper
   ```

2. Install PHP dependencies with Composer:

   ```bash
   cd wp-content/plugins/wp-rocket-e2e-test-helper
   composer install --no-dev
   ```

3. Activate the plugin from the WordPress admin under **Plugins**, or via WP-CLI:

   ```bash
   wp plugin activate wp-rocket-e2e-test-helper
   ```

### From a ZIP archive

Upload and activate the plugin ZIP through **Plugins → Add New → Upload Plugin** in the WordPress admin.

---

## Admin Page

After activation, the plugin adds a page under **Tools → Rocket E2E Tests** in the WordPress admin.

The page is organized into tabs, each corresponding to a WP Rocket feature area:

| Tab | Description |
|-----|-------------|
| **Cache** | Displays the result of cache-generation test cases |
| **Tools** | Provides version-tracking actions and their test results |
| **Filters** | Allows configuring which value each supported WP Rocket filter should return |
| File Optimization, CDN, Media, Preload, … | Reserved tabs for additional feature test cases |

> **Note:** Only users with the `install_plugins` capability can access this page.

---

## Features

### Cache Testing

The **Cache** tab runs the following test cases and displays a `true`/`false` result for each:

| Test Case ID | Description |
|---|---|
| `should_generate_cache_files_for_logged-in_users` | Verifies that WP Rocket generates per-user cache files when *Cache for Logged-in Users* is enabled. |
| `should_generate_cache_files` | Verifies that standard visitor cache files exist for the configured test paths. |
| `should_use_same_cache_set_user_when_common_cache_is_enabled` | Verifies that when *Common Cache for Logged-in Users* is enabled, only one shared cache directory is used instead of per-user directories. |

Cache presence is checked against two default test paths:
- `consequatur-non-qui-facilis`
- `alias-vel-provident-quo`

These paths can be overridden using the `rocket_e2e_cache_test_paths` filter (see [Hooks](#hooks) below).

---

### Filter Simulation

The **Filters** tab lets you set a return value for specific WP Rocket filters. Playwright tests can then assert the expected behavior of WP Rocket when those filters are active — without needing to deploy custom code on the test environment.

Supported filters:

| Filter | Available Return Values |
|--------|------------------------|
| `rocket_post_purge_urls` | `default`, `false`, `null`, `0`, `""`, `2.5`, `15`, `["yy",0,True]` |
| `rocket_exclude_post_taxonomy` | `default`, `category`, `post_tag`, `product_cat` |
| `rocket_rocket_insights_enabled` | `false`, `true` |

The selected values are saved to the `wpr_e2e_config` WordPress option and applied by the plugin's filter hooks at runtime.

**Default values on activation:**

| Filter | Default |
|--------|---------|
| `rocket_post_purge_urls` | `default` |
| `rocket_exclude_post_taxonomy` | `default` |
| `rocket_rocket_insights_enabled` | `false` |

---

### Version Tracking (Tools Tab)

The **Tools** tab provides a **Save last major version** button. Clicking it stores the current `WP_ROCKET_LASTVERSION` constant value in the plugin's option (`wpr_e2e_config → rocket_last_major_version`).

The tab also displays a test case:

| Test Case ID | Description |
|---|---|
| `wpr_last_major_version_equals_current` | Returns `true` when the stored last major version matches the currently installed `WP_ROCKET_VERSION`. |

This is useful in upgrade/rollback test scenarios to confirm WP Rocket properly updates its version markers.

---

### Debug Log Notices

If `WP_DEBUG` and `WP_DEBUG_LOG` are both enabled, the plugin automatically scans `wp-content/debug.log` on every admin page load and displays an admin notice when WP Rocket–related entries are found.

Patterns detected:
- `/plugins/wp-rocket/`
- `wpr_rucss_used_css`
- `wpr_rocket_cache`

---

### Bundled Helper Plugins

The `helper-plugin/` directory contains small ZIP-packaged plugins that can be installed in the test environment to simulate specific conditions:

| Plugin | Purpose |
|--------|---------|
| `force-wp-mobile.zip` | Forces WordPress to treat requests as coming from a mobile device |
| `rocket-lcp-delay.zip` | Introduces an artificial delay for Largest Contentful Paint (LCP) testing |
| `show-time.zip` | Outputs the current server time, useful for cache age assertions |

---

## Plugin Option

All configuration is stored in a single WordPress option: **`wpr_e2e_config`**.

| Key | Description |
|-----|-------------|
| `rocket_post_purge_urls` | Simulated return value for the `rocket_post_purge_urls` filter |
| `rocket_exclude_post_taxonomy` | Simulated return value for the `rocket_exclude_post_taxonomy` filter |
| `rocket_rocket_insights_enabled` | Simulated return value for the `rocket_rocket_insights_enabled` filter |
| `rocket_last_major_version` | Last saved WP Rocket major version (set via the Tools tab) |

The option is **deleted automatically** when the plugin is deactivated.

---

## Hooks

### Filter: `rocket_e2e_cache_test_paths`

Overrides the default list of URL paths used to verify cache file generation.

```php
add_filter( 'rocket_e2e_cache_test_paths', function( array $paths ): array {
    return [
        'my-custom-page',
        'another-page',
    ];
} );
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$paths` | `string[]` | Array of URL path segments to check inside the WP Rocket cache directory |

**Returns:** `string[]`

---

## Usage in Playwright Tests

Playwright tests can interact with the helper plugin in two main ways:

### 1. Reading test case results

Navigate to the helper plugin admin page and query element IDs that correspond to test case identifiers:

```js
// Example: check cache generation for logged-in users
const result = await page.locator('#should_generate_cache_files_for_logged-in_users').textContent();
expect(result).toBe('Returned True');
```

### 2. Setting filter simulation values

Use the Filters tab form or send a direct `POST` request to `admin-post.php` with the desired values before running a test:

```js
await page.goto('/wp-admin/tools.php?page=rocket_e2e_tests_helper');
await page.selectOption('#rocket_post_purge_urls', 'false_return');
await page.click('button[type="submit"]');
```

### 3. Saving the last major version

Click the button in the Tools tab to snapshot the current WP Rocket version:

```js
await page.goto('/wp-admin/tools.php?page=rocket_e2e_tests_helper');
await page.click('#save_last_major_version');
```

---

## License

This plugin is licensed under the [GNU General Public License v2.0 or later](LICENSE).