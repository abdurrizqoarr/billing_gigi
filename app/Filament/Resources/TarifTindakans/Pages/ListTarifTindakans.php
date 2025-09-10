<?php

namespace App\Filament\Resources\TarifTindakans\Pages;

use App\Filament\Resources\TarifTindakans\TarifTindakanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTarifTindakans extends ListRecords
{
    protected static string $resource = TarifTindakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
