<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $parentId = request('parent_id');
        
        $query = Category::withCount('products')
            ->orderBy('order_index');
            
        if ($parentId !== null) {
            $query->where('parent_id', $parentId);
        } else {
            // By default, maybe only show main categories? 
            // The Flutter app calls categories.php without parent_id for main categories.
            // If parent_id is not provided, we show all or just main ones? 
            // In the old system, main categories had parent_id 0 or null.
            $query->whereNull('parent_id');
        }

        $categories = $query->get()

            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'icon' => $category->icon ?? 'folder',
                    'color' => $category->color ?? '#1E4DB7',
                    'order_index' => $category->order_index,

                    'products_count' => $category->products_count,
                    'image_url' => $category->image ? asset('storage/' . $category->image) : null,
                ];
            });
        
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }
}
