<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $primaryKey = 'cart_id';
    protected $fillable = ['employee_id', 'product_id', 'quantity', 'price'];

    /**
     * Get the employee associated with the cart item.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the product associated with the cart item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
