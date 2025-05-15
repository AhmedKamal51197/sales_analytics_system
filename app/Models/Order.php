<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'status',
        // 'order_date',
        'total_price'
    ];  
    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,'order_products')
        ->withPivot('price','quantity');
    }
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }
    public function scopeToday($query)
    {
        return $query->whereDate('order_date', now());
    }
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('order_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('order_date', now()->month);
    }
    public function scopeThisYear($query)
    {
        return $query->whereYear('order_date', now()->year);
    }
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('order_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
    }
    public function scopeLastMonth($query)
    {
        return $query->whereMonth('order_date', now()->subMonth()->month);
    }

}
