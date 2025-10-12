# Logo Update Guide - FeedMart POS

## Overview

The FeedMart POS system now supports custom logo uploads that automatically replace the default logo throughout the entire application. This guide explains how the logo system works and where logos appear.

---

## How It Works

### **Dynamic Logo Component**

The `<x-application-logo>` component has been updated to:
1. Check if a custom logo exists in settings
2. Display the custom logo if available
3. Fall back to the default SVG logo if no custom logo is uploaded

**Component Logic**:
```blade
@php
    $customLogo = \App\Models\Setting::get('system_logo');
@endphp

@if($customLogo)
    <img src="{{ asset('storage/' . $customLogo) }}" alt="{{ \App\Models\Setting::systemName() }}" {{ $attributes }}>
@else
    <!-- Default SVG Logo -->
@endif
```

---

## Where Logos Appear

The custom logo automatically appears in **11 locations** across the application:

### **Admin Portal**
1. **Sidebar Header** - Left side navigation (40x40px)
2. **Admin Login Page** - Login form header
3. **Admin Layout** - Top navigation
4. **Admin Guest Layout** - Public pages

### **POS Portal**
5. **POS Navigation** - Terminal header
6. **POS Login Page** - Cashier login form
7. **POS Guest Layout** - Public pages
8. **POS App Layout** - Main terminal

### **Customer Portal**
9. **Main Navigation** - Customer dashboard
10. **Customer Login/Register** - Authentication pages
11. **Welcome Page** - Landing page

---

## Uploading a Custom Logo

### **Step-by-Step Instructions**

1. **Login as Admin**
   - Email: `admin@feedmart.com`
   - Password: `Admin@123` (change this!)

2. **Navigate to Settings**
   - Click "Settings" in the admin sidebar (gear icon at bottom)

3. **Upload Logo**
   - Go to "System Settings" tab (default)
   - Under "System Logo" section
   - Click "Choose File"
   - Select your logo image

4. **Logo Requirements**
   - **Formats**: PNG, JPG, JPEG, SVG
   - **Max Size**: 2MB
   - **Recommended Dimensions**: 200x200px to 400x400px
   - **Aspect Ratio**: Square (1:1) works best

5. **Save Settings**
   - Click "Save System Settings" button
   - Success message will appear
   - Logo will immediately appear throughout the system

---

## Managing Logos

### **Viewing Current Logo**

When a custom logo is uploaded, you'll see:
- Preview of current logo (64x64px thumbnail)
- File information
- "Remove Logo" button

### **Replacing a Logo**

To replace the current logo:
1. Simply upload a new logo file
2. Click "Save System Settings"
3. The old logo is automatically deleted
4. New logo takes effect immediately

### **Removing a Logo**

To revert to the default logo:
1. Click the red "Remove Logo" button
2. Confirm the deletion
3. Success message appears
4. Default SVG logo is restored

**Note**: Removing the logo deletes the file from storage and reverts all instances to the default agricultural-themed SVG logo.

---

## Logo Storage

### **File Storage Location**

- **Server Path**: `storage/app/public/logos/`
- **Public URL**: `public/storage/logos/`
- **Access URL**: `https://yoursite.com/storage/logos/filename.png`

### **File Naming**

Laravel automatically generates unique filenames to prevent conflicts:
```
logos/abc123def456.png
```

### **Storage Requirements**

Make sure the storage link exists:
```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`.

---

## Default Logo

### **Default SVG Logo Features**

The default logo is a custom agricultural-themed SVG that includes:
- Wheat/grain stalks (left)
- Shopping cart with grid pattern (right)
- Livestock icon (center)
- Harvest gold and agricultural green colors
- Scalable vector graphics (looks sharp at any size)

### **When Default Logo Appears**

The default logo shows when:
- No custom logo has been uploaded
- Custom logo has been removed
- Custom logo file is missing or deleted

---

## Technical Details

### **Settings Database**

Logo path stored in `settings` table:
```
key: system_logo
value: logos/abc123def456.png
type: image
```

### **Caching**

- Logo setting is cached for 1 hour
- Cache automatically cleared on upload/removal
- Force cache clear: `Setting::clearCache()`

### **Image Attributes**

The logo component accepts all standard image attributes:
```blade
<x-application-logo class="h-10 w-10" />
<x-application-logo class="h-16 w-16 rounded-full" />
```

These attributes are passed through using `{{ $attributes }}`.

---

## Logo Best Practices

### **Design Recommendations**

1. **Simple Design**: Logos should be clear and recognizable at small sizes
2. **Square Format**: 1:1 aspect ratio prevents distortion
3. **Transparent Background**: PNG with transparency works best
4. **Vector Preferred**: SVG files scale perfectly at any size
5. **High Contrast**: Ensure visibility on both light and dark backgrounds

### **Size Guidelines**

| Location | Typical Display Size | Recommended Upload Size |
|----------|---------------------|------------------------|
| Sidebar | 40x40px | 200x200px |
| Login Page | 80x80px | 400x400px |
| Navigation | 48x48px | 200x200px |

**Tip**: Upload at 2-4x the display size for retina/high-DPI screens.

### **File Formats Compared**

| Format | Pros | Cons | Best For |
|--------|------|------|----------|
| **PNG** | Transparency, lossless | Larger file size | Logos with transparency |
| **JPG** | Small file size | No transparency | Photos, no transparency needed |
| **SVG** | Perfect scaling, tiny | May not display complex effects | Simple vector logos |

---

## Troubleshooting

### **Logo Not Showing After Upload**

**Possible Causes:**
1. Storage link not created
   ```bash
   php artisan storage:link
   ```

2. Cache not cleared
   ```bash
   php artisan cache:clear
   ```

3. File permissions issue
   ```bash
   chmod -R 755 storage/app/public/logos
   ```

### **Logo Upload Fails**

**Check:**
1. File size under 2MB
2. Correct file format (PNG, JPG, JPEG, SVG)
3. Storage directory writable
4. PHP `upload_max_filesize` setting

### **Logo Appears Distorted**

**Solutions:**
1. Use square (1:1) aspect ratio images
2. Add `object-contain` or `object-cover` class
3. Upload higher resolution image

### **Old Logo Still Showing**

**Try:**
1. Clear browser cache (Ctrl+Shift+Delete)
2. Hard refresh page (Ctrl+F5)
3. Clear application cache:
   ```bash
   php artisan cache:clear
   Setting::clearCache()
   ```

---

## API Usage

### **Get Logo URL in Code**

```php
use App\Models\Setting;

// Get logo URL or default
$logoUrl = Setting::logo();

// Get raw setting value
$logoPath = Setting::get('system_logo');

// Full URL
$fullUrl = $logoPath ? asset('storage/' . $logoPath) : null;
```

### **In Blade Templates**

```blade
<!-- Using helper method -->
<img src="{{ \App\Models\Setting::logo() }}" alt="Logo">

<!-- Using component -->
<x-application-logo class="h-10 w-10" />

<!-- Manual check -->
@php
    $logo = \App\Models\Setting::get('system_logo');
@endphp
@if($logo)
    <img src="{{ asset('storage/' . $logo) }}" alt="Logo">
@endif
```

---

## Security Considerations

1. **File Type Validation**: Only image files accepted
2. **Size Limit**: 2MB maximum to prevent abuse
3. **Admin Only**: Only authenticated admins can upload
4. **Automatic Cleanup**: Old logos deleted when replaced
5. **Secure Storage**: Files stored outside public directory

---

## Examples

### **Upload Process**

```
User clicks "Choose File"
    → Selects "my-logo.png" (500x500, 150KB)
    → Clicks "Save System Settings"
    → Form validates (size OK, type OK)
    → Old logo deleted from storage
    → New logo stored as "logos/xyz789.png"
    → Database updated with new path
    → Cache cleared
    → Success message shown
    → Logo visible throughout app
```

### **Remove Process**

```
User clicks "Remove Logo" button
    → Confirmation dialog appears
    → User confirms deletion
    → File deleted from storage
    → Database record removed
    → Cache cleared
    → Success message shown
    → Default SVG logo restored
```

---

## Future Enhancements

Potential logo features to add:
- Multiple logo variants (dark mode, icon only)
- Favicon generation from logo
- Logo position/size customization
- Print-specific logo version
- Email template logo

---

## Summary

✅ **Custom logo system fully implemented**
✅ **Automatically replaces default logo everywhere**
✅ **Easy upload/remove via Settings page**
✅ **Supports PNG, JPG, JPEG, SVG**
✅ **Cached for performance**
✅ **Secure admin-only access**
✅ **Graceful fallback to default logo**

Your FeedMart POS system now has complete logo customization!

---

**Last Updated**: October 12, 2025
**Version**: 1.0
**Component**: `resources/views/components/application-logo.blade.php`
