<?php

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class PegawaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('username')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state)) // simpan hanya kalau ada input
                    ->afterStateHydrated(fn($set) => $set('password', '')) // kosongkan field di edit
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Select::make('role')->options([
                    'PEGAWAI' => 'PEGAWAI',
                    'DOKTER' => 'DOKTER',
                ])
            ]);
    }
}
