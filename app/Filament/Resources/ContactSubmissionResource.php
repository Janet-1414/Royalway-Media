<?php
/**
 * File Path: app/Filament/Resources/ContactSubmissionResource.php
 */

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Mail\ContactReplyMail;
use App\Models\ContactSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Form Submissions';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationBadgeTooltip = 'New contact submissions';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count() ?: null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->disabled(),

                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull()
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'read' => 'Read',
                                'replied' => 'Replied',
                            ])
                            ->required(),
                    ]),

                Forms\Components\Section::make('Reply')
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
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
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'read' => 'Read',
                        'replied' => 'Replied',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->label(fn (ContactSubmission $record) => $record->hasBeenReplied() ? 'Reply Again' : 'Reply')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->form([
                        Forms\Components\Placeholder::make('last_reply_info')
                            ->label('Last Reply')
                            ->content(fn (ContactSubmission $record) => $record->replied_at
                                ? "Sent: {$record->replied_at->format('M d, Y H:i')}\nSubject: {$record->reply_subject}"
                                : null)
                            ->visible(fn (ContactSubmission $record) => $record->hasBeenReplied()),

                        Forms\Components\TextInput::make('subject')
                            ->label('Subject')
                            ->default('Re: Your message to RoyalWay Media')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->rows(8),
                    ])
                    ->action(function (ContactSubmission $record, array $data) {
                        // Update record
                        $record->update([
                            'reply_subject' => $data['subject'],
                            'reply_message' => $data['message'],
                            'replied_at' => now(),
                            'replied_by' => Auth::id(),
                            'status' => 'replied',
                        ]);

                        // Send email
                        try {
                            Mail::to($record->email)
                                ->queue(ContactReplyMail::fromContactSubmission($record));

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

                Tables\Actions\Action::make('markAsRead')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->visible(fn (ContactSubmission $record) => $record->status === 'new')
                    ->action(function (ContactSubmission $record) {
                        $record->markAsRead();
                        Notification::make()
                            ->success()
                            ->title('Marked as read')
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            $records->each->markAsRead();
                            Notification::make()
                                ->success()
                                ->title('Selected submissions marked as read')
                                ->send();
                        }),
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
            'index' => Pages\ListContactSubmissions::route('/'),
            'view' => Pages\ViewContactSubmission::route('/{record}'),
        ];
    }
}
