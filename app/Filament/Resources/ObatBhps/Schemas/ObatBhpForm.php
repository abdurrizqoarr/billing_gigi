<?php

namespace App\Filament\Resources\ObatBhps\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ObatBhpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_obat')
                    ->label('Nama Obat Atau BHP')
                    ->required(),
                TextInput::make('harga')
                    ->required()
                    ->numeric(),
            ]);
    }
}
