<?php

namespace App\Filament\Resources\ObatBhps\Pages;

use App\Filament\Resources\ObatBhps\ObatBhpResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditObatBhp extends EditRecord
{
    protected static string $resource = ObatBhpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
