<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    public function validateCoupon(Request $request): JsonResponse
    {
        $code = $request->query('code');
        $total = $request->query('total');

        $coupon = Coupon::where('code', $code)->where('is_active', true)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'كوبون الخصم غير موجود أو منتهي الصلاحية'
            ]);
        }

        // Basic validation (min amount)
        if ($total < $coupon->min_amount) {
            return response()->json([
                'success' => false,
                'message' => 'الحد الأدنى لاستخدام الكوبون هو ' . $coupon->min_amount
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'valid' => true,
                'code' => $coupon->code,
                'discount_amount' => $coupon->discount_amount,
                'discount_type' => $coupon->discount_type,
            ]
        ]);
    }
}
