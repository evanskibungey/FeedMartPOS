# Dynamic Pricing Feature Implementation

## Overview
This document describes the implementation of the dynamic pricing feature that allows POS users to adjust product selling prices within a defined range during sale transactions.

## Feature Summary
- **Minimum Selling Price**: The lowest allowable price for a product
- **Maximum Selling Price (Current Selling Price)**: The highest allowable price for a product
- **Price Adjustment**: POS users can modify the selling price for individual items in a cart, as long as it stays within the min-max range

## Database Changes

### New Migration
**File**: `database/migrations/2025_10_13_000001_add_price_range_to_products_table.php`

**New Columns Added to `products` Table**:
1. `min_selling_price` (decimal 10,2, nullable) - Minimum allowable selling price
2. `max_selling_price` (decimal 10,2, nullable) - Maximum allowable selling price (current selling price)

**Migration Behavior**:
- For existing products without these values:
  - `max_selling_price` is set to the current `price`
  - `min_selling_price` is set to the `cost_price`
- This ensures backward compatibility

### To Run the Migration
```bash
php artisan migrate
```

## Model Updates

### Product Model Enhancements
**File**: `app/Models/Product.php`

#### New Fillable Fields
- `min_selling_price`
- `max_selling_price`

#### New Cast Definitions
- Both fields are cast to `decimal:2`

#### New Accessor Methods

1. **`getSellingPriceAttribute()`**
   - Returns `max_selling_price` if set, otherwise falls back to `price`
   - This maintains backward compatibility

2. **`getPriceRangeAttribute()`**
   - Returns an array with min, max, and default prices
   ```php
   [
       'min' => $this->min_selling_price,
       'max' => $this->max_selling_price ?? $this->price,
       'default' => $this->max_selling_price ?? $this->price,
   ]
   ```

3. **`isPriceValid(float $price): bool`**
   - Validates if a given price is within the allowed range
   - Uses `cost_price` as fallback for min if `min_selling_price` is null
   - Uses `price` as fallback for max if `max_selling_price` is null

4. **`getMinPriceAttribute()`**
   - Returns minimum allowed selling price
   - Falls back to `cost_price` if not set

5. **`getMaxPriceAttribute()`**
   - Returns maximum allowed selling price
   - Falls back to `price` if not set

## Controller Updates

### 1. ProductController (Admin)
**File**: `app/Http/Controllers/Admin/ProductController.php`

#### Changes in `store()` method:
Added validation rules:
```php
'min_selling_price' => ['required', 'numeric', 'min:0', 'lte:max_selling_price'],
'max_selling_price' => ['required', 'numeric', 'min:0', 'gte:min_selling_price'],
```

#### Changes in `update()` method:
Same validation rules as `store()`

**Validation Rules Explanation**:
- `lte:max_selling_price` - Ensures minimum is less than or equal to maximum
- `gte:min_selling_price` - Ensures maximum is greater than or equal to minimum

### 2. SaleController (POS)
**File**: `app/Http/Controllers/POS/SaleController.php`

#### Enhanced Price Validation in `store()` method:

**Step 1**: Retrieve product with row-level locking
```php
$product = Product::lockForUpdate()->findOrFail($item['product_id']);
```

**Step 2**: Calculate price boundaries
```php
$minPrice = $product->min_selling_price ?? $product->cost_price;
$maxPrice = $product->max_selling_price ?? $product->price;
```

**Step 3**: Validate submitted price
```php
if ($item['price'] < $minPrice) {
    throw ValidationException::withMessages([
        'items' => "Price for '{$product->name}' cannot be lower than the minimum selling price of KES " . number_format($minPrice, 2)
    ]);
}

if ($item['price'] > $maxPrice) {
    throw ValidationException::withMessages([
        'items' => "Price for '{$product->name}' cannot be higher than the maximum selling price of KES " . number_format($maxPrice, 2)
    ]);
}
```

**Error Messages**:
- Clear, user-friendly messages
- Include product name and formatted price limits
- Currency-specific (KES)

### 3. POSDashboardController
**File**: `app/Http/Controllers/POS/POSDashboardController.php`

#### New Method: `getProduct($id)`

**Purpose**: Provides product details including price range for POS interface

**Route**: `GET /pos/products/{id}`

**Response Structure**:
```json
{
    "success": true,
    "product": {
        "id": 1,
        "name": "Product Name",
        "sku": "SKU-001",
        "category": "Category Name",
        "brand": "Brand Name",
        "unit": "50kg bag",
        "quantity_in_stock": 100,
        "price": 5000.00,
        "min_selling_price": 4500.00,
        "max_selling_price": 5000.00,
        "default_selling_price": 5000.00,
        "tax_rate": 16.00,
        "image_url": "http://example.com/storage/products/image.jpg",
        "price_range": {
            "min": "4,500.00",
            "max": "5,000.00",
            "currency": "KES"
        }
    }
}
```

## Routes

### New Route Added
**File**: `routes/web.php`

```php
Route::get('/products/{id}', [POSDashboardController::class, 'getProduct'])
    ->name('pos.products.show');
```

**Full Path**: `/pos/products/{id}`
**Method**: GET
**Middleware**: auth, pos
**Purpose**: Fetch product details including price range for POS cart functionality

## Frontend Integration Guide

### Adding Product to Cart (JavaScript Example)

```javascript
// When adding product to cart
async function addToCart(productId) {
    try {
        // Fetch product details including price range
        const response = await fetch(`/pos/products/${productId}`);
        const data = await response.json();
        
        if (data.success) {
            const product = data.product;
            
            // Add to cart with default price
            cartItems.push({
                product_id: product.id,
                name: product.name,
                quantity: 1,
                price: product.default_selling_price, // Use default (max) price
                min_price: product.min_selling_price,
                max_price: product.max_selling_price,
                stock: product.quantity_in_stock
            });
            
            updateCartDisplay();
        }
    } catch (error) {
        console.error('Error adding product to cart:', error);
    }
}
```

### Price Adjustment UI (JavaScript Example)

```javascript
// Allow user to adjust price
function adjustItemPrice(cartIndex, newPrice) {
    const item = cartItems[cartIndex];
    
    // Client-side validation
    if (newPrice < item.min_price) {
        alert(`Price cannot be lower than KES ${formatNumber(item.min_price)}`);
        return false;
    }
    
    if (newPrice > item.max_price) {
        alert(`Price cannot be higher than KES ${formatNumber(item.max_price)}`);
        return false;
    }
    
    // Update price
    item.price = newPrice;
    updateCartDisplay();
    return true;
}
```

### Submitting Sale with Custom Prices

```javascript
// Submit sale to backend
async function processSale() {
    const saleData = {
        items: cartItems.map(item => ({
            product_id: item.product_id,
            quantity: item.quantity,
            price: item.price // Custom price within allowed range
        })),
        payment_method: selectedPaymentMethod,
        customer_name: customerName,
        customer_phone: customerPhone,
        notes: saleNotes
    };
    
    try {
        const response = await fetch('/pos/sales', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(saleData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Sale completed successfully
            showReceipt(result.sale);
            clearCart();
        } else {
            // Handle validation errors
            alert(result.message);
        }
    } catch (error) {
        console.error('Error processing sale:', error);
    }
}
```

## Business Logic Flow

### When Adding a Product

1. Admin creates/edits product in admin panel
2. Sets:
   - **Minimum Selling Price**: Lowest acceptable price (e.g., KES 4,500)
   - **Maximum Selling Price**: Standard retail price (e.g., KES 5,000)
3. Validation ensures min ≤ max
4. Product is saved with price range

### When Making a Sale (POS)

1. Cashier adds product to cart
2. Product appears with **default price** (max_selling_price)
3. Cashier can adjust price for specific customer/situation
4. Price adjustment UI shows:
   - Current price (editable)
   - Minimum allowed price
   - Maximum allowed price
5. On submission:
   - Backend validates each item's price
   - Rejects transaction if any price is out of range
   - Shows specific error message with product name and limits
6. If all validations pass:
   - Sale is processed normally
   - Stock is deducted
   - Stock movement is recorded
   - Sale record stores the actual price used

## Use Cases

### Use Case 1: Regular Sale at Maximum Price
- Customer buys product at standard retail price
- No price adjustment needed
- Default max_selling_price is used

### Use Case 2: Bulk Purchase Discount
- Customer buys large quantity
- Cashier adjusts price down (e.g., from KES 5,000 to KES 4,700)
- System validates: 4,700 ≥ 4,500 (min) ✓
- Sale proceeds at discounted price

### Use Case 3: VIP Customer Discount
- VIP customer gets special pricing
- Cashier can reduce price within allowed range
- Transaction tracked with actual sale price

### Use Case 4: Attempt to Sell Below Minimum
- Cashier tries to set price to KES 4,200
- System rejects: 4,200 < 4,500 (min) ✗
- Error message displayed
- Sale cannot proceed until price is corrected

### Use Case 5: Promotional Pricing
- Admin temporarily adjusts min/max range for promotion
- All sales during promotion use new range
- After promotion, admin resets to original range

## Security & Data Integrity

### Price Validation Layers

1. **Client-side validation** (Optional, for UX)
   - Immediate feedback to user
   - Not relied upon for security

2. **Server-side validation** (Required, enforced)
   - `SaleController@store()` validates every item
   - Uses database row locking to prevent race conditions
   - Rejects entire transaction if any item fails validation

3. **Database constraints**
   - Admin panel enforces min ≤ max during product creation/edit
   - Validation rules: `lte:max_selling_price` and `gte:min_selling_price`

### Audit Trail

- **sale_items table** stores actual price used for each sale
- **stock_movements table** records each transaction
- Complete history of pricing for reporting and analysis

## Backward Compatibility

### Existing Products
- Migration automatically sets:
  - `max_selling_price` = current `price`
  - `min_selling_price` = current `cost_price`
- No manual data entry required

### Legacy Code
- `$product->selling_price` still works (uses max_selling_price or price)
- Existing views and reports continue functioning
- Gradual rollout possible

## Admin Panel Form Updates Needed

### Product Create/Edit Forms
You'll need to update your admin product forms to include the new fields:

```blade
<!-- Minimum Selling Price -->
<div class="form-group">
    <label for="min_selling_price">Minimum Selling Price (KES) *</label>
    <input type="number" 
           step="0.01" 
           min="0"
           name="min_selling_price" 
           id="min_selling_price"
           class="form-control @error('min_selling_price') is-invalid @enderror"
           value="{{ old('min_selling_price', $product->min_selling_price ?? '') }}"
           required>
    <small class="form-text text-muted">Lowest price allowed when making sales</small>
    @error('min_selling_price')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<!-- Maximum Selling Price -->
<div class="form-group">
    <label for="max_selling_price">Maximum Selling Price (KES) *</label>
    <input type="number" 
           step="0.01" 
           min="0"
           name="max_selling_price" 
           id="max_selling_price"
           class="form-control @error('max_selling_price') is-invalid @enderror"
           value="{{ old('max_selling_price', $product->max_selling_price ?? $product->price ?? '') }}"
           required>
    <small class="form-text text-muted">Standard retail price (highest allowed)</small>
    @error('max_selling_price')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
```

### JavaScript Validation (Optional)
```javascript
// Real-time validation on admin form
document.getElementById('min_selling_price').addEventListener('change', validatePriceRange);
document.getElementById('max_selling_price').addEventListener('change', validatePriceRange);

function validatePriceRange() {
    const minPrice = parseFloat(document.getElementById('min_selling_price').value) || 0;
    const maxPrice = parseFloat(document.getElementById('max_selling_price').value) || 0;
    
    if (minPrice > maxPrice) {
        alert('Minimum selling price cannot be greater than maximum selling price');
        return false;
    }
    
    return true;
}
```

## POS Interface Updates Needed

### Cart Item Display
Each cart item should show:
- Product name and SKU
- Quantity
- **Editable price field** with min/max indicators
- Subtotal

### Example Cart Item HTML
```blade
<tr>
    <td>{{ $item->name }}</td>
    <td>
        <input type="number" 
               class="quantity-input" 
               value="{{ $item->quantity }}" 
               min="1" 
               max="{{ $item->stock }}">
    </td>
    <td>
        <input type="number" 
               class="price-input" 
               step="0.01"
               value="{{ $item->price }}" 
               min="{{ $item->min_price }}" 
               max="{{ $item->max_price }}"
               data-product-id="{{ $item->product_id }}">
        <small class="text-muted d-block">
            Range: KES {{ number_format($item->min_price, 2) }} - 
            {{ number_format($item->max_price, 2) }}
        </small>
    </td>
    <td class="subtotal">KES {{ number_format($item->quantity * $item->price, 2) }}</td>
</tr>
```

## Testing Checklist

### Admin Panel Testing
- [ ] Create new product with min/max prices
- [ ] Try to save with min > max (should fail)
- [ ] Try to save with max < min (should fail)
- [ ] Edit existing product and update prices
- [ ] Verify existing products have default values after migration

### POS Testing
- [ ] Add product to cart at default price
- [ ] Adjust price within valid range (should succeed)
- [ ] Try to set price below minimum (should show error)
- [ ] Try to set price above maximum (should show error)
- [ ] Complete sale with adjusted prices
- [ ] Verify sale_items table stores correct prices
- [ ] Check receipt shows actual prices used

### Edge Cases
- [ ] Product with no min_selling_price set (should use cost_price)
- [ ] Product with no max_selling_price set (should use price)
- [ ] Zero quantity products
- [ ] Negative price attempts
- [ ] Very large numbers
- [ ] Concurrent transactions on same product

## Reporting Considerations

### New Reports Possible
1. **Price Variance Report**: Shows how often prices are adjusted below maximum
2. **Discount Analysis**: Tracks total revenue lost to discounts
3. **Cashier Pricing Patterns**: Identifies which cashiers adjust prices most
4. **Product Profitability**: Compares actual selling prices vs. cost prices

### Example Query
```php
// Get average selling price vs max price by product
$priceAnalysis = DB::table('sale_items')
    ->join('products', 'sale_items.product_id', '=', 'products.id')
    ->select(
        'products.name',
        'products.max_selling_price',
        DB::raw('AVG(sale_items.unit_price) as avg_actual_price'),
        DB::raw('COUNT(*) as times_sold'),
        DB::raw('SUM(sale_items.quantity * (products.max_selling_price - sale_items.unit_price)) as total_discount_given')
    )
    ->groupBy('products.id', 'products.name', 'products.max_selling_price')
    ->having('avg_actual_price', '<', DB::raw('products.max_selling_price'))
    ->get();
```

## Summary of Changes Made

### Files Created
1. `database/migrations/2025_10_13_000001_add_price_range_to_products_table.php`
2. `DYNAMIC_PRICING_FEATURE.md` (this documentation)

### Files Modified
1. `app/Models/Product.php` - Added new fields, casts, and price validation methods
2. `app/Http/Controllers/Admin/ProductController.php` - Added validation for price range
3. `app/Http/Controllers/POS/SaleController.php` - Added price range validation during sales
4. `app/Http/Controllers/POS/POSDashboardController.php` - Added API endpoint for product details
5. `routes/web.php` - Added new route for product details API

## Next Steps

1. **Run the migration**
   ```bash
   php artisan migrate
   ```

2. **Update admin product forms** to include min/max price fields

3. **Update POS interface** to:
   - Fetch product price range when adding to cart
   - Display editable price field with range indicators
   - Implement client-side validation for better UX
   - Handle server-side validation errors gracefully

4. **Test thoroughly** using the checklist above

5. **Train staff** on:
   - When to adjust prices
   - Understanding price limits
   - Company policies on discounting

## Support & Troubleshooting

### Common Issues

**Issue**: Migration fails with "column already exists"
**Solution**: Check if migration already ran, or manually drop columns and re-run

**Issue**: Validation error "The min selling price must be less than or equal to max selling price"
**Solution**: Ensure min ≤ max when creating/editing products

**Issue**: POS rejects valid price
**Solution**: Check that product has min/max set, or system is using correct fallback values

**Issue**: Old products don't have price ranges
**Solution**: Migration should auto-populate; if not, manually update via SQL:
```sql
UPDATE products 
SET min_selling_price = cost_price, 
    max_selling_price = price 
WHERE min_selling_price IS NULL 
   OR max_selling_price IS NULL;
```

## Contact

For questions or issues with this feature implementation, please contact the development team.
