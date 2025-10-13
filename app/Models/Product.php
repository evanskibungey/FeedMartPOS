<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'brand_id',
        'description',
        'unit',
        'quantity_in_stock',
        'reorder_level',
        'price',
        'min_selling_price',
        'max_selling_price',
        'wholesale_price',
        'cost_price',
        'image',
        'barcode',
        'tax_rate',
        'status',
    ];

    protected $casts = [
        'quantity_in_stock' => 'integer',
        'reorder_level' => 'integer',
        'price' => 'decimal:2',
        'min_selling_price' => 'decimal:2',
        'max_selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
    ];

    protected $appends = ['selling_price', 'image_url', 'price_range'];

    /**
     * Get the selling price (alias for max_selling_price or price)
     */
    public function getSellingPriceAttribute()
    {
        // Return max_selling_price if set, otherwise fall back to price
        return $this->max_selling_price ?? $this->price;
    }

    /**
     * Get the price range for display
     */
    public function getPriceRangeAttribute()
    {
        return [
            'min' => $this->min_selling_price,
            'max' => $this->max_selling_price ?? $this->price,
            'default' => $this->max_selling_price ?? $this->price,
        ];
    }

    /**
     * Validate if a given price is within the allowed range
     */
    public function isPriceValid(float $price): bool
    {
        $minPrice = $this->min_selling_price ?? $this->cost_price;
        $maxPrice = $this->max_selling_price ?? $this->price;
        
        return $price >= $minPrice && $price <= $maxPrice;
    }

    /**
     * Get the minimum allowed selling price
     */
    public function getMinPriceAttribute()
    {
        return $this->min_selling_price ?? $this->cost_price;
    }

    /**
     * Get the maximum allowed selling price
     */
    public function getMaxPriceAttribute()
    {
        return $this->max_selling_price ?? $this->price;
    }

    /**
     * Get the full image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Get the category for this product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand for this product
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get suppliers for this product
     */
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
            ->withPivot('purchase_price', 'lead_time', 'is_preferred')
            ->withTimestamps();
    }

    /**
     * Get stock movements for this product
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Get purchase order items for this product
     */
    public function purchaseOrderItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * Get sale items for this product
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Check if product is low on stock
     */
    public function isLowStock(): bool
    {
        return $this->quantity_in_stock <= $this->reorder_level && $this->quantity_in_stock > 0;
    }

    /**
     * Check if product is out of stock
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity_in_stock <= 0;
    }

    /**
     * Get stock status
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return 'out';
        }
        
        if ($this->isLowStock()) {
            return 'low';
        }
        
        return 'ok';
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for low stock products
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity_in_stock', '<=', 'reorder_level')
            ->where('quantity_in_stock', '>', 0);
    }

    /**
     * Scope for out of stock products
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity_in_stock', '<=', 0);
    }
}
