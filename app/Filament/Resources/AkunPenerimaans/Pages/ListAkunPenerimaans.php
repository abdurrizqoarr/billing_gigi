<?php

namespace App\Filament\Resources\AkunPenerimaans\Pages;

use App\Filament\Resources\AkunPenerimaans\AkunPenerimaanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAkunPenerimaans extends ListRecords
{
    protected static string $resource = AkunPenerimaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
