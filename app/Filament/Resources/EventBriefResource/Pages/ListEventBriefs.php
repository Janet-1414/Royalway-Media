<?php

namespace App\Filament\Resources\EventBriefResource\Pages;

use App\Filament\Resources\EventBriefResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventBriefs extends ListRecords
{
    protected static string $resource = EventBriefResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
