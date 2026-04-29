<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of all available products.
     */
    public function index(): JsonResponse
    {
        $products = Product::where('is_available', true)
            ->with('category')
            ->get()
            ->map(function ($product) {
                return $this->transformProduct($product);
            });
            
        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->transformProduct($product->load('category'))
        ]);
    }

    /**
     * Display products by category.
     */
    public function byCategory(Category $category): JsonResponse
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_available', true)
            ->with('category')
            ->get()
            ->map(function ($product) {
                return $this->transformProduct($product);
            });

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    private function transformProduct($product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'name_ar' => $product->name_ar ?? $product->name,
            'description' => $product->description,
            'description_ar' => $product->description_ar ?? $product->description,
            'brand' => $product->brand?->name ?? $product->brand, // Handle brand object or string
            'price' => (double) $product->price,
            'old_price' => $product->old_price ? (double) $product->old_price : null,
            'image_url' => $product->image ? asset('storage/' . $product->image) : null,
            'is_available' => (bool) $product->is_available,
            'is_featured' => (bool) $product->is_featured,
            'home_section' => $product->home_section ?? 'none',
            'quantity' => (int) $product->quantity,
            'in_stock' => $product->quantity > 0 && $product->is_available,
            'is_low_stock' => $product->quantity <= ($product->low_stock_threshold ?? 5),
            'features' => $product->features ?? [],
            'specifications' => $product->specifications ?? [],
            'category_id' => $product->category_id,
            'category_name' => $product->category?->name_ar ?? $product->category?->name,
            'created_at' => $product->created_at,
        ];
    }

}
