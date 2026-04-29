<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesPerformanceChart extends ChartWidget
{
    protected ?string $heading = 'أداء المبيعات';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw('SUM(total_amount) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = [];
        $values = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthNum = (int)$month->format('n');
            $months[] = $month->translatedFormat('F');
            $values[] = $data[$monthNum] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'المبيعات (IQD)',
                    'data' => $values,
                    'fill' => 'start',
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
