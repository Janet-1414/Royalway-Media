<?php

namespace App\Filament\Resources\EventBriefResource\Pages;

use App\Filament\Resources\EventBriefResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEventBrief extends ViewRecord
{
    protected static string $resource = EventBriefResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
