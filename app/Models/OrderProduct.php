<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'order_products';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];
    public $timestamps = false;
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $appends = [
        'total_price',
    ];
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
