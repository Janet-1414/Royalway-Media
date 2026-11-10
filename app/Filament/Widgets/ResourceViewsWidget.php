<?php

namespace App\Filament\Widgets;

use App\Models\Resource as ResourceModel;
use App\Models\ResourceView;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ResourceViewsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        $since = now()->subDays(30)->toDateString();
        $total = ResourceView::where('viewed_on', '>=', $since)->count();

        return $table
            ->heading('Article readership')
            ->description(number_format($total) . ' views in the last 30 days. Top 5 articles below.')
            ->query(
                ResourceModel::query()
                    ->withCount(['views as recent_views' => fn ($q) => $q->where('viewed_on', '>=', $since)])
                    ->having('recent_views', '>', 0)
                    ->orderByDesc('recent_views')
                    ->limit(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(60)
                    ->url(fn (ResourceModel $record) => route('resources.show', $record->slug), true),
                Tables\Columns\TextColumn::make('recent_views')
                    ->label('Views (30 days)')
                    ->numeric(),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('All time')
                    ->numeric(),
            ])
            ->emptyStateHeading('No article views yet');
    }
}
