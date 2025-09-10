<?php

namespace App\Filament\Resources\TarifTindakans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TarifTindakanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tarif_tindakan')
                    ->label('Nama Tarif')
                    ->required(),
                TextInput::make('nilai_tarif')
                    ->label('Harga Tarif')
                    ->required()
                    ->numeric(),
            ]);
    }
}
