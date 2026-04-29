<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User ID is required']);
        }

        $favorites = Favorite::where('user_id', $userId)
            ->with(['product' => function($query) {
                 $query->select('id', 'name', 'name_ar', 'brand', 'price', 'old_price', 'image', 'rating', 'reviews_count as reviews', 'stock');
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'favorites' => $favorites
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $favorite = Favorite::updateOrCreate([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to favorites',
            'data' => $favorite
        ]);
    }

    public function destroy(Request $request)
    {
        $userId = $request->query('user_id');
        $productId = $request->query('product_id');

        if (!$userId || !$productId) {
             return response()->json(['success' => false, 'message' => 'User ID and Product ID are required']);
        }

        Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from favorites'
        ]);
    }

    public function check(Request $request)
    {
        $userId = $request->query('user_id');
        $productId = $request->query('product_id');

        $isFavorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'success' => true,
            'data' => ['is_favorite' => $isFavorite]
        ]);
    }
}
