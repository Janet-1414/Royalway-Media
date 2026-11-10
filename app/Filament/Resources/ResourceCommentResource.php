<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceCommentResource\Pages;
use App\Models\ResourceComment;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ResourceCommentResource extends Resource
{
    protected static ?string $model = ResourceComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static ?string $navigationGroup = 'Form Submissions';

    protected static ?string $navigationLabel = 'Article Comments';

    protected static ?string $modelLabel = 'Comment';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationBadgeTooltip = 'Comments waiting for approval';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ResourceComment::STATUSES[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'approved' => 'success',
                        'spam' => 'danger',
                        default => 'warning',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('resource.title')
                    ->label('Article')
                    ->limit(40)
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(fn (ResourceComment $record) => $record->email),

                Tables\Columns\TextColumn::make('body')
                    ->label('Comment')
                    ->limit(80)
                    ->tooltip(fn (ResourceComment $record) => $record->body)
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(ResourceComment::STATUSES)
                    ->default('pending'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (ResourceComment $record) => $record->status !== 'approved')
                    ->action(fn (ResourceComment $record) => $record->update(['status' => 'approved'])),

                Tables\Actions\Action::make('spam')
                    ->label('Spam')
                    ->icon('heroicon-o-no-symbol')
                    ->color('gray')
                    ->visible(fn (ResourceComment $record) => $record->status !== 'spam')
                    ->action(fn (ResourceComment $record) => $record->update(['status' => 'spam'])),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->icon('heroicon-o-check')
                        ->action(fn (Collection $records) => $records->each->update(['status' => 'approved']))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('spam')
                        ->label('Mark as spam')
                        ->icon('heroicon-o-no-symbol')
                        ->action(fn (Collection $records) => $records->each->update(['status' => 'spam']))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResourceComments::route('/'),
        ];
    }
}
