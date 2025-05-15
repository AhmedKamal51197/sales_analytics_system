<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Retrieve metrics from Redis
        $totalRevenue = Redis::get('total_revenue') ?? 0;
        $orderCount = Redis::get('order_count') ?? 0;

        // Calculate the revenue change and order count in the last 1 minute
        $revenueChangeLastMinute = Redis::get('revenue_change_last_minute') ?? 0;
        $ordersCountLastMinute = Redis::get('orders_count_last_minute') ?? 0;

        // Get the top-selling products (track sales of each product)
        $topProducts = Redis::zRange('top_products', 0, -1, 'WITHSCORES');
        $topProductId = $topProducts ? key($topProducts) : null;

        // Retrieve top-selling product name (you can modify this if you need a more complex query)
        $topProductName = $topProductId ? $this->getProductName($topProductId) : null;

        return response()->json([
            'total_revenue' => $totalRevenue,
            'order_count' => $orderCount,
            'revenue_change_last_minute' => $revenueChangeLastMinute,
            'orders_count_last_minute' => $ordersCountLastMinute,
            'top_product' => $topProductName,
        ]);
    }
    private function getProductName($productId)
    {
        $product = Product::find($productId);
        return $product ? $product->name : null;
    }
}
