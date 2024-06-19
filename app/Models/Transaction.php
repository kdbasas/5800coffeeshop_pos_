<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions'; // Specify the table name if needed

    protected $primaryKey = 'transaction_id'; // Specify the primary key if it's not `id`

    protected $fillable = [
        'customer_name',
        'paid_amount',
        'balance',
        'payment_method',
        'user_id',
        'transac_date',
        'transac_amount',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_transaction', 'transaction_id', 'product_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}