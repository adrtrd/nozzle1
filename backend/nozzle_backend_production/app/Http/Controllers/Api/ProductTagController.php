<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProductTagController extends Controller
{
    public function index(): JsonResponse
    {
        // Returning empty list as fallback for legacy tags
        return response()->json([
            'success' => true,
            'data' => [
                'tags' => []
            ]
        ]);
    }
}
