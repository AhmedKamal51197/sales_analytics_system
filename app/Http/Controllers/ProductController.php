<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        try{
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image'] = uploadImage($request->file('image'), 'Products');
            }
            Product::create($data);
            return $this->success('Product created successfully', 201);
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
    }
    
    public function index()
    {
        try{
            $products = Product::all();
            if($products->isEmpty()){
                return $this->success(data:[],message:'No products found', status:404);
            }
            return $this->success(data:ProductResource::collection($products), message:'Products retrieved successfully');
        }catch(\Throwable $e){
            return $this->failure($e->getMessage(), 500);
        }
    }

}
