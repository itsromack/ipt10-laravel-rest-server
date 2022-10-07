<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Log;

class ProductsController extends Controller
{
    public function list()
    {
        $products = Product::all();

        return response()->json([
            'data' => $products,
            'total' => $products->count()
        ]);
    }

    public function item($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json([
                'error' => 'Product not found'
            ]);
        }

        return response()->json([
            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->json()->all();
            $product = new Product();
            $product->title = $data['title'];
            $product->price = $data['price'];
            $product->brand = $data['brand'];
            $product->category = $data['category'];
            $product->image = $data['image'];
            $product->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Unable to save product'
            ]);
        }
        
        return response()->json([
            'data' => $product
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->json()->all();
            $product = Product::find($id);
            if (!is_null($product)) {
                $product->title = $data['title'];
                $product->price = $data['price'];
                $product->brand = $data['brand'];
                $product->category = $data['category'];
                $product->image = $data['image'];
                $product->save();
            } else {
                throw new Exception('Unable to find product');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Unable to update product'
            ]);
        }
        
        return response()->json([
            'data' => $product
        ]);
    }

    public function delete($id)
    {
        try {
            $product = Product::find($id);
            if (!is_null($product)) {
                $product->delete();
            } else {
                throw new Exception('Unable to find product');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Unable to update product'
            ]);
        }
        
        return response()->json([
            'data' => $product
        ]);
    }

    public function categories()
    {
        $categories = Product::distinct('category')
            ->select('category')
            ->get();
        
        return response()->json([
            'data' => $categories
        ]);
    }

    public function getByCategory($name)
    {
        $products = Product::where('category', $name)->get();

        return response()->json([
            'data' => $products,
            'total' => $products->count()
        ]);
    }
}
