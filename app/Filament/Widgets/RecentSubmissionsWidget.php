<?php
/**
 * File Path: app/Filament/Widgets/RecentSubmissionsWidget.php
 *
 * Run: php artisan make:filament-widget RecentSubmissionsWidget
 * Then replace content with this file
 */

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentSubmissionsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactSubmission::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'new',
                        'warning' => 'read',
                        'info' => 'replied',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (ContactSubmission $record): string => route('filament.admin.resources.contact-submissions.view', $record)),
            ]);
    }

    protected function getTableHeading(): string
    {
        return 'Recent Contact Submissions';
    }
}
