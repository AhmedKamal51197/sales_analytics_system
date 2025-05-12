<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
  
    public function store(CreateOrderRequest  $request)
    {
        try {
            $product = Product::find($request->product_id);
            if(!$product) {
                return $this->failure('Product not found', 404);
            }
            $order = $request->validated();
            $order['price']=$request->quantity * $product->price;
            
             Order::create($order);
            return $this->success(data:$order, message:'Order created successfully');
        } catch (\Exception $e) {
            return $this->failure($e->getMessage(), 500);
        }
       
    }
    
}
