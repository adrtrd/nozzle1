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
        $products = Product::published()
            ->with(['category', 'brand'])
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
        if (!$product->is_active || $product->status !== 'published') {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found or not published.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $this->transformProduct($product->load(['category', 'brand']))
        ]);
    }

    /**
     * Display products by category.
     */
    public function byCategory(Category $category): JsonResponse
    {
        $products = Product::where('category_id', $category->id)
            ->published()
            ->with(['category', 'brand'])
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
            'brand' => $product->brand instanceof \App\Models\Brand ? $product->brand->name : ($product->brand ?? ''),
            'price' => (double) $product->price,
            'old_price' => $product->old_price ? (double) $product->old_price : null,
            'image' => $product->image ? asset('storage/' . $product->image) : null, // compatibility with 'image' key
            'image_url' => $product->image ? asset('storage/' . $product->image) : null,
            'images' => is_array($product->images) ? array_map(fn($img) => asset('storage/' . $img), $product->images) : [],
            'is_available' => (bool) $product->is_available,
            'is_featured' => (bool) $product->is_featured,
            'home_section' => $product->home_section ?? 'none',
            'quantity' => (int) $product->quantity,
            'in_stock' => $product->quantity > 0 && $product->is_available,
            'is_low_stock' => $product->quantity <= ($product->low_stock_threshold ?? 5),
            'features' => is_array($product->features) ? $product->features : [],
            'specifications' => is_array($product->specifications) ? $product->specifications : new \stdClass(),
            'category_id' => $product->category_id,
            'category_name' => $product->category?->name_ar ?? $product->category?->name,
            'created_at' => $product->created_at,
        ];
    }

}
