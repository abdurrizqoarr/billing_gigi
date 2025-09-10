<?php

namespace App\Filament\Resources\AkunPenerimaans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AkunPenerimaanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('akun_penerimaan')->required()->maxLength(255)
            ]);
    }
}
