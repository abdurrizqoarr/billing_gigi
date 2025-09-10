<?php

namespace App\Filament\Resources\TarifTindakans;

use App\Filament\Resources\TarifTindakans\Pages\CreateTarifTindakan;
use App\Filament\Resources\TarifTindakans\Pages\EditTarifTindakan;
use App\Filament\Resources\TarifTindakans\Pages\ListTarifTindakans;
use App\Filament\Resources\TarifTindakans\Schemas\TarifTindakanForm;
use App\Filament\Resources\TarifTindakans\Tables\TarifTindakansTable;
use App\Models\TarifTindakan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TarifTindakanResource extends Resource
{
    protected static ?string $model = TarifTindakan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Tarif Tindakan';
    protected static ?string $pluralModelLabel = 'Tarif Tindakan';

    public static function getNavigationLabel(): string
    {
        return __('Tarif Tindakan');
    }

    public static function form(Schema $schema): Schema
    {
        return TarifTindakanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TarifTindakansTable::configure($table);
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
            'index' => ListTarifTindakans::route('/'),
            'create' => CreateTarifTindakan::route('/create'),
            'edit' => EditTarifTindakan::route('/{record}/edit'),
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
