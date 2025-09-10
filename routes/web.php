<?php

use App\Http\Controllers\CetakNotaController;
use App\Http\Middleware\CekLogin;
use App\Http\Middleware\KhususDokter;
use App\Http\Middleware\RedirectIfLogin;
use App\Livewire\BillingPasienPage;
use App\Livewire\DashboardPage;
use App\Livewire\EditBillingPasienPage;
use App\Livewire\LoginPage;
use App\Livewire\PembayaranPage;
use Illuminate\Support\Facades\Route;

Route::get('/', LoginPage::class)->name('login-page')->middleware(RedirectIfLogin::class);

Route::middleware(CekLogin::class)->group(function () {
    Route::get('/dashboard', DashboardPage::class)->name('dashboard-page');
    Route::get('/add-pasien', BillingPasienPage::class)->name('billing-page')->middleware(KhususDokter::class);
    Route::get('/edit-pasien/{id}', EditBillingPasienPage::class)->name('pasien.edit')->middleware(KhususDokter::class);
    Route::get('/pembayaran/{id}', PembayaranPage::class)->name('pembayaran');

    Route::get('/cetak-nota/{id}', [CetakNotaController::class, "cetak"])->name('pasien.cetak');
});
