<?php

namespace App\Filament\Resources\SouvenirCategoryResource\Pages;

use App\Filament\Resources\SouvenirCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSouvenirCategory extends EditRecord
{
    protected static string $resource = SouvenirCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
