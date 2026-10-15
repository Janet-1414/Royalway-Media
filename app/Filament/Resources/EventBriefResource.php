<?php
/**
 * File Path: app/Filament/Resources/EventBriefResource.php
 */

namespace App\Filament\Resources;

use App\Filament\Resources\EventBriefResource\Pages;
use App\Mail\ContactReplyMail;
use App\Models\EventBrief;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EventBriefResource extends Resource
{
    protected static ?string $model = EventBrief::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Form Submissions';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Event Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Basic Information')
                            ->schema([
                                Forms\Components\TextInput::make('organization_name')
                                    ->disabled(),
                                Forms\Components\TextInput::make('key_contact')
                                    ->disabled(),
                                Forms\Components\TextInput::make('email')
                                    ->disabled(),
                                Forms\Components\TextInput::make('venue')
                                    ->disabled(),
                                Forms\Components\TextInput::make('event_nature')
                                    ->disabled(),
                                Forms\Components\TextInput::make('setup')
                                    ->disabled(),
                                Forms\Components\TextInput::make('guest_count')
                                    ->disabled(),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('Services Selected')
                            ->schema([
                                Forms\Components\Placeholder::make('venue_setup')
                                    ->label('Venue Setup')
                                    ->content(fn ($record) => $record?->venue_setup ? implode(', ', $record->venue_setup) : '—'),

                                Forms\Components\Placeholder::make('sound_visuals')
                                    ->label('Sound & Visuals')
                                    ->content(fn ($record) => $record?->sound_visuals ? implode(', ', $record->sound_visuals) : '—'),

                                Forms\Components\Placeholder::make('decoration')
                                    ->label('Decoration')
                                    ->content(fn ($record) => $record?->decoration ? implode(', ', $record->decoration) : '—'),

                                Forms\Components\Placeholder::make('hospitality')
                                    ->label('Hospitality & Entertainment')
                                    ->content(fn ($record) => $record?->hospitality ? implode(', ', $record->hospitality) : '—'),

                                Forms\Components\Placeholder::make('branding')
                                    ->label('Branding & Communication')
                                    ->content(fn ($record) => $record?->branding ? implode(', ', $record->branding) : '—'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Additional Info')
                            ->schema([
                                Forms\Components\Textarea::make('additional_info')
                                    ->rows(6)
                                    ->disabled()
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Reply')
                            ->schema([
                                Forms\Components\Placeholder::make('reply_info')
                                    ->label('Last Reply')
                                    ->content(fn ($record) => $record?->replied_at
                                        ? "Sent on {$record->replied_at->format('M d, Y H:i')} by " . ($record->repliedByUser?->name ?? 'Unknown')
                                        : 'No reply sent yet'),

                                Forms\Components\Placeholder::make('reply_subject_display')
                                    ->label('Subject')
                                    ->content(fn ($record) => $record?->reply_subject ?? '—')
                                    ->visible(fn ($record) => $record?->replied_at !== null),

                                Forms\Components\Placeholder::make('reply_message_display')
                                    ->label('Message')
                                    ->content(fn ($record) => $record?->reply_message ?? '—')
                                    ->visible(fn ($record) => $record?->replied_at !== null),
                            ])
                            ->visible(fn ($record) => $record !== null),
                    ])
                    ->columnSpanFull(),

                Forms\Components\Section::make('Status & Management')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'reviewed' => 'Reviewed',
                                'quoted' => 'Quoted',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                            ])
                            ->required(),
                    ]),

                Forms\Components\Section::make('Technical Details')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->disabled(),

                        Forms\Components\Textarea::make('user_agent')
                            ->rows(2)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization_name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('key_contact')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('event_nature')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('setup')
                    ->badge()
                    ->colors([
                        'primary' => 'indoor',
                        'success' => 'outdoor',
                    ]),

                Tables\Columns\TextColumn::make('guest_count')
                    ->label('Guests'),

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
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'reviewed' => 'Reviewed',
                        'quoted' => 'Quoted',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                    ]),

                Tables\Filters\SelectFilter::make('setup')
                    ->options([
                        'indoor' => 'Indoor',
                        'outdoor' => 'Outdoor',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->label(fn (EventBrief $record) => $record->hasBeenReplied() ? 'Reply Again' : 'Reply')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->visible(fn (EventBrief $record) => !empty($record->email))
                    ->form([
                        Forms\Components\Placeholder::make('last_reply_info')
                            ->label('Last Reply')
                            ->content(fn (EventBrief $record) => $record->replied_at
                                ? "Sent: {$record->replied_at->format('M d, Y H:i')}\nSubject: {$record->reply_subject}"
                                : null)
                            ->visible(fn (EventBrief $record) => $record->hasBeenReplied()),

                        Forms\Components\TextInput::make('subject')
                            ->label('Subject')
                            ->default('Re: Your event brief - RoyalWay Media')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->rows(8),
                    ])
                    ->action(function (EventBrief $record, array $data) {
                        // Update record (don't change event brief status)
                        $record->update([
                            'reply_subject' => $data['subject'],
                            'reply_message' => $data['message'],
                            'replied_at' => now(),
                            'replied_by' => Auth::id(),
                        ]);

                        // Send email
                        try {
                            Mail::to($record->email)
                                ->queue(ContactReplyMail::fromEventBrief($record));

                            Notification::make()
                                ->success()
                                ->title('Reply sent successfully')
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->danger()
                                ->title('Failed to send email')
                                ->body($e->getMessage())
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('markReviewed')
                    ->label('Mark Reviewed')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn (EventBrief $record) => $record->status === 'new')
                    ->action(function (EventBrief $record) {
                        $record->markAsReviewed();
                        Notification::make()
                            ->success()
                            ->title('Marked as reviewed')
                            ->send();
                    }),

                Tables\Actions\Action::make('markQuoted')
                    ->label('Mark Quoted')
                    ->icon('heroicon-o-document-text')
                    ->color('warning')
                    ->visible(fn (EventBrief $record) => in_array($record->status, ['new', 'reviewed']))
                    ->action(function (EventBrief $record) {
                        $record->markAsQuoted();
                        Notification::make()
                            ->success()
                            ->title('Marked as quoted')
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventBriefs::route('/'),
            'view' => Pages\ViewEventBrief::route('/{record}'),
        ];
    }
}
