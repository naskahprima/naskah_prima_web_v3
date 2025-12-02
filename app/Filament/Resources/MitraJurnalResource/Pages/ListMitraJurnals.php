<?php

namespace App\Filament\Resources\MitraJurnalResource\Pages;

use App\Filament\Resources\MitraJurnalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMitraJurnals extends ListRecords
{
    protected static string $resource = MitraJurnalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
