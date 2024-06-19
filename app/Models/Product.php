<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name', 'description', 'type_id', 'type_name', 'price', 'quantity', 'alert_stock', 'product_image',
    ];    

    /**
     * Get the type associated with the product.
     */
    public function type()
    {
        return $this->belongsTo(ProductType::class, 'type_id', 'type_id');
    }

    /**
     * Accessor to get the full image URL for the product.
     */
    public function getImageUrlAttribute()
    {
        if ($this->product_image) {
            // Assuming 'storage' is linked to 'public/storage' using 'php artisan storage:link'
            return asset('storage/img/product/' . $this->product_image);
        }
        
        // Default image URL if no product image is set
        return asset('images/default_product_image.jpg');
    }

    /**
     * Get the cart items associated with the product.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'product_transaction')
                    ->withPivot('quantity');
    }
}
