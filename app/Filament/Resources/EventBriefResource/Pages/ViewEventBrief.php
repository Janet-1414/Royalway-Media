<?php

namespace App\Filament\Resources\EventBriefResource\Pages;

use App\Filament\Resources\EventBriefResource;
use App\Mail\ContactReplyMail;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ViewEventBrief extends ViewRecord
{
    protected static string $resource = EventBriefResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply')
                ->label(fn () => $this->record->hasBeenReplied() ? 'Reply Again' : 'Reply')
                ->icon('heroicon-o-envelope')
                ->color('primary')
                ->visible(fn () => !empty($this->record->email))
                ->form([
                    Forms\Components\Placeholder::make('last_reply_info')
                        ->label('Last Reply')
                        ->content(fn () => $this->record->replied_at
                            ? "Sent: {$this->record->replied_at->format('M d, Y H:i')}\nSubject: {$this->record->reply_subject}"
                            : null)
                        ->visible(fn () => $this->record->hasBeenReplied()),

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
                ->action(function (array $data) {
                    // Update record (don't change event brief status)
                    $this->record->update([
                        'reply_subject' => $data['subject'],
                        'reply_message' => $data['message'],
                        'replied_at' => now(),
                        'replied_by' => Auth::id(),
                    ]);

                    // Send email
                    try {
                        Mail::to($this->record->email)
                            ->queue(ContactReplyMail::fromEventBrief($this->record));

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

            Actions\EditAction::make(),
        ];
    }
}
