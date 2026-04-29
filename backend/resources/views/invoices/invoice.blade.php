<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>فاتورة رقم #{{ $order->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; direction: rtl; text-align: right; color: #333; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; color: #555; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: right; border-collapse: collapse; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: left; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.details td { padding-bottom: 20px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        .header { background-color: #f59e0b; color: white; padding: 20px; text-align: center; margin-bottom: 30px; border-radius: 5px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h1>فاتورة ضريبية</h1>
            <p>نوزل - Nozzle</p>
        </div>
        
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ $logo ?? '' }}" style="width:100%; max-width:150px;">
                            </td>
                            <td>
                                رقم الفاتورة: #{{ $order->id }}<br>
                                التاريخ: {{ $order->created_at->format('Y-m-d') }}<br>
                                الوقت: {{ $order->created_at->format('H:i') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>العميل:</strong><br>
                                {{ $order->customer_name ?? $order->user->name ?? 'عميل عام' }}<br>
                                {{ $order->customer_phone ?? $order->user->phone ?? '' }}<br>
                                {{ $order->customer_address ?? '' }}
                            </td>
                            <td>
                                <strong>طريقة الدفع:</strong><br>
                                {{ $order->payment_method ?? 'نقداً عند الاستلام' }}<br>
                                <strong>الحالة:</strong><br>
                                {{ $order->payment_status == 'paid' ? 'تم الدفع' : 'قيد الانتظار' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>المنتج</td>
                <td>السعر</td>
            </tr>
            
            @foreach($order->items as $item)
            <tr class="item">
                <td>{{ $item->product->name }} (×{{ $item->quantity }})</td>
                <td>{{ number_format($item->total_price ?? ($item->unit_price * $item->quantity), 0) }} IQD</td>
            </tr>
            @endforeach
            
            <tr class="total">
                <td></td>
                <td>المجموع الفرعي: {{ number_format($order->subtotal ?? 0, 0) }} IQD</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>الضريبة: {{ number_format($order->tax_amount ?? 0, 0) }} IQD</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>الشحن: {{ number_format($order->shipping_amount ?? 0, 0) }} IQD</td>
            </tr>
            @if($order->discount_amount > 0)
            <tr class="total">
                <td></td>
                <td>الخصم: -{{ number_format($order->discount_amount, 0) }} IQD</td>
            </tr>
            @endif
            <tr class="total">
                <td></td>
                <td style="font-size: 20px; color: #f59e0b;">
                    الإجمالي: {{ number_format($order->total_amount, 0) }} IQD
                </td>
            </tr>
        </table>
        
        <div class="footer">
            <p>شكراً لتعاملكم مع نوزل - نتمنى لكم تجربة تسوق رائعة!</p>
            <p>جميع الحقوق محفوظة &copy; {{ date('Y') }} Nozzle App</p>
        </div>
    </div>
</body>
</html>
