<?php

namespace App\Filament\Resources\ObatBhps\Pages;

use App\Filament\Resources\ObatBhps\ObatBhpResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListObatBhps extends ListRecords
{
    protected static string $resource = ObatBhpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
