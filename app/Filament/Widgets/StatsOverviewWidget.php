<?php
/**
 * File Path: app/Filament/Widgets/StatsOverviewWidget.php
 *
 * Run: php artisan make:filament-widget StatsOverviewWidget --stats-overview
 * Then replace content with this file
 */

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Service;
use App\Models\ContactSubmission;
use App\Models\EventBrief;
use App\Models\Partner;
use App\Models\TeamMember;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', Project::count())
                ->description('Published: ' . Project::published()->count())
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success')
                ->chart([7, 12, 16, 14, 18, 15, Project::count()]),

            Stat::make('Active Services', Service::active()->count())
                ->description('Total: ' . Service::count())
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),

            Stat::make('New Contact Forms', ContactSubmission::where('status', 'new')->count())
                ->description('Total: ' . ContactSubmission::count())
                ->descriptionIcon('heroicon-m-envelope')
                ->color(ContactSubmission::where('status', 'new')->count() > 0 ? 'warning' : 'success'),

            Stat::make('New Event Briefs', EventBrief::where('status', 'new')->count())
                ->description('Total: ' . EventBrief::count())
                ->descriptionIcon('heroicon-m-calendar')
                ->color(EventBrief::where('status', 'new')->count() > 0 ? 'warning' : 'success'),

            Stat::make('Team Members', TeamMember::active()->count())
                ->description('Total: ' . TeamMember::count())
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Partners', Partner::active()->count())
                ->description('Total: ' . Partner::count())
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),
        ];
    }
}
