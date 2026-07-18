<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\PengajuanSkpiController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\SkpiController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\MahasiswaCrudController;
use App\Http\Controllers\Admin\CplProdiController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\SistemPenilaianController;
use App\Http\Controllers\Admin\KategoriCplController;
use App\Http\Controllers\TugasAkhirController;
Route::get('/', function () {
    return (Auth::guard('web')->check() || Auth::guard('mahasiswa')->check()) ? redirect()->route('dashboard') : view('landing');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verify/skpi/{id_skpi}', [SkpiController::class, 'verify'])->name('skpi.verify');
Route::middleware(['auth:web,mahasiswa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/skpi/{id_pengajuan}/print', [SkpiController::class, 'print'])->name('bak_fakultas.skpi.print');
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('role:mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/tugas-akhir', [MahasiswaController::class, 'editTugasAkhir'])->name('tugas_akhir.edit');
        Route::post('/tugas-akhir', [MahasiswaController::class, 'updateTugasAkhir'])->name('tugas_akhir.update');

        Route::post('/pengajuan/submit', [PengajuanSkpiController::class, 'submit'])->name('pengajuan.submit');
        Route::post('/pengajuan/request-print', [PengajuanSkpiController::class, 'requestPrint'])->name('pengajuan.request_print');
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('role:mahasiswa,bak_fakultas,admin')->group(function () {
        Route::get('prestasi/data', [PrestasiController::class, 'datatable'])->name('prestasi.datatable');
        Route::get('organisasi/data', [OrganisasiController::class, 'datatable'])->name('organisasi.datatable');
        Route::get('sertifikat/data', [SertifikatController::class, 'datatable'])->name('sertifikat.datatable');
        Route::get('magang/data', [MagangController::class, 'datatable'])->name('magang.datatable');

        Route::resource('prestasi', PrestasiController::class)->except(['show']);
        Route::resource('organisasi', OrganisasiController::class)->except(['show']);
        Route::resource('sertifikat', SertifikatController::class)->except(['show']);
        Route::resource('magang', MagangController::class)->except(['show']);
    });

    Route::prefix('bak-fakultas')->name('bak_fakultas.')->group(function () {
        Route::middleware('role:bak_fakultas,admin')->group(function () {
            Route::get('tugas-akhir/data', [TugasAkhirController::class, 'datatable'])->name('tugas_akhir.datatable');
            Route::resource('tugas-akhir', TugasAkhirController::class)->except(['show'])->names('tugas_akhir');
        });

        Route::middleware('role:bak_fakultas,admin')->group(function () {
            Route::get('/dashboard', [VerifikasiController::class, 'dashboard'])->name('dashboard');
            Route::get('/data', [VerifikasiController::class, 'datatable'])->name('datatable');
            Route::get('/verifikasi/{id_pengajuan}', [VerifikasiController::class, 'detail'])->name('verifikasi.detail');
            Route::post('/verifikasi/{id_pengajuan}/publish', [VerifikasiController::class, 'publish'])->name('verifikasi.publish');
            Route::post('/verifikasi/{id_pengajuan}/checklist', [VerifikasiController::class, 'submitChecklist'])->name('verifikasi.checklist');
            Route::post('/verifikasi/{id_pengajuan}/cancel-print', [VerifikasiController::class, 'cancelPrint'])->name('verifikasi.cancel_print');
            Route::post('/tugas-akhir/{id}/approve', [VerifikasiController::class, 'approveTugasAkhir'])->name('tugas_akhir.approve');
            Route::post('/tugas-akhir/{id}/reject', [VerifikasiController::class, 'rejectTugasAkhir'])->name('tugas_akhir.reject');
            Route::post('/pengajuan-cetak/{id_pengajuan}/approve', [VerifikasiController::class, 'approvePengajuanCetak'])->name('pengajuan_cetak.approve');
            Route::post('/pengajuan-cetak/{id_pengajuan}/reject', [VerifikasiController::class, 'rejectPengajuanCetak'])->name('pengajuan_cetak.reject');
            Route::post('/{type}/{id}/approve', [VerifikasiController::class, 'approveItem'])->name('data.approve');
            Route::post('/{type}/{id}/reject', [VerifikasiController::class, 'rejectItem'])->name('data.reject');
        });
    });
    Route::prefix('akademik')->middleware('role:admin,bak_fakultas')->group(function () {
        Route::get('mahasiswa/data', [MahasiswaCrudController::class, 'datatable'])->name('mahasiswa.datatable');
        Route::get('cpl/data', [CplProdiController::class, 'datatable'])->name('cpl.datatable');
        Route::get('kurikulum/data', [KurikulumController::class, 'datatable'])->name('kurikulum.datatable');
        Route::get('fakultas/data', [FakultasController::class, 'datatable'])->name('fakultas.datatable');
        Route::get('prodi/data', [ProgramStudiController::class, 'datatable'])->name('prodi.datatable');
        Route::get('kategori-cpl/data', [KategoriCplController::class, 'datatable'])->name('kategori-cpl.datatable');
        
        Route::resource('mahasiswa', MahasiswaCrudController::class);
        Route::resource('cpl', CplProdiController::class);
        Route::post('kurikulum/sync', [KurikulumController::class, 'sync'])->name('kurikulum.sync');
        Route::resource('kurikulum', KurikulumController::class);
        Route::post('fakultas/sync', [FakultasController::class, 'sync'])->name('fakultas.sync');
        Route::resource('fakultas', FakultasController::class);
        Route::post('prodi/sync', [ProgramStudiController::class, 'sync'])->name('prodi.sync');
        Route::resource('prodi', ProgramStudiController::class);
        Route::resource('kategori-cpl', KategoriCplController::class);
    });
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [MasterDataController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('penilaian/data', [SistemPenilaianController::class, 'datatable'])->name('penilaian.datatable');
        Route::get('users/data', [UserController::class, 'datatable'])->name('users.datatable');
        Route::get('tahun-akademik/data', [\App\Http\Controllers\Admin\TahunAkademikController::class, 'datatable'])->name('tahun-akademik.datatable');
        Route::post('tahun-akademik/sync', [\App\Http\Controllers\Admin\TahunAkademikController::class, 'sync'])->name('tahun-akademik.sync');
        Route::get('tahun-akademik', [\App\Http\Controllers\Admin\TahunAkademikController::class, 'index'])->name('tahun-akademik.index');
        Route::resource('penilaian', SistemPenilaianController::class);
        Route::resource('users', UserController::class);
    });
});
