<?php

namespace App\Filament\Resources\MitraJurnalResource\Pages;

use App\Filament\Resources\MitraJurnalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMitraJurnal extends EditRecord
{
    protected static string $resource = MitraJurnalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
