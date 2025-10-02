# FeedMart POS - Design System Quick Reference

## 🎨 Color Usage Guide

### When to Use Each Color

#### Agriculture Green (agri-*)
- ✅ Primary actions (Save, Submit, Confirm)
- ✅ Success messages and states
- ✅ Active/online indicators
- ✅ Growth-related metrics
- ✅ Main user portal elements

#### Harvest Amber (harvest-*)
- ✅ Admin portal elements
- ✅ Warning messages
- ✅ Important highlights
- ✅ Financial/revenue metrics
- ✅ Administrative actions

#### Earth Brown (earth-*)
- ✅ Secondary elements
- ✅ Natural/organic indicators
- ✅ Inventory/product related
- ✅ Neutral status indicators

#### Sky Blue (sky-*)
- ✅ POS/Cashier portal elements
- ✅ Information messages
- ✅ Transaction indicators
- ✅ Customer-related elements
- ✅ Read-only information

## 🔘 Button Component Examples

### Primary Action Button (Green)
```blade
<button class="btn-agri">
    <svg class="w-5 h-5 mr-2">...</svg>
    Save Changes
</button>
```

### Admin Action Button (Amber)
```blade
<button class="btn-harvest">
    <svg class="w-5 h-5 mr-2">...</svg>
    Manage Settings
</button>
```

### Secondary Button
```blade
<x-secondary-button>
    Cancel
</x-secondary-button>
```

### Danger/Delete Button
```blade
<x-danger-button>
    Delete Item
</x-danger-button>
```

## 📊 Stat Card Examples

### Green Stat Card
```blade
<div class="stat-card stat-card-agri">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-600 text-sm font-medium mb-1">Total Sales</p>
            <p class="text-3xl font-bold text-gray-800">₱12,450</p>
        </div>
        <div class="h-16 w-16 bg-gradient-agri rounded-xl flex items-center justify-center text-white">
            <svg class="w-8 h-8">...</svg>
        </div>
    </div>
</div>
```

### Amber Stat Card
```blade
<div class="stat-card stat-card-harvest">
    <!-- Same structure, different color -->
</div>
```

## 🏷️ Badge Examples

### Success Badge
```blade
<span class="badge badge-success">Active</span>
```

### Warning Badge
```blade
<span class="badge badge-warning">Pending</span>
```

### Info Badge
```blade
<span class="badge badge-info">Processing</span>
```

### Custom Color Badge
```blade
<span class="badge bg-purple-100 text-purple-800">
    Premium
</span>
```

## 📦 Card Component Examples

### Standard Card
```blade
<div class="card">
    <div class="card-header">
        <h3 class="text-lg font-semibold">Card Title</h3>
    </div>
    <div class="card-body">
        <p>Card content goes here...</p>
    </div>
</div>
```

### Card with Actions
```blade
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h3 class="text-lg font-semibold">Recent Orders</h3>
        <a href="#" class="text-white hover:underline">View All</a>
    </div>
    <div class="card-body">
        <!-- Content -->
    </div>
</div>
```

## 📝 Form Input Examples

### Text Input with Icon
```blade
<div>
    <x-input-label for="email" value="Email Address" />
    <div class="relative mt-2">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400">...</svg>
        </div>
        <x-text-input id="email" class="pl-12" type="email" name="email" placeholder="you@example.com" />
    </div>
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>
```

### Select Dropdown
```blade
<div>
    <x-input-label for="role" value="User Role" />
    <select id="role" name="role" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl mt-2">
        <option value="admin">Administrator</option>
        <option value="cashier">Cashier</option>
        <option value="customer">Customer</option>
    </select>
</div>
```

## 🎭 Icon-Enhanced Elements

### Navigation Link with Icon
```blade
<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
    <div class="flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span>Dashboard</span>
    </div>
</x-nav-link>
```

### List Item with Icon
```blade
<div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-agri-50">
    <div class="h-10 w-10 rounded-full bg-agri-100 flex items-center justify-center">
        <svg class="w-5 h-5 text-agri-600">...</svg>
    </div>
    <div>
        <p class="text-sm font-semibold text-gray-800">Item Title</p>
        <p class="text-xs text-gray-600">Item description</p>
    </div>
</div>
```

## 📱 Responsive Patterns

### Grid Layout
```blade
<!-- Mobile: 1 column, Tablet: 2 columns, Desktop: 4 columns -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Items -->
</div>
```

### Flex Layout
```blade
<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between">
    <div>Left content</div>
    <div>Right content</div>
</div>
```

## 🎬 Animation Classes

### Fade In Up (Page Content)
```blade
<main class="animate-fade-in-up">
    <!-- Content appears with upward motion -->
</main>
```

### Slide In Right (Stat Cards)
```blade
<div class="grid gap-6 animate-slide-in-right">
    <!-- Cards slide in from left -->
</div>
```

### Hover Scale (Interactive Elements)
```blade
<div class="transform hover:scale-105 transition-transform duration-300">
    <!-- Grows on hover -->
</div>
```

### Hover Translate (Buttons)
```blade
<button class="transform hover:-translate-y-0.5 transition-all duration-200">
    <!-- Lifts up on hover -->
</button>
```

## 🎨 Gradient Backgrounds

### Green Gradient
```blade
<div class="bg-gradient-agri">
    <!-- Agriculture green gradient -->
</div>
```

### Amber Gradient
```blade
<div class="bg-gradient-harvest">
    <!-- Harvest amber gradient -->
</div>
```

### Brown Gradient
```blade
<div class="bg-gradient-earth">
    <!-- Earth brown gradient -->
</div>
```

### Custom Gradient
```blade
<div class="bg-gradient-to-br from-sky-400 to-sky-600">
    <!-- Sky blue gradient -->
</div>
```

## 📊 Table Styling

### Modern Table
```blade
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">
                    Column Header
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <tr class="hover:bg-agri-50/30 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                    Cell content
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

## 🔔 Alert/Notification Patterns

### Success Alert
```blade
<div class="bg-agri-50 border-l-4 border-agri-500 p-4 rounded-lg shadow-sm">
    <div class="flex items-center">
        <svg class="h-6 w-6 text-agri-600 mr-3">...</svg>
        <span class="text-agri-800 font-medium">Success message</span>
    </div>
</div>
```

### Error Alert
```blade
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
    <div class="flex items-center">
        <svg class="h-6 w-6 text-red-600 mr-3">...</svg>
        <span class="text-red-800 font-medium">Error message</span>
    </div>
</div>
```

## 👤 Avatar Patterns

### Gradient Avatar
```blade
<div class="h-12 w-12 rounded-full bg-gradient-agri flex items-center justify-center text-white font-semibold text-lg shadow-md">
    {{ substr($user->name, 0, 1) }}
</div>
```

### Avatar with Status
```blade
<div class="relative">
    <div class="h-12 w-12 rounded-full bg-gradient-agri flex items-center justify-center text-white font-semibold">
        J
    </div>
    <span class="absolute bottom-0 right-0 h-3 w-3 bg-agri-500 border-2 border-white rounded-full"></span>
</div>
```

## 🎯 Common SVG Icons

### Dashboard Icon
```svg
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
</svg>
```

### Users Icon
```svg
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
</svg>
```

### Shopping Cart Icon
```svg
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
</svg>
```

## 💡 Pro Tips

1. **Consistency**: Always use the defined color classes rather than custom colors
2. **Spacing**: Use Tailwind's spacing scale (space-x-2, space-y-4, etc.)
3. **Hover States**: Always add hover effects to interactive elements
4. **Icons**: Include icons with buttons and links for better UX
5. **Loading States**: Add disabled states with opacity-50
6. **Mobile First**: Design for mobile, then enhance for desktop
7. **Accessibility**: Always include proper ARIA labels and alt text

## 🚀 Performance

1. Only import what you need from Tailwind
2. Use `@apply` sparingly in CSS
3. Prefer Tailwind utility classes over custom CSS
4. Optimize images and SVGs
5. Use lazy loading for images

---

**Quick Access**: Keep this file handy when developing new features!
