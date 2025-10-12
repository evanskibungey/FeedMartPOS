# FeedMart POS - Architecture Documentation

## Executive Summary

FeedMart POS is a multi-tenant Point of Sale (POS) and inventory management system built with Laravel 12, designed specifically for agricultural feed retail businesses. The system features three distinct portals (Customer, Admin, and POS) with role-based access control, real-time inventory tracking, and comprehensive sales management.

---

## Table of Contents

1. [System Overview](#system-overview)
2. [Technology Stack](#technology-stack)
3. [Application Architecture](#application-architecture)
4. [Database Schema](#database-schema)
5. [User Roles & Access Control](#user-roles--access-control)
6. [Portal Architecture](#portal-architecture)
7. [Key Features & User Flows](#key-features--user-flows)
8. [Frontend Architecture](#frontend-architecture)
9. [Backend Architecture](#backend-architecture)
10. [Security Implementation](#security-implementation)
11. [Deployment Configuration](#deployment-configuration)

---

## 1. System Overview

### Business Domain
FeedMart POS is designed for agricultural feed stores selling products like animal feed in various packaging sizes (50kg bags, 10kg bags, etc.). The system manages:

- Product catalog with categories and brands
- Multi-supplier relationships
- Purchase orders and receiving
- Real-time inventory tracking
- Point of sale operations
- Sales reporting and analytics

### Core Capabilities
- Multi-portal architecture (Customer, Admin, POS)
- Role-based access control (Super Admin, Admin, Cashier, Customer)
- Real-time inventory management with stock movement tracking
- Purchase order workflow (draft → ordered → received)
- POS terminal with cart management
- Receipt generation and printing
- Low stock and reorder alerts

---

## 2. Technology Stack

### Backend
- **Framework**: Laravel 12.x
- **PHP Version**: ^8.2
- **Authentication**: Laravel Breeze 2.3
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Queue System**: Database-driven queues

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS 3.x (with custom agricultural theme)
- **JavaScript**: Vanilla JS (Alpine.js 3.4.2 available)
- **Build Tool**: Vite 7.0.7
- **Forms**: @tailwindcss/forms

### Development Tools
- **Package Manager**: Composer, NPM
- **Code Quality**: Laravel Pint
- **Testing**: PHPUnit 11.5.3
- **Dev Server**: Laravel Sail (Docker)
- **Logging**: Laravel Pail

### Server Environment
- **Web Server**: XAMPP (Apache)
- **Session Driver**: Database
- **Cache Driver**: Database
- **Queue Connection**: Database
- **Filesystem**: Local storage

---

## 3. Application Architecture

### Architectural Pattern
The application follows a **Model-View-Controller (MVC)** pattern with additional service layer for business logic.

```
┌─────────────────────────────────────────────────────────────┐
│                     CLIENT LAYER                            │
│  (Browser - Customer/Admin/POS Portal)                      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                   PRESENTATION LAYER                        │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐        │
│  │   Blade     │  │  Tailwind   │  │  Alpine.js  │        │
│  │  Templates  │  │     CSS     │  │   (optional)│        │
│  └─────────────┘  └─────────────┘  └─────────────┘        │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                   APPLICATION LAYER                         │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              ROUTES (web.php)                        │  │
│  │  /admin/*  |  /pos/*  |  /  (customer)              │  │
│  └──────────────────────────────────────────────────────┘  │
│                            │                                │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              MIDDLEWARE LAYER                        │  │
│  │  Auth | AdminMiddleware | POSMiddleware | Customer  │  │
│  └──────────────────────────────────────────────────────┘  │
│                            │                                │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              CONTROLLERS                             │  │
│  │  Admin/*, POS/*, ProfileController                  │  │
│  └──────────────────────────────────────────────────────┘  │
│                            │                                │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              SERVICE LAYER                           │  │
│  │  PortalRedirectService (Business Logic)             │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                     DATA LAYER                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              ELOQUENT MODELS                         │  │
│  │  User, Product, Sale, Category, Brand, etc.         │  │
│  └──────────────────────────────────────────────────────┘  │
│                            │                                │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              DATABASE (SQLite)                       │  │
│  │  Tables: users, products, sales, categories, etc.   │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

### Directory Structure

```
FeedMartPOS/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin portal controllers
│   │   │   ├── POS/            # POS terminal controllers
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── POSMiddleware.php
│   │   │   └── CustomerMiddleware.php
│   │   └── Requests/           # Form request validation
│   ├── Models/                 # Eloquent models
│   ├── Providers/              # Service providers
│   ├── Services/               # Business logic services
│   └── View/Components/        # Blade components
│
├── database/
│   ├── migrations/             # Database schema
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
│
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin portal views
│   │   ├── pos/                # POS terminal views
│   │   ├── auth/               # Authentication views
│   │   ├── components/         # Reusable components
│   │   └── layouts/            # Layout templates
│   ├── js/
│   │   ├── app.js              # Main JavaScript
│   │   └── bootstrap.js        # Bootstrap imports
│   └── css/
│
├── routes/
│   ├── web.php                 # Web routes
│   ├── auth.php                # Authentication routes
│   └── console.php             # Console routes
│
├── public/
│   └── storage/                # Publicly accessible storage
│
├── storage/
│   ├── app/
│   │   └── public/             # User uploads
│   └── logs/
│
└── config/                     # Configuration files
```

---

## 4. Database Schema

### Entity Relationship Overview

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│   Category   │◄───┐    │    Brand     │◄───┐    │   Supplier   │
└──────────────┘    │    └──────────────┘    │    └──────────────┘
                    │                        │           │
                    │                        │           │
                ┌───┴────────────────────────┴───┐      │
                │         Product                │      │
                │  - SKU, Barcode               │      │
                │  - Pricing (cost, retail)     │      │
                │  - Stock quantity             │◄─────┘
                │  - Reorder level              │  (Many-to-Many)
                └───────────────────────────────┘
                        │               │
                        │               │
          ┌─────────────┘               └─────────────┐
          ▼                                           ▼
┌──────────────────┐                    ┌──────────────────┐
│  PurchaseOrder   │                    │  StockMovement   │
│  - Status        │                    │  - Type (in/out) │
│  - Supplier      │                    │  - Quantity      │
└──────────────────┘                    │  - Reference     │
          │                             └──────────────────┘
          ▼
┌──────────────────┐
│PurchaseOrderItem │
│  - Product       │
│  - Quantity      │
│  - Unit price    │
└──────────────────┘

          ┌──────────────┐
          │     User     │
          │  - Role      │
          │  - is_active │
          └──────────────┘
                 │
                 ▼
          ┌──────────────┐
          │     Sale     │
          │  - Receipt # │
          │  - Totals    │
          │  - Payment   │
          └──────────────┘
                 │
                 ▼
          ┌──────────────┐
          │   SaleItem   │
          │  - Product   │
          │  - Quantity  │
          │  - Price     │
          └──────────────┘
```

### Core Tables

#### users
- **Purpose**: System users (super_admin, admin, cashier, customer)
- **Key Fields**: name, email, phone, password, role, is_active
- **Relationships**: Has many Sales

#### categories
- **Purpose**: Product categorization (e.g., Chicken Feed, Cattle Feed)
- **Key Fields**: name, description, status
- **Relationships**: Has many Products

#### brands
- **Purpose**: Product brands
- **Key Fields**: name, description, status
- **Relationships**: Has many Products

#### suppliers
- **Purpose**: Supplier management
- **Key Fields**: name, contact_person, email, phone, address, status
- **Relationships**: Belongs to many Products, Has many PurchaseOrders

#### products
- **Purpose**: Product catalog
- **Key Fields**:
  - sku (unique), barcode (unique)
  - name, description, unit
  - category_id, brand_id
  - quantity_in_stock, reorder_level
  - price (retail), wholesale_price, cost_price
  - tax_rate, status, image
- **Relationships**:
  - Belongs to Category, Brand
  - Belongs to many Suppliers
  - Has many SaleItems, PurchaseOrderItems, StockMovements

#### product_supplier (pivot table)
- **Purpose**: Many-to-many relationship between products and suppliers
- **Key Fields**: product_id, supplier_id, purchase_price, lead_time, is_preferred

#### purchase_orders
- **Purpose**: Purchase order workflow
- **Key Fields**:
  - po_number, supplier_id
  - status (draft, ordered, received, cancelled)
  - order_date, expected_delivery_date, received_date
  - total_amount, notes
- **Relationships**: Belongs to Supplier, Has many PurchaseOrderItems

#### purchase_order_items
- **Purpose**: Line items in purchase orders
- **Key Fields**: purchase_order_id, product_id, quantity, unit_price, total_price

#### stock_movements
- **Purpose**: Audit trail for inventory changes
- **Key Fields**:
  - product_id, user_id
  - type (in, out, adjustment)
  - quantity, reference, notes
- **Relationships**: Belongs to Product, User

#### sales
- **Purpose**: Sales transactions
- **Key Fields**:
  - receipt_number (unique)
  - user_id (cashier)
  - customer_name, customer_phone
  - subtotal, tax_amount, tax_rate, total_amount
  - payment_method (cash, mpesa, card, bank_transfer)
  - payment_reference, status, notes, sale_date
- **Relationships**: Belongs to User, Has many SaleItems

#### sale_items
- **Purpose**: Line items in sales
- **Key Fields**:
  - sale_id, product_id
  - product_name, product_sku (denormalized for history)
  - quantity, unit_price, subtotal

---

## 5. User Roles & Access Control

### Role Hierarchy

```
┌─────────────────────────────────────────────────────────────┐
│                      SUPER ADMIN                            │
│  - Full system access                                       │
│  - Can access Admin portal                                  │
│  - Can access POS portal                                    │
│  - User management                                          │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                        ADMIN                                │
│  - Can access Admin portal                                  │
│  - Can access POS portal                                    │
│  - Product, inventory, supplier management                  │
│  - Cannot manage super_admin users                          │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                       CASHIER                               │
│  - Can access POS portal only                               │
│  - Process sales                                            │
│  - View sales history                                       │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│                      CUSTOMER                               │
│  - Can access Customer portal only                          │
│  - View profile                                             │
│  - (Future: order history, online orders)                   │
└─────────────────────────────────────────────────────────────┘
```

### Role Methods (User Model)

```php
// Role checking
isSuperAdmin(): bool
isAdmin(): bool
isCashier(): bool
isCustomer(): bool

// Portal access
canAccessAdmin(): bool    // super_admin, admin
canAccessPOS(): bool      // super_admin, admin, cashier
```

### Middleware Protection

- **AdminMiddleware** (routes/web.php:54)
  - Checks authentication
  - Validates canAccessAdmin()
  - Verifies is_active status
  - Redirects unauthorized users to appropriate dashboard

- **POSMiddleware** (routes/web.php:122)
  - Checks authentication
  - Validates canAccessPOS()
  - Verifies is_active status
  - Redirects unauthorized users to appropriate dashboard

- **CustomerMiddleware** (routes/web.php:29)
  - Checks authentication
  - Validates customer role
  - Redirects non-customers

---

## 6. Portal Architecture

### Three-Portal Design

The application features three distinct portals, each with its own layout, navigation, and functionality:

#### 1. Customer Portal (/)

**Entry Points**:
- `/` - Welcome page
- `/dashboard` - Customer dashboard
- `/profile` - Profile management

**Layout**: `resources/views/layouts/app.blade.php`

**Features**:
- User registration and authentication
- Profile management
- (Future expansion: order history, online ordering)

**Routes**: `routes/web.php:24-37`

---

#### 2. Admin Portal (/admin)

**Entry Points**:
- `/admin/login` - Admin authentication
- `/admin/dashboard` - Main admin dashboard

**Layout**: `resources/views/admin/layouts/app.blade.php`

**Features**:
```
Admin Dashboard
├── User Management
│   ├── View all users
│   ├── Create/Edit users
│   ├── Toggle user status
│   └── Update passwords
│
├── Inventory Management
│   ├── Categories (CRUD + status toggle)
│   ├── Brands (CRUD + status toggle)
│   ├── Suppliers (CRUD + status toggle)
│   └── Products (CRUD + status toggle, image upload)
│
├── Purchase Orders
│   ├── Create draft POs
│   ├── Mark as ordered
│   ├── Receive items (updates stock)
│   └── Cancel orders
│
└── Inventory Reports
    ├── Current stock levels
    ├── Stock movements history
    ├── Low stock alerts
    └── Reorder report
```

**Controllers**: `app/Http/Controllers/Admin/`
- AdminDashboardController
- UserManagementController
- CategoryController
- BrandController
- SupplierController
- ProductController
- PurchaseOrderController
- InventoryController

**Routes**: `routes/web.php:45-105`

---

#### 3. POS Portal (/pos)

**Entry Points**:
- `/pos/login` - POS authentication
- `/pos/dashboard` - POS terminal

**Layout**: `resources/views/pos/layouts/app.blade.php`

**Features**:
```
POS Terminal
├── Product Selection
│   ├── Search products
│   ├── Filter by category
│   └── View stock availability
│
├── Cart Management
│   ├── Add/remove items
│   ├── Adjust quantities
│   ├── View subtotal/tax/total
│   └── Clear cart
│
├── Checkout
│   ├── Select payment method (Cash, M-Pesa)
│   ├── Process sale
│   ├── Generate receipt
│   └── Print receipt
│
├── Sales Management
│   ├── View sales history
│   ├── View individual receipts
│   └── Today's statistics
│
└── Real-time Stats
    ├── Today's sales total
    ├── Transaction count
    └── Items sold
```

**Controllers**: `app/Http/Controllers/POS/`
- POSDashboardController
- SaleController

**Routes**: `routes/web.php:113-132`

---

## 7. Key Features & User Flows

### 7.1 Product Management Flow (Admin)

```
Admin logs in → Admin Dashboard
    │
    ├─→ Navigate to Products → Products List
    │       │
    │       ├─→ Click "Add Product"
    │       │       ├─→ Fill form (SKU, name, category, brand, etc.)
    │       │       ├─→ Upload image (optional)
    │       │       ├─→ Set pricing (cost, retail, wholesale)
    │       │       ├─→ Set stock levels (quantity, reorder level)
    │       │       └─→ Submit → Product created
    │       │
    │       ├─→ Edit Product → Update fields → Save
    │       │
    │       ├─→ Toggle Status → Active/Inactive
    │       │
    │       └─→ Delete Product → Confirm → Removed
    │
    └─→ View Product Details
            ├─→ Product info
            ├─→ Supplier relationships
            └─→ Recent stock movements
```

**Controller**: `app/Http/Controllers/Admin/ProductController.php`

**Key Methods**:
- `index()`: List products with filters (category, brand, status, stock level, search)
- `create()`: Show product creation form
- `store()`: Validate and create product (handles image upload)
- `show()`: Display product details with relationships
- `edit()`: Show edit form
- `update()`: Validate and update product
- `destroy()`: Delete product and associated image
- `toggleStatus()`: Toggle active/inactive status

---

### 7.2 Purchase Order Workflow (Admin)

```
Create Purchase Order
    │
    ├─→ Admin Dashboard → Purchase Orders → Create PO
    │       ├─→ Select supplier
    │       ├─→ Add products (line items)
    │       ├─→ Set quantities and prices
    │       ├─→ Save as Draft
    │       └─→ PO created with status = "draft"
    │
    ├─→ Review Draft
    │       ├─→ Edit items if needed
    │       └─→ Mark as "Ordered"
    │               ├─→ Status changed to "ordered"
    │               └─→ order_date set
    │
    ├─→ Receive Items
    │       ├─→ Click "Receive" on ordered PO
    │       ├─→ Confirm received quantities
    │       ├─→ System updates:
    │       │       ├─→ PO status = "received"
    │       │       ├─→ Product stock quantities increased
    │       │       └─→ Stock movements created (type: "in")
    │       └─→ received_date set
    │
    └─→ Cancel Order (if needed)
            ├─→ Click "Cancel"
            ├─→ Status changed to "cancelled"
            └─→ No stock changes
```

**Controller**: `app/Http/Controllers/Admin/PurchaseOrderController.php`

**Key Methods**:
- `index()`: List all POs
- `drafts()`: List draft POs
- `create()`: Create new PO
- `store()`: Save PO
- `markAsOrdered()`: Change status to ordered
- `receive()`: Receive items and update stock
- `cancel()`: Cancel PO

---

### 7.3 POS Sale Transaction Flow

```
Cashier logs in → POS Dashboard
    │
    ├─→ View Today's Stats
    │       ├─→ Total sales
    │       ├─→ Transaction count
    │       └─→ Items sold
    │
    └─→ Process Sale
            │
            ├─→ Search/Browse Products
            │       ├─→ Filter by category
            │       ├─→ Search by name/SKU
            │       └─→ View stock availability
            │
            ├─→ Build Cart
            │       ├─→ Click product → Add to cart
            │       ├─→ Adjust quantities (+/-)
            │       ├─→ View real-time totals
            │       │       ├─→ Subtotal
            │       │       ├─→ Tax (16%)
            │       │       └─→ Total
            │       └─→ Remove items if needed
            │
            ├─→ Select Payment Method
            │       ├─→ Cash
            │       ├─→ M-Pesa
            │       ├─→ Card
            │       └─→ Bank Transfer
            │
            ├─→ Checkout (Click or press F9)
            │       ├─→ Frontend validation
            │       ├─→ Send to server (AJAX)
            │       │       ├─→ Validate stock availability
            │       │       ├─→ Lock products for update
            │       │       ├─→ Calculate totals
            │       │       ├─→ Create Sale record
            │       │       ├─→ Create SaleItems
            │       │       ├─→ Decrement stock
            │       │       ├─→ Create StockMovements
            │       │       └─→ Generate receipt number
            │       │
            │       └─→ Transaction complete
            │
            └─→ Display Receipt
                    ├─→ Receipt details shown in modal
                    ├─→ Print receipt (optional)
                    └─→ New Sale → Clear cart and reload
```

**Controller**: `app/Http/Controllers/POS/SaleController.php:20-167`

**Key Transaction Logic**:

```php
DB::beginTransaction();
try {
    // 1. Validate items and check stock
    foreach ($items as $item) {
        $product = Product::lockForUpdate()->findOrFail($item['product_id']);
        // Check status and stock availability
    }

    // 2. Calculate totals
    $subtotal = sum of all items
    $taxAmount = $subtotal * 0.16
    $totalAmount = $subtotal + $taxAmount

    // 3. Create Sale record
    $sale = Sale::create([...])

    // 4. Create SaleItems and update stock
    foreach ($items as $item) {
        SaleItem::create([...])
        $product->decrement('quantity_in_stock', $quantity)
        StockMovement::create(['type' => 'out', ...])
    }

    DB::commit();
} catch (Exception $e) {
    DB::rollBack();
    // Return error
}
```

**Receipt Number Format**: `RCP-YYYYMMDD-####`
- Example: `RCP-20251012-0001`

---

### 7.4 Inventory Tracking & Alerts (Admin)

```
Inventory Management
    │
    ├─→ Current Stock Levels
    │       ├─→ View all products
    │       ├─→ Filter by status (OK, Low, Out)
    │       └─→ Search products
    │
    ├─→ Stock Movements
    │       ├─→ View all movements (in/out/adjustment)
    │       ├─→ Filter by product, date, type
    │       └─→ Audit trail with user info
    │
    ├─→ Low Stock Alert
    │       ├─→ Products where quantity_in_stock <= reorder_level
    │       ├─→ Stock status badge (yellow warning)
    │       └─→ Quick link to create PO
    │
    ├─→ Reorder Report
    │       ├─→ Products needing reorder
    │       ├─→ Suggested order quantities
    │       └─→ Supplier information
    │
    └─→ Stock Adjustment
            ├─→ Manual stock adjustment form
            ├─→ Select product
            ├─→ Set new quantity
            ├─→ Add notes (reason for adjustment)
            └─→ Creates StockMovement (type: "adjustment")
```

**Controller**: `app/Http/Controllers/Admin/InventoryController.php`

**Stock Status Logic** (Product Model):

```php
public function getStockStatusAttribute(): string
{
    if ($this->isOutOfStock()) return 'out';      // qty <= 0
    if ($this->isLowStock()) return 'low';        // qty <= reorder_level
    return 'ok';
}
```

---

## 8. Frontend Architecture

### 8.1 Theming System

The application uses a custom agricultural-themed color palette built on Tailwind CSS:

**Custom Theme Configuration** (`tailwind.config.js:12-71`):

```javascript
colors: {
  // Harvest Gold (Primary)
  harvest: {
    50: '#fffbeb',
    100: '#fef3c7',
    // ... through 900
    500: '#f59e0b',
    600: '#d97706',
  },

  // Agricultural Green (Secondary)
  agri: {
    50: '#f0fdf4',
    100: '#dcfce7',
    // ... through 900
    500: '#22c55e',
    600: '#16a34a',
  }
}
```

**Gradient Utilities**:
- `.bg-gradient-harvest`: Gold gradient for primary actions
- `.bg-gradient-agri`: Green gradient for secondary actions
- `.shadow-harvest`, `.shadow-agri`: Themed shadows

**Animation Classes**:
- `.animate-fade-in-up`: Fade in with upward motion
- `.animate-slide-in-right`: Slide in from right

---

### 8.2 Layout Components

#### Admin Layout (`resources/views/admin/layouts/app.blade.php`)

```
┌─────────────────────────────────────────────────────────┐
│  TOPBAR (navigation.blade.php)                          │
│  - Logo                                                 │
│  - User menu                                            │
│  - Logout                                               │
├─────────────────────────────────────────────────────────┤
│                    │                                     │
│   SIDEBAR          │   MAIN CONTENT                     │
│   (sidebar.php)    │   (page content)                   │
│                    │                                     │
│   - Dashboard      │   {{ $slot }}                      │
│   - Users          │                                     │
│   - Products       │                                     │
│   - Inventory      │                                     │
│   - Purchase Orders│                                     │
│   - Suppliers      │                                     │
│   - Categories     │                                     │
│   - Brands         │                                     │
│                    │                                     │
└─────────────────────────────────────────────────────────┘
```

#### POS Layout (`resources/views/pos/layouts/app.blade.php`)

```
┌─────────────────────────────────────────────────────────┐
│  HEADER                                                 │
│  - POS Terminal title                                   │
│  - User info                                            │
│  - Date/Time                                            │
│  - Logout                                               │
├─────────────────────────────────────────────────────────┤
│                                                         │
│   MAIN CONTENT (full width)                            │
│   - Stats cards                                         │
│   - Product grid + Cart sidebar                        │
│                                                         │
│   {{ $slot }}                                           │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

### 8.3 POS Terminal Interface

**Component Architecture** (`resources/views/pos/dashboard.blade.php`):

```
┌─────────────────────────────────────────────────────────┐
│  STATS CARDS (Real-time)                                │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐          │
│  │ Today's   │  │ Trans-    │  │ Items     │          │
│  │ Sales     │  │ actions   │  │ Sold      │          │
│  │ KES X     │  │ Count     │  │ Count     │          │
│  └───────────┘  └───────────┘  └───────────┘          │
├─────────────────────────────────────────────────────────┤
│                                        │                │
│  PRODUCTS (2/3 width)                 │  CART (1/3)    │
│  ┌─────────────────────────┐          │  ┌──────────┐  │
│  │ Search + Category Filter│          │  │ Items: X │  │
│  └─────────────────────────┘          │  └──────────┘  │
│                                        │                │
│  ┌────┐ ┌────┐ ┌────┐ ┌────┐         │  ┌──────────┐  │
│  │Prod│ │Prod│ │Prod│ │Prod│         │  │ Item 1   │  │
│  │ 1  │ │ 2  │ │ 3  │ │ 4  │         │  │ +  2  -  │  │
│  │KES │ │KES │ │KES │ │KES │         │  │ KES X    │  │
│  └────┘ └────┘ └────┘ └────┘         │  └──────────┘  │
│  ┌────┐ ┌────┐ ┌────┐ ┌────┐         │                │
│  │... │ │... │ │... │ │... │         │  ┌──────────┐  │
│  └────┘ └────┘ └────┘ └────┘         │  │ Payment  │  │
│                                        │  │ [Cash]   │  │
│  (Grid, scrollable)                   │  │ [M-Pesa] │  │
│                                        │  └──────────┘  │
│                                        │                │
│                                        │  Subtotal: X  │
│                                        │  Tax (16%): X │
│                                        │  Total: X     │
│                                        │                │
│                                        │  [Checkout]   │
│                                        │  (F9)         │
└────────────────────────────────────────┴────────────────┘
```

**JavaScript Cart Management** (`resources/views/pos/dashboard.blade.php:246-495`):

Key Functions:
- `addToCart(productId, name, price, maxStock)`: Add item or increment quantity
- `removeFromCart(productId)`: Remove item from cart
- `updateQuantity(productId, change)`: Increment/decrement quantity
- `updateCart()`: Recalculate totals and update UI
- `clearCart()`: Empty cart
- `selectPaymentMethod(method)`: Switch payment method
- `proceedToCheckout()`: Process sale via AJAX
- `displayReceipt(sale)`: Show receipt modal
- `printReceipt()`: Print receipt
- `updateTodayStats()`: Refresh stats after sale

**Keyboard Shortcuts**:
- `F9`: Complete sale
- `Escape`: Close receipt modal

---

### 8.4 Reusable Blade Components

Located in `resources/views/components/`:

- `application-logo.blade.php`: App logo
- `primary-button.blade.php`: Primary action button
- `secondary-button.blade.php`: Secondary action button
- `danger-button.blade.php`: Destructive action button
- `text-input.blade.php`: Styled text input
- `input-label.blade.php`: Form label
- `input-error.blade.php`: Validation error display
- `nav-link.blade.php`: Navigation link
- `modal.blade.php`: Modal dialog
- `dropdown.blade.php`: Dropdown menu
- `auth-session-status.blade.php`: Session status messages

---

## 9. Backend Architecture

### 9.1 Controllers

#### Admin Controllers (`app/Http/Controllers/Admin/`)

**AdminDashboardController**
- `index()`: Display admin dashboard with stats

**UserManagementController**
- CRUD operations for users
- `toggleStatus()`: Activate/deactivate users
- `updatePassword()`: Change user passwords

**CategoryController**
- CRUD for categories
- `toggleStatus()`: Active/inactive

**BrandController**
- CRUD for brands
- `toggleStatus()`: Active/inactive

**SupplierController**
- CRUD for suppliers
- `toggleStatus()`: Active/inactive
- `show()`: View supplier details with products

**ProductController** (Key controller for inventory)
- Full CRUD with validation
- Image upload handling
- Stock status filtering
- Search functionality
- Product-supplier relationship management

**PurchaseOrderController**
- Create, edit, view POs
- `drafts()`: List draft POs
- `markAsOrdered()`: Change status to ordered
- `receive()`: Receive items and update stock
- `cancel()`: Cancel PO

**InventoryController**
- `index()`: Current stock levels
- `movements()`: Stock movement history
- `lowStock()`: Low stock report
- `reorderReport()`: Reorder suggestions
- `adjustStock()`: Manual adjustment form
- `processAdjustment()`: Process adjustment

#### POS Controllers (`app/Http/Controllers/POS/`)

**POSDashboardController**
- `index()`: Display POS terminal with products and stats

**SaleController**
- `store()`: Process sale transaction (with DB transaction)
- `index()`: Sales history
- `show()`: Individual sale details
- `todayStats()`: Real-time stats for current day

---

### 9.2 Models & Relationships

#### Product Model (`app/Models/Product.php`)

**Relationships**:
```php
belongsTo(Category::class)
belongsTo(Brand::class)
belongsToMany(Supplier::class)->withPivot('purchase_price', 'lead_time', 'is_preferred')
hasMany(StockMovement::class)
hasMany(PurchaseOrderItem::class)
hasMany(SaleItem::class)
```

**Accessors**:
- `getSellingPriceAttribute()`: Alias for price
- `getImageUrlAttribute()`: Full image URL
- `getStockStatusAttribute()`: Calculate stock status (ok/low/out)

**Methods**:
- `isLowStock()`: Check if quantity <= reorder_level
- `isOutOfStock()`: Check if quantity <= 0

**Scopes**:
- `scopeActive($query)`: Filter active products
- `scopeLowStock($query)`: Filter low stock
- `scopeOutOfStock($query)`: Filter out of stock

#### Sale Model (`app/Models/Sale.php`)

**Relationships**:
```php
belongsTo(User::class)  // Cashier
hasMany(SaleItem::class)
```

**Methods**:
- `generateReceiptNumber()`: Generate unique receipt (RCP-YYYYMMDD-####)

**Scopes**:
- `scopeToday($query)`: Filter today's sales
- `scopeCompleted($query)`: Filter completed sales

**Accessors**:
- `getTotalItemsAttribute()`: Sum of all item quantities

#### User Model (`app/Models/User.php`)

**Relationships**:
```php
hasMany(Sale::class)
```

**Methods**:
- `isSuperAdmin()`, `isAdmin()`, `isCashier()`, `isCustomer()`
- `canAccessAdmin()`: Check admin portal access
- `canAccessPOS()`: Check POS portal access

**Scopes**:
- `scopeActive($query)`: Filter active users

---

### 9.3 Services

**PortalRedirectService** (`app/Services/PortalRedirectService.php`)

Centralized service for handling cross-portal redirects based on user role:

```php
getDashboardRoute(): string
    // Returns appropriate dashboard route based on user role
    - super_admin, admin → 'admin.dashboard'
    - cashier → 'pos.dashboard'
    - customer → 'dashboard'

getRedirectMessage(string $attemptedPortal): string
    // Returns friendly message explaining redirect
```

Used by middleware to provide graceful redirects instead of 403 errors.

---

### 9.4 Validation & Security

#### Form Request Validation

Products (ProductController.php:83-99):
```php
'name' => 'required|string|max:255'
'sku' => 'required|string|max:255|unique:products'
'category_id' => 'required|exists:categories,id'
'quantity_in_stock' => 'required|integer|min:0'
'price' => 'required|numeric|min:0'
'image' => 'nullable|image|max:2048'
'barcode' => 'nullable|string|max:255|unique:products'
// etc.
```

Sales (SaleController.php:23-33):
```php
'items' => 'required|array|min:1'
'items.*.product_id' => 'required|exists:products,id'
'items.*.quantity' => 'required|integer|min:1'
'items.*.price' => 'required|numeric|min:0'
'payment_method' => 'required|in:cash,mpesa,card,bank_transfer'
```

#### Database Transactions

Sales processing uses DB transactions with row-level locking:

```php
DB::beginTransaction();
try {
    $product = Product::lockForUpdate()->findOrFail($id);
    // Process sale
    DB::commit();
} catch (Exception $e) {
    DB::rollBack();
}
```

This prevents race conditions when multiple POS terminals sell the same product simultaneously.

---

## 10. Security Implementation

### 10.1 Authentication

- **System**: Laravel Breeze (session-based)
- **Driver**: Database sessions
- **Password Hashing**: bcrypt (12 rounds)
- **CSRF Protection**: Enabled on all POST/PUT/PATCH/DELETE routes

### 10.2 Authorization

**Middleware Stack**:
1. `auth`: Verify user is authenticated
2. `admin`/`pos`/`customer`: Verify role-based access
3. Check `is_active` status

**Access Control**:
- Admin portal requires `canAccessAdmin()` = true
- POS portal requires `canAccessPOS()` = true
- Inactive users are logged out automatically

### 10.3 Input Validation

- All form inputs validated via `$request->validate()`
- File uploads restricted to images, max 2MB
- SQL injection prevented by Eloquent ORM
- XSS protection via Blade automatic escaping

### 10.4 Data Protection

- Passwords hashed with bcrypt
- Sensitive data (payment references) stored securely
- Database stored in `database/database.sqlite`
- User uploads stored in `storage/app/public/products/`

---

## 11. Deployment Configuration

### 11.1 Environment Setup

**Database** (.env:23):
```
DB_CONNECTION=sqlite
```

**Session** (.env:30):
```
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

**Queue** (.env:38):
```
QUEUE_CONNECTION=database
```

**Cache** (.env:40):
```
CACHE_STORE=database
```

### 11.2 Storage

**Product Images**:
- Stored in: `storage/app/public/products/`
- Accessed via: `public/storage/products/`
- Symlink required: `php artisan storage:link`

### 11.3 Seeders

Database seeding for initial setup (`database/seeders/`):

1. **SuperAdminSeeder**: Create initial super admin user
2. **CategorySeeder**: Seed product categories
3. **BrandSeeder**: Seed product brands
4. **SupplierSeeder**: Seed suppliers
5. **ProductSeeder**: Seed sample products

**Run Seeders**:
```bash
php artisan db:seed
```

### 11.4 Development Commands

**Start Development Server** (composer.json:54-56):
```bash
composer run dev
```
Runs concurrently:
- Laravel dev server (port 8000)
- Queue worker
- Log viewer (Pail)
- Vite dev server

**Run Tests**:
```bash
composer test
```

**Clear Cache**:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Appendix A: Route Reference

### Customer Routes
```
GET  /                          → welcome page
GET  /dashboard                 → customer dashboard (auth, customer)
GET  /profile                   → profile edit (auth, customer)
```

### Admin Routes (Prefix: /admin)
```
GET   /admin/login              → admin login page
POST  /admin/login              → process admin login
GET   /admin/dashboard          → admin dashboard (auth, admin)
POST  /admin/logout             → admin logout

Resource routes:
/admin/users                    → UserManagementController
/admin/categories               → CategoryController
/admin/brands                   → BrandController
/admin/suppliers                → SupplierController
/admin/products                 → ProductController
/admin/purchase-orders          → PurchaseOrderController

Inventory routes:
GET   /admin/inventory                    → current stock
GET   /admin/inventory/movements          → stock movements
GET   /admin/inventory/low-stock          → low stock alert
GET   /admin/inventory/reorder-report     → reorder report
GET   /admin/inventory/adjust             → adjustment form
POST  /admin/inventory/adjust             → process adjustment
```

### POS Routes (Prefix: /pos)
```
GET   /pos/login                 → POS login page
POST  /pos/login                 → process POS login
GET   /pos/dashboard             → POS terminal (auth, pos)
POST  /pos/logout                → POS logout

Sales routes:
POST  /pos/sales                 → process sale (AJAX)
GET   /pos/sales                 → sales history
GET   /pos/sales/{sale}          → sale details
GET   /pos/sales/today/stats     → today's stats (AJAX)
```

---

## Appendix B: Key Files Reference

### Controllers
- Admin controllers: `app/Http/Controllers/Admin/*.php` (9 files)
- POS controllers: `app/Http/Controllers/POS/*.php` (3 files)
- Customer controllers: `app/Http/Controllers/ProfileController.php`

### Models
- `app/Models/User.php`: User with role-based methods
- `app/Models/Product.php`: Product with stock tracking
- `app/Models/Sale.php`: Sales with receipt generation
- `app/Models/Category.php`, `Brand.php`, `Supplier.php`
- `app/Models/PurchaseOrder.php`, `PurchaseOrderItem.php`
- `app/Models/StockMovement.php`, `SaleItem.php`

### Migrations
- `database/migrations/2025_01_15_000004_create_products_table.php`
- `database/migrations/2025_01_15_000009_create_sales_table.php`
- And 8 more migration files

### Views
- Admin layouts: `resources/views/admin/layouts/*.blade.php`
- POS layouts: `resources/views/pos/layouts/*.blade.php`
- Admin views: `resources/views/admin/**/*.blade.php` (30+ files)
- POS views: `resources/views/pos/*.blade.php`

### Middleware
- `app/Http/Middleware/AdminMiddleware.php`
- `app/Http/Middleware/POSMiddleware.php`
- `app/Http/Middleware/CustomerMiddleware.php`

### Configuration
- `tailwind.config.js`: Custom theme configuration
- `vite.config.js`: Build configuration
- `composer.json`: Backend dependencies
- `package.json`: Frontend dependencies
- `.env`: Environment configuration

---

## Conclusion

FeedMart POS is a well-architected Laravel application with clear separation of concerns:

1. **Multi-Portal Design**: Three distinct user experiences (Customer, Admin, POS)
2. **Role-Based Access**: Four user roles with granular permissions
3. **Real-Time Inventory**: Stock tracking with automatic updates on sales and receiving
4. **Transaction Safety**: Database transactions with row-level locking
5. **Modern UI**: Tailwind CSS with custom agricultural theme
6. **Extensible**: Service layer for business logic, easy to add new features

The system is production-ready for agricultural feed retail businesses, with room for expansion (e.g., online ordering for customers, reporting dashboard, multi-location support).

---

**Document Version**: 1.0
**Last Updated**: October 12, 2025
**Application Version**: Laravel 12 (FeedMart POS)
