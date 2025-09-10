<?php

namespace App\Filament\Pages;

use App\Models\RiwayatTransaksi;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;

class Transaksi extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public function table(Table $table): Table
    {
        return $table
            ->query(RiwayatTransaksi::query())
            ->columns([
                TextColumn::make('pegawais.name')
                    ->label('Nama Pegawai')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registrasi.total_biaya')
                    ->label('Pemasukan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('akunPenerimaan.akun_penerimaan')->sortable(),
                TextColumn::make('waktu_transaksi')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('tanggal')
                    ->schema([
                        DatePicker::make('from')
                            ->label('Dari Tanggal')
                            ->default(now()),
                        DatePicker::make('until')
                            ->label('Sampai Tanggal')
                            ->default(now()),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'],
                                fn($q, $date) => $q->whereDate('riwayat_transaksi.created_at', '>=', $date)
                            )
                            ->when(
                                $data['until'],
                                fn($q, $date) => $q->whereDate('riwayat_transaksi.created_at', '<=', $date)
                            );
                    }),
                SelectFilter::make('akun_penerimaan_id')
                    ->label('Akun Penerimaan')
                    ->relationship('akunPenerimaan', 'akun_penerimaan')
                    ->searchable(),
            ]);
    }

    public function getTotalPendapatanProperty(): float
    {
        return $this->getFilteredTableQuery()
            ->join('registrasi_pasien', 'riwayat_transaksi.registrasi_id', '=', 'registrasi_pasien.id')
            ->sum('registrasi_pasien.total_biaya');
    }

    protected string $view = 'filament.pages.transaksi';
}
