<?php
/**
 * File Path: app/Filament/Widgets/RecentEventBriefsWidget.php
 *
 * Run: php artisan make:filament-widget RecentEventBriefsWidget
 * Then replace content with this file
 */

namespace App\Filament\Widgets;

use App\Models\EventBrief;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentEventBriefsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                EventBrief::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('organization_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('key_contact')
                    ->searchable(),

                Tables\Columns\TextColumn::make('event_nature')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('setup')
                    ->badge()
                    ->colors([
                        'primary' => 'indoor',
                        'success' => 'outdoor',
                    ]),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'new',
                        'info' => 'reviewed',
                        'warning' => 'quoted',
                        'primary' => 'confirmed',
                        'secondary' => 'completed',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (EventBrief $record): string => route('filament.admin.resources.event-briefs.view', $record)),
            ]);
    }

    protected function getTableHeading(): string
    {
        return 'Recent Event Brief Submissions';
    }
}
