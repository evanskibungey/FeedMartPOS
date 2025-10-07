# Developer Quick Reference - Inventory System

## 🚀 Quick Start Commands

```bash
# Run migrations
php artisan migrate

# Link storage for images
php artisan storage:link

# Clear cache (if needed)
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 📍 Key Routes Reference

### Categories
- `GET /admin/categories` - List all categories
- `GET /admin/categories/create` - Create form
- `POST /admin/categories` - Store new category
- `GET /admin/categories/{id}/edit` - Edit form
- `PUT /admin/categories/{id}` - Update category
- `DELETE /admin/categories/{id}` - Delete category
- `POST /admin/categories/{id}/toggle-status` - Toggle active status

### Brands
- `GET /admin/brands` - List all brands
- `GET /admin/brands/create` - Create form
- `POST /admin/brands` - Store new brand (supports file upload)
- `GET /admin/brands/{id}/edit` - Edit form
- `PUT /admin/brands/{id}` - Update brand (supports file upload)
- `DELETE /admin/brands/{id}` - Delete brand
- `POST /admin/brands/{id}/toggle-status` - Toggle active status

### Suppliers
- `GET /admin/suppliers` - List all suppliers
- `GET /admin/suppliers/create` - Create form
- `POST /admin/suppliers` - Store new supplier
- `GET /admin/suppliers/{id}` - View supplier details
- `GET /admin/suppliers/{id}/edit` - Edit form
- `PUT /admin/suppliers/{id}` - Update supplier
- `DELETE /admin/suppliers/{id}` - Delete supplier
- `POST /admin/suppliers/{id}/toggle-status` - Toggle active status

### Products
- `GET /admin/products` - List all products (with filters)
- `GET /admin/products/create` - Create form
- `POST /admin/products` - Store new product (supports image upload)
- `GET /admin/products/{id}` - View product details
- `GET /admin/products/{id}/edit` - Edit form
- `PUT /admin/products/{id}` - Update product (supports image upload)
- `DELETE /admin/products/{id}` - Delete product
- `POST /admin/products/{id}/toggle-status` - Toggle active/inactive

### Purchase Orders
- `GET /admin/purchase-orders` - List all purchase orders
- `GET /admin/purchase-orders/create` - Create form
- `POST /admin/purchase-orders` - Store new PO
- `GET /admin/purchase-orders/{id}` - View PO details
- `GET /admin/purchase-orders/{id}/edit` - Edit form (draft only)
- `PUT /admin/purchase-orders/{id}` - Update PO (draft only)
- `DELETE /admin/purchase-orders/{id}` - Delete PO (draft only)
- `POST /admin/purchase-orders/{id}/mark-ordered` - Mark as ordered
- `POST /admin/purchase-orders/{id}/receive` - Receive items
- `POST /admin/purchase-orders/{id}/cancel` - Cancel PO

### Inventory
- `GET /admin/inventory` - Inventory dashboard
- `GET /admin/inventory/movements` - Stock movements log
- `GET /admin/inventory/low-stock` - Low stock report
- `GET /admin/inventory/reorder-report` - Reorder report
- `GET /admin/inventory/products/{id}/adjust` - Stock adjustment form
- `POST /admin/inventory/products/{id}/adjust` - Process adjustment

---

## 🔍 Model Methods Reference

### Product Model

```php
// Check stock status
$product->isLowStock();        // Returns bool
$product->isOutOfStock();      // Returns bool
$product->stock_status;        // Returns 'ok', 'low', or 'out'

// Relationships
$product->category;            // BelongsTo
$product->brand;               // BelongsTo
$product->suppliers;           // BelongsToMany
$product->stockMovements;      // HasMany
$product->purchaseOrderItems;  // HasMany

// Scopes
Product::active()->get();      // Only active products
Product::lowStock()->get();    // Products at or below reorder level
Product::outOfStock()->get();  // Products with zero stock
```

### PurchaseOrder Model

```php
// Calculate total
$purchaseOrder->calculateTotal();

// Mark as received
$purchaseOrder->markAsReceived();

// Relationships
$purchaseOrder->supplier;      // BelongsTo
$purchaseOrder->creator;       // BelongsTo (User)
$purchaseOrder->items;         // HasMany

// Scopes
PurchaseOrder::draft()->get();     // Draft POs
PurchaseOrder::ordered()->get();   // Ordered POs
PurchaseOrder::received()->get();  // Received POs
```

### PurchaseOrderItem Model

```php
// Calculate subtotal
$item->calculateSubtotal();

// Check if fully received
$item->isFullyReceived();      // Returns bool

// Get remaining quantity
$item->remaining_quantity;      // Calculated attribute

// Relationships
$item->purchaseOrder;          // BelongsTo
$item->product;                // BelongsTo
```

### StockMovement Model

```php
// Relationships
$movement->product;            // BelongsTo
$movement->user;               // BelongsTo

// Scopes
StockMovement::stockIn()->get();    // Only 'in' movements
StockMovement::stockOut()->get();   // Only 'out' movements
StockMovement::adjustment()->get(); // Only 'adjustment' movements
```

---

## 📝 Form Data Structures

### Create Product
```php
[
    'name' => 'Dairy Meal 70kg',
    'sku' => 'DM70',
    'category_id' => 1,
    'brand_id' => 1,
    'description' => 'High protein dairy feed',
    'unit' => '70kg bag',
    'quantity_in_stock' => 100,
    'reorder_level' => 20,
    'price' => 4500.00,              // Retail
    'wholesale_price' => 4200.00,    // Optional
    'cost_price' => 3800.00,         // Purchase cost
    'image' => $file,                // Optional
    'barcode' => '1234567890',       // Optional
    'tax_rate' => 16.00,             // Percentage
    'status' => 'active'
]
```

### Create Purchase Order
```php
[
    'supplier_id' => 1,
    'order_number' => 'PO-2025-0001',
    'order_date' => '2025-01-15',
    'expected_date' => '2025-01-20',  // Optional
    'notes' => 'Urgent order',        // Optional
    'items' => [
        [
            'product_id' => 1,
            'quantity_ordered' => 50,
            'purchase_price' => 3800.00
        ],
        [
            'product_id' => 2,
            'quantity_ordered' => 30,
            'purchase_price' => 2500.00
        ]
    ]
]
```

### Receive Purchase Order
```php
[
    'items' => [
        [
            'item_id' => 1,              // PurchaseOrderItem ID
            'quantity_received' => 50
        ],
        [
            'item_id' => 2,
            'quantity_received' => 25    // Partial receive
        ]
    ]
]
```

### Stock Adjustment
```php
[
    'adjustment_type' => 'add',      // 'add', 'remove', or 'set'
    'quantity' => 10,
    'notes' => 'Found 10 bags in storage'
]
```

---

## 🎨 View Data Available

### Products Index
```php
$products      // Paginated products with category and brand
$categories    // All active categories
$brands        // All active brands
```

### Purchase Orders Index
```php
$purchaseOrders  // Paginated POs with supplier and creator
$suppliers       // All active suppliers
```

### Inventory Index
```php
$products      // Paginated products with filters
$categories    // All active categories
$brands        // All active brands
$stats         // Array with:
               //   - total_products
               //   - low_stock
               //   - out_of_stock
               //   - total_value
```

---

## 🔒 Business Rules

### Product Deletion
- ❌ Cannot delete if linked to purchase orders
- ❌ Cannot delete if has stock movements
- ✅ Can delete if no dependencies

### Category/Brand Deletion
- ❌ Cannot delete if has products
- ✅ Can delete if no products linked

### Supplier Deletion
- ❌ Cannot delete if has purchase orders
- ✅ Can delete if no purchase orders

### Purchase Order Rules
- ✅ Draft POs can be edited/deleted
- ❌ Ordered POs cannot be edited
- ❌ Received POs cannot be edited
- ✅ Can receive items partially
- ✅ Auto-marks as received when all items fully received

### Stock Movement Rules
- ✅ Automatic on PO receiving
- ✅ Manual adjustments allowed
- ✅ All movements logged with user
- ✅ Cannot be deleted (audit trail)

---

## 🎯 Common Queries

### Get all low-stock products
```php
$lowStock = Product::with(['category', 'brand'])
    ->lowStock()
    ->get();
```

### Get products by category
```php
$products = Product::where('category_id', $categoryId)
    ->active()
    ->get();
```

### Get supplier's products
```php
$supplier = Supplier::with('products')->find($id);
$products = $supplier->products;
```

### Get product stock history
```php
$movements = StockMovement::where('product_id', $productId)
    ->with('user')
    ->latest()
    ->get();
```

### Get pending purchase orders
```php
$pending = PurchaseOrder::whereIn('status', ['draft', 'ordered'])
    ->with(['supplier', 'items.product'])
    ->get();
```

### Calculate inventory value
```php
$totalValue = Product::sum(DB::raw('quantity_in_stock * cost_price'));
```

---

## 🐛 Common Issues & Solutions

### Issue: Images not uploading
```bash
# Solution: Link storage
php artisan storage:link
```

### Issue: Validation errors on product create
```php
// Make sure at least one of these is provided:
'image' => 'nullable|image|max:2048',  // Max 2MB
'barcode' => 'nullable|string|unique:products',
```

### Issue: Purchase order total not calculating
```php
// After adding items, call:
$purchaseOrder->calculateTotal();
```

### Issue: Stock not updating on receive
```php
// Make sure to use the receive endpoint:
POST /admin/purchase-orders/{id}/receive
// Not just updating the purchase_order_items directly
```

---

## 📊 Sample Data Flow

### Complete Purchase Flow
1. **Admin creates category**: "Poultry Feed"
2. **Admin creates brand**: "Unga Farm Care"
3. **Admin creates supplier**: "Unga Limited"
4. **Admin creates product**: "Layers Mash 50kg"
   - Initial stock: 0
   - Reorder level: 20
   - Cost: KES 3,000
   - Price: KES 3,500
5. **Admin creates purchase order**:
   - Supplier: Unga Limited
   - Product: Layers Mash 50kg
   - Quantity: 100 bags
   - Status: Draft
6. **Admin marks as ordered**: Status → Ordered
7. **Supplier delivers**: Admin receives 100 bags
8. **System automatically**:
   - Updates product stock: 0 → 100
   - Creates stock movement record
   - Marks PO as received
9. **When sales happen**: Stock decreases (handled by POS/sales module)
10. **When stock hits reorder level**: Shows in low-stock report

---

## 🎨 Design System Classes

Use existing design system from DESIGN_SYSTEM_REFERENCE.md:

```php
// Buttons
'btn-harvest'   // Harvest amber gradient (admin actions)
'btn-agri'      // Agriculture green (success/primary)

// Stat Cards
'stat-card stat-card-harvest'  // Amber border
'stat-card stat-card-agri'     // Green border
'stat-card stat-card-earth'    // Brown border

// Badges
'badge badge-success'   // Green (active/ok)
'badge badge-warning'   // Amber (low stock)
'badge bg-red-100 text-red-800'  // Red (out of stock)

// Gradients
'bg-gradient-harvest'  // Admin theme
'bg-gradient-agri'     // Success theme
```

---

## 🧪 Testing Checklist

- [ ] Migrations run successfully
- [ ] Can create category
- [ ] Can create brand with logo
- [ ] Can create supplier
- [ ] Can create product with image
- [ ] Can create draft purchase order
- [ ] Can mark PO as ordered
- [ ] Can receive PO and stock updates
- [ ] Can adjust stock manually
- [ ] Stock movements are logged
- [ ] Low stock report shows correct items
- [ ] Cannot delete category with products
- [ ] Cannot edit ordered PO
- [ ] Product filters work correctly
- [ ] Search works for products

---

## 📞 Support

For questions about the inventory system:
1. Check INVENTORY_IMPLEMENTATION.md for detailed documentation
2. Review DESIGN_SYSTEM_REFERENCE.md for UI components
3. Check Laravel documentation for framework questions
4. Review model relationships in models directory

---

**Last Updated**: January 15, 2025
**Version**: 1.0
**Status**: Backend Complete - Views Pending
