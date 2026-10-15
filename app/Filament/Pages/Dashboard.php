<?php
/**
 * File Path: app/Filament/Pages/Dashboard.php
 *
 * Create this file to customize the dashboard
 */

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverviewWidget::class,
            \App\Filament\Widgets\RecentSubmissionsWidget::class,
            \App\Filament\Widgets\RecentEventBriefsWidget::class,
        ];
    }
}
