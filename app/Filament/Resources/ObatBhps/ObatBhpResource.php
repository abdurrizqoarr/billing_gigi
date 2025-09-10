<?php

namespace App\Filament\Resources\ObatBhps;

use App\Filament\Resources\ObatBhps\Pages\CreateObatBhp;
use App\Filament\Resources\ObatBhps\Pages\EditObatBhp;
use App\Filament\Resources\ObatBhps\Pages\ListObatBhps;
use App\Filament\Resources\ObatBhps\Schemas\ObatBhpForm;
use App\Filament\Resources\ObatBhps\Tables\ObatBhpsTable;
use App\Models\ObatBhp;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObatBhpResource extends Resource
{
    protected static ?string $model = ObatBhp::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'Obat & BHP';
    protected static ?string $pluralModelLabel = 'Obat & BHP';

    public static function getNavigationLabel(): string
    {
        return __('Obat & BHP');
    }

    public static function form(Schema $schema): Schema
    {
        return ObatBhpForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ObatBhpsTable::configure($table);
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
            'index' => ListObatBhps::route('/'),
            'create' => CreateObatBhp::route('/create'),
            'edit' => EditObatBhp::route('/{record}/edit'),
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
