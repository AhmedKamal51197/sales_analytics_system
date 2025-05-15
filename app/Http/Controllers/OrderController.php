<?php

namespace App\Http\Controllers;

use App\Events\AnalyticsUpdated;
use App\Events\NewOrderCreated;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    
  
    public function store(CreateOrderRequest  $request)
    {
        try {
            $validatedData = $request->validated();
            
            $productIds = $validatedData['products']??[];
            DB::beginTransaction();
            $order = Order::create([
                'user_id' => $validatedData['user_id'],
                'status' => $validatedData['status'] ?? 'pending',
                'order_date' => $validatedData['order_date'] ?? now(),
                'total_price' =>0 , 
            ]);
            $totalPrice = 0;
            foreach ($productIds as $productId) {
                $product = Product::findOrFail($productId['id']);
                $quantity = $productId['quantity'] ?? 1; // Default to 1 if not provided
                $price = $product->price * $quantity;
                
                // Create order-product relationship
                $order->products()->attach($productId['id'], [
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
         
                // Update total price
                $totalPrice += $price;
               
            }
            // Update the order's total price
            $order->total_price = $totalPrice;
            $order->save();
            
            DB::commit();

              // Prepare data to broadcast
            $orderData = $order->toArray();

            // Publish new order to Redis channel
            // Redis::publish('orders-channel', json_encode(['type' => 'new_order', 'data' => $orderData]));
              // Fire new order event
            event(new NewOrderCreated($order));
            // Update real-time metrics
             $this->updateRealTimeMetrics($order);
                // Calculate updated analytics (e.g. total sales, orders count)
            $analyticsData = [
                'total_sales' => Order::sum('total_price'),
                'orders_count' => Order::count(),
                // add other relevant analytics
            ];
            // Fire analytics updated event
            event(new AnalyticsUpdated($analyticsData));
            Redis::publish('orders-channel', json_encode([
                'type' => 'new_order',
                'data' => [
                    'id' => $order->id,
                    'user_id' => $order->user_id,
                    'total_price' => $order->total_price,
                ]
            ]));
    
            Redis::publish('orders-channel', json_encode(['type' => 'analytics_update', 'data' => $analyticsData]));

            return $this->success(data:$order, message:'Order created successfully');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
       
    }

    private function updateRealTimeMetrics(Order $order)
    {
        // Update total revenue
        $totalRevenue = Redis::get('total_revenue') ?? 0;
        Redis::set('total_revenue', $totalRevenue + ($order->price * $order->quantity));

        // Increment order count
        $orderCount = Redis::get('order_count') ?? 0;
        Redis::set('order_count', $orderCount + 1);

        // Track product sales (using sorted set to track sales of each product)
        Redis::zincrby('top_products', $order->price * $order->quantity, $order->product_id);

        // Track revenue and order count in the last minute
        $this->updateRevenueAndOrderCountLastMinute();
    }

    private function updateRevenueAndOrderCountLastMinute()
    {
        // Use Redis to track the last minute's revenue and order count
        $lastMinuteRevenue = Redis::get('revenue_change_last_minute') ?? 0;
        $lastMinuteOrderCount = Redis::get('orders_count_last_minute') ?? 0;

        Redis::set('revenue_change_last_minute', $lastMinuteRevenue + 100); // Example increment
        Redis::set('orders_count_last_minute', $lastMinuteOrderCount + 1);

        // Optionally, set an expiration on these keys to reset them periodically
        Redis::expire('revenue_change_last_minute', 60);  // expires after 1 minute
        Redis::expire('orders_count_last_minute', 60);    // expires after 1 minute
    }
    
}
