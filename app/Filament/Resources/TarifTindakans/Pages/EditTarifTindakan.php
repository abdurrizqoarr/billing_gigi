<?php

namespace App\Filament\Resources\TarifTindakans\Pages;

use App\Filament\Resources\TarifTindakans\TarifTindakanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTarifTindakan extends EditRecord
{
    protected static string $resource = TarifTindakanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
