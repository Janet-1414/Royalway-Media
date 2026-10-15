<?php

namespace App\Filament\Resources\ContactSubmissionResource\Pages;

use App\Filament\Resources\ContactSubmissionResource;
use App\Mail\ContactReplyMail;
use App\Models\ContactSubmission;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ViewContactSubmission extends ViewRecord
{
    protected static string $resource = ContactSubmissionResource::class;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Auto-mark as read when viewing a new submission
        if ($this->record->status === 'new') {
            $this->record->markAsRead();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply')
                ->label(fn () => $this->record->hasBeenReplied() ? 'Reply Again' : 'Reply')
                ->icon('heroicon-o-envelope')
                ->color('primary')
                ->form([
                    Forms\Components\Placeholder::make('last_reply_info')
                        ->label('Last Reply')
                        ->content(fn () => $this->record->replied_at
                            ? "Sent: {$this->record->replied_at->format('M d, Y H:i')}\nSubject: {$this->record->reply_subject}"
                            : null)
                        ->visible(fn () => $this->record->hasBeenReplied()),

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
                ->action(function (array $data) {
                    // Update record
                    $this->record->update([
                        'reply_subject' => $data['subject'],
                        'reply_message' => $data['message'],
                        'replied_at' => now(),
                        'replied_by' => Auth::id(),
                        'status' => 'replied',
                    ]);

                    // Send email
                    try {
                        Mail::to($this->record->email)
                            ->queue(ContactReplyMail::fromContactSubmission($this->record));

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
        ];
    }
}
