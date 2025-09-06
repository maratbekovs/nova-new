<?php

namespace App\Filament\Resources\TourTypeResource\Pages;

use App\Filament\Resources\TourTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourType extends EditRecord
{
    protected static string $resource = TourTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
