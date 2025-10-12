# Settings System Implementation

## Overview

A comprehensive settings management system has been implemented for the FeedMart POS admin portal. This allows administrators to configure system-wide settings that automatically reflect throughout the entire application.

---

## Features Implemented

### 1. System Settings
- **System Name**: Customize the application name displayed across all portals
- **System Logo**: Upload and manage custom logo (PNG, JPG, JPEG, SVG)
- **Default Currency**: Configure currency (KES, USD, EUR, GBP, UGX, TZS)

### 2. Profile Settings
- **Name**: Update admin's full name
- **Email**: Update login email address
- **Phone**: Update phone number (can be used for login)
- **Role Display**: View current user role

### 3. Security Settings
- **Password Change**: Update password with security requirements:
  - Minimum 8 characters
  - Must contain uppercase and lowercase letters
  - Must contain at least one number
  - Must contain at least one symbol

---

## Default Credentials

The system is seeded with a super admin account:

```
Email: admin@feedmart.com
Phone: +254700000000
Password: Admin@123
```

**IMPORTANT**: Change this password immediately after first login via Settings > Security.

---

## Technical Implementation

### Database Schema

**Table**: `settings`
```sql
- id (primary key)
- key (unique string)
- value (text)
- type (string: string, text, boolean, image, json, integer, float)
- description (text)
- timestamps
```

### Model: `App\Models\Setting`

**Key Methods**:
```php
Setting::get($key, $default)           // Get a setting value
Setting::set($key, $value, $type)      // Set a setting value
Setting::getAll()                      // Get all settings as array
Setting::clearCache()                  // Clear settings cache
Setting::systemName()                  // Get system name
Setting::currency()                    // Get system currency
Setting::currencySymbol()              // Get currency symbol
Setting::logo()                        // Get logo URL
```

**Caching**:
- Settings are cached for 1 hour to improve performance
- Cache is automatically cleared when settings are updated
- Individual setting caches: `setting_{key}`
- All settings cache: `all_settings`

### Controller: `App\Http\Controllers\Admin\SettingsController`

**Routes**:
```php
GET  /admin/settings                    // Display settings page
POST /admin/settings/system             // Update system settings
POST /admin/settings/profile            // Update profile
POST /admin/settings/password           // Update password
DELETE /admin/settings/logo             // Remove logo
```

### Views

**Main View**: `resources/views/admin/settings/index.blade.php`

Features:
- Tabbed interface (System, Profile, Security)
- Real-time validation
- Image preview for logo
- Success/error notifications
- Password requirements display

---

## Usage in Views

### Get System Name
```blade
{{ \App\Models\Setting::systemName() }}
```

### Get Currency
```blade
{{ \App\Models\Setting::currency() }}
{{ \App\Models\Setting::currencySymbol() }}
```

### Get Logo URL
```blade
<img src="{{ \App\Models\Setting::logo() }}" alt="Logo">
```

### Get Any Setting
```blade
{{ \App\Models\Setting::get('system_name', 'Default Name') }}
```

---

## File Storage

**Logo Storage**:
- Location: `storage/app/public/logos/`
- Public URL: `public/storage/logos/`
- Max size: 2MB
- Formats: PNG, JPG, JPEG, SVG

**Setup Required**:
```bash
php artisan storage:link
```

**Dynamic Logo Replacement**:
- Uploaded logos automatically replace the default logo throughout the system
- The `<x-application-logo>` component checks for custom logo first
- Falls back to default SVG if no custom logo exists
- Appears in 11 locations: admin sidebar, login pages, POS terminal, receipts, etc.
- See `LOGO_UPDATE_GUIDE.md` for complete logo documentation

---

## Integration with Existing System

### Updated Files:

1. **Sidebar Navigation** (`resources/views/admin/layouts/sidebar.blade.php:28`)
   - System name now dynamically loaded

2. **POS Receipt Modal** (`resources/views/pos/dashboard.blade.php:163`)
   - Receipt header uses dynamic system name

3. **Routes** (`routes/web.php:107-111`)
   - Added settings routes under admin middleware

### Navigation

Settings link added to admin sidebar:
- Location: System section (at bottom)
- Icon: Settings gear (rotates on hover)
- Active state: Highlights when on settings page

---

## Seeder

**SettingsSeeder** (`database/seeders/SettingsSeeder.php`)

Seeds default values:
- `system_name`: "FeedMart POS"
- `system_currency`: "KES"

Run seeder:
```bash
php artisan db:seed --class=SettingsSeeder
```

---

## Migration

**File**: `database/migrations/2025_10_12_182148_create_settings_table.php`

Run migration:
```bash
php artisan migrate
```

---

## Security Features

1. **Authentication Required**: All settings routes protected by `auth` and `admin` middleware
2. **Password Validation**: Strong password requirements enforced
3. **Current Password Verification**: Required to change password
4. **File Upload Validation**: Image type and size validation
5. **Unique Email/Phone**: Prevents duplicate user credentials
6. **Old File Cleanup**: Automatically deletes old logo when new one uploaded

---

## Performance Optimizations

1. **Caching**: Settings cached for 1 hour to reduce database queries
2. **Lazy Loading**: Settings only loaded when accessed
3. **Cache Clearing**: Automatic cache invalidation on updates
4. **Static Methods**: Fast access via `Setting::systemName()` etc.

---

## Future Enhancements (Optional)

Potential additions:
- Tax rate configuration
- Receipt template customization
- Email/SMS notification settings
- Backup/restore system settings
- Multi-language support
- Business hours configuration
- Receipt printer settings
- Invoice numbering format

---

## Testing Checklist

- [x] System name updates throughout application
- [x] Logo upload and display
- [x] Logo removal functionality
- [x] Currency change
- [x] Profile information update
- [x] Email change (with uniqueness validation)
- [x] Phone change (with uniqueness validation)
- [x] Password change with validation
- [x] Current password verification
- [x] Settings cache functionality
- [x] Navigation active state
- [x] Form validation and error display
- [x] Success messages
- [x] Responsive design
- [x] Database migrations
- [x] Seeders

---

## Troubleshooting

### Logo Not Displaying
1. Check storage link: `php artisan storage:link`
2. Verify file permissions on `storage/app/public/logos/`
3. Check file was uploaded successfully in database

### Settings Not Updating
1. Clear application cache: `php artisan cache:clear`
2. Clear settings cache specifically: `Setting::clearCache()`
3. Check database for updated values

### Password Change Failing
1. Verify current password is correct
2. Check new password meets requirements
3. Ensure password confirmation matches

---

## API Reference

### Setting Model Methods

#### `Setting::get(string $key, $default = null)`
Get a setting value by key with optional default.

**Example**:
```php
$name = Setting::get('system_name', 'FeedMart');
```

#### `Setting::set(string $key, $value, string $type = 'string', string $description = null)`
Set a setting value.

**Example**:
```php
Setting::set('system_name', 'My Store', 'string', 'Store Name');
```

#### `Setting::systemName(): string`
Get the system name (shortcut method).

#### `Setting::currency(): string`
Get the system currency code.

#### `Setting::currencySymbol(): string`
Get the currency symbol or code.

#### `Setting::logo(): string`
Get the logo URL or default placeholder.

#### `Setting::clearCache(): void`
Clear all settings from cache.

---

## Notes

- System name changes reflect immediately after cache clear/expiry
- Logo changes require page refresh to see updates
- Currency changes affect POS display and receipts
- Admin can update their own credentials without logging out
- Password changes do not invalidate current session

---

**Implementation Date**: October 12, 2025
**Laravel Version**: 12.x
**Author**: Claude Code
