<?php

namespace App\Filament\Resources\AkunPenerimaans;

use App\Filament\Resources\AkunPenerimaans\Pages\CreateAkunPenerimaan;
use App\Filament\Resources\AkunPenerimaans\Pages\EditAkunPenerimaan;
use App\Filament\Resources\AkunPenerimaans\Pages\ListAkunPenerimaans;
use App\Filament\Resources\AkunPenerimaans\Schemas\AkunPenerimaanForm;
use App\Filament\Resources\AkunPenerimaans\Tables\AkunPenerimaansTable;
use App\Models\AkunPenerimaan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AkunPenerimaanResource extends Resource
{
    protected static ?string $model = AkunPenerimaan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'AkunPenerimaan';

    protected static ?string $modelLabel = 'Akun Penerimaan';
    protected static ?string $pluralModelLabel = 'Akun Penerimaan';

    public static function getNavigationLabel(): string
    {
        return __('Akun Penerimaan');
    }

    public static function form(Schema $schema): Schema
    {
        return AkunPenerimaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AkunPenerimaansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAkunPenerimaans::route('/'),
            'create' => CreateAkunPenerimaan::route('/create'),
            'edit' => EditAkunPenerimaan::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
