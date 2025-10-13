# Quick Implementation Guide - Dynamic Pricing Feature

## What Changed?

### Database
- Added 2 new columns to `products` table:
  - `min_selling_price` - Minimum allowed price
  - `max_selling_price` - Maximum allowed price (default selling price)

### Backend
- **Product Model**: Added price range methods and validation
- **Admin Controller**: Now requires min/max prices when creating/editing products
- **POS Controller**: Validates prices are within range during checkout
- **New API Endpoint**: `/pos/products/{id}` - Returns product with price range

### What You Need to Do

## Step 1: Run Migration
```bash
cd C:\xampp\htdocs\FeedMartPOS
php artisan migrate
```

This will:
- Add the new columns
- Set existing products: `max_selling_price = price`, `min_selling_price = cost_price`

## Step 2: Update Admin Product Forms

Find your product create/edit blade files (likely in `resources/views/admin/products/`) and add these fields after the "price" field:

```html
<!-- Minimum Selling Price -->
<div class="mb-4">
    <label class="block text-sm font-medium mb-2">
        Minimum Selling Price (KES) <span class="text-red-500">*</span>
    </label>
    <input 
        type="number" 
        step="0.01" 
        min="0"
        name="min_selling_price" 
        value="{{ old('min_selling_price', $product->min_selling_price ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required
    >
    <p class="text-xs text-gray-500 mt-1">Lowest price allowed during sales</p>
    @error('min_selling_price')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<!-- Maximum Selling Price -->
<div class="mb-4">
    <label class="block text-sm font-medium mb-2">
        Maximum Selling Price (KES) <span class="text-red-500">*</span>
    </label>
    <input 
        type="number" 
        step="0.01" 
        min="0"
        name="max_selling_price" 
        value="{{ old('max_selling_price', $product->max_selling_price ?? $product->price ?? '') }}"
        class="w-full border rounded px-3 py-2"
        required
    >
    <p class="text-xs text-gray-500 mt-1">Standard retail price (highest allowed)</p>
    @error('max_selling_price')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
```

## Step 3: Update POS Cart Interface

### Option A: Simple Implementation
Update your cart to include price ranges in product data when adding items:

```javascript
// In your existing cart JavaScript
function addToCart(productId) {
    // Fetch product with price range
    fetch(`/pos/products/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const product = data.product;
                
                // Add to cart with price range info
                cart.push({
                    id: product.id,
                    name: product.name,
                    quantity: 1,
                    price: product.default_selling_price,
                    min_price: product.min_selling_price,
                    max_price: product.max_selling_price,
                    unit: product.unit,
                    stock: product.quantity_in_stock
                });
                
                updateCartDisplay();
            }
        });
}
```

### Option B: Full Implementation with Price Editing

Add price input field for each cart item:

```html
<!-- In your cart display -->
<div class="cart-item">
    <div>{{ item.name }}</div>
    <div>
        Qty: <input type="number" v-model="item.quantity" min="1">
    </div>
    <div>
        Price: 
        <input 
            type="number" 
            v-model="item.price" 
            :min="item.min_price" 
            :max="item.max_price"
            step="0.01"
            @change="validatePrice(item)"
        >
        <small>Range: KES {{ item.min_price }} - {{ item.max_price }}</small>
    </div>
    <div>Subtotal: KES {{ (item.quantity * item.price).toFixed(2) }}</div>
</div>
```

```javascript
function validatePrice(item) {
    if (item.price < item.min_price) {
        alert(`Price cannot be lower than KES ${item.min_price}`);
        item.price = item.min_price;
    }
    if (item.price > item.max_price) {
        alert(`Price cannot be higher than KES ${item.max_price}`);
        item.price = item.max_price;
    }
}
```

## Step 4: Test Everything

### Test Admin Panel:
1. Create a new product
   - Set min price: 4500
   - Set max price: 5000
   - Verify it saves successfully

2. Try invalid values:
   - Set min: 5000, max: 4500 (should fail)
   - Should see validation error

### Test POS:
1. Add product to cart at default price
2. Try adjusting price within range (should work)
3. Try setting price below minimum (should be rejected)
4. Complete a sale with adjusted price
5. Check sale_items table to verify custom price was saved

## Quick Reference

### New Product Model Methods
```php
// Check if price is valid
$product->isPriceValid(4800); // returns true/false

// Get price range
$product->price_range; // ['min' => 4500, 'max' => 5000, 'default' => 5000]

// Get min/max directly
$product->min_price; // 4500 (or cost_price if not set)
$product->max_price; // 5000 (or price if not set)
```

### API Endpoint
```
GET /pos/products/{id}

Response:
{
    "success": true,
    "product": {
        "id": 1,
        "name": "Product Name",
        "min_selling_price": 4500.00,
        "max_selling_price": 5000.00,
        "default_selling_price": 5000.00,
        "price_range": {
            "min": "4,500.00",
            "max": "5,000.00",
            "currency": "KES"
        },
        ...
    }
}
```

### Sale Submission Format
```javascript
{
    items: [
        {
            product_id: 1,
            quantity: 2,
            price: 4750.00  // Custom price (within min-max range)
        }
    ],
    payment_method: "cash",
    ...
}
```

## Troubleshooting

**Q: Migration fails?**
A: Make sure you're in the project directory and database is running

**Q: Existing products don't have min/max prices?**
A: Run: `UPDATE products SET min_selling_price = cost_price, max_selling_price = price WHERE min_selling_price IS NULL;`

**Q: POS rejects all prices?**
A: Check that products have min/max set, or verify fallback to cost_price and price

**Q: Want to disable price editing temporarily?**
A: Just make the price field readonly in your POS interface HTML

## Files Modified Summary

✅ Database migration created
✅ Product model updated
✅ ProductController (Admin) updated
✅ SaleController (POS) updated
✅ POSDashboardController updated
✅ Routes updated
✅ Documentation created

## Next Actions

1. ✅ Run migration
2. ⏳ Update admin product forms (HTML/Blade)
3. ⏳ Update POS cart interface (JavaScript)
4. ⏳ Test thoroughly
5. ⏳ Train staff on new feature

Need help? Check `DYNAMIC_PRICING_FEATURE.md` for detailed documentation.
