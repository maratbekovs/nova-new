<?php

namespace App\Filament\Resources\TourTypeResource\Pages;

use App\Filament\Resources\TourTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTourTypes extends ListRecords
{
    protected static string $resource = TourTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
