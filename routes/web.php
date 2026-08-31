<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\BackupDatabaseController;
use App\Http\Controllers\BentukKegiatanController;
use App\Http\Controllers\BerkasMoAController;
use App\Http\Controllers\BerkasMoUController;
use App\Http\Controllers\DaftarFakultasController;
use App\Http\Controllers\DaftarProdiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\GeoMitraController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\ManajemenKerjasamaController;
use App\Http\Controllers\ManajemenMitraController;
use App\Http\Controllers\PengajuanRencanaController;
use App\Http\Controllers\PicmitraController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\RepositoryKerjasamaController;
use App\Http\Controllers\RuangLingkupController;
use App\Http\Controllers\SasaranKerjaController;
use App\Models\BentukKegiatan;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK GUEST (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::redirect('/', 'login');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('login.authenticate');

    // Captcha routes
    Route::get('captcha/{config?}', '\Mews\Captcha\CaptchaController@getCaptcha')->name('captcha');
    Route::get('captcha/api/{config?}', '\Mews\Captcha\CaptchaController@getCaptchaApi')->name('captcha.api');
});

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK USER YANG SUDAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ========================================
    // BROADCASTING ROUTES
    // ========================================
    Broadcast::routes();

    // ========================================
    // DASHBOARD
    // ========================================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index')
        ->middleware('permission:dashboard.view');


    // ========================================
    // SUPERADMIN ROUTE
    // ========================================
    Route::post('/dashboard/optimize', [DashboardController::class, 'optimize'])
    ->name('pengaturan.optimize');
    Route::post('/dashboard/clear-log', [DashboardController::class, 'clearLog'])->name('dashboard.clear-log');
    Route::group(['prefix' => 'log-activity', 'as' => 'log-activity.'], function () {
        Route::get('/', [LogActivityController::class, 'index'])
            ->name('index')
            ->middleware('permission:log_activity.view');
        Route::get('/export', [LogActivityController::class, 'exportExcel'])->name('export')->middleware('permission:log_activity.export');
        Route::get('/json', [LogActivityController::class, 'datatables'])
            ->name('datatables')
            ->middleware('permission:log_activity.view');
    });

    Route::group(['prefix' => 'master-data', 'as' => 'master-data.'], function () {
        // Master Data Kategori
        Route::group(['prefix' => 'kategori', 'as' => 'kategori_mitra.'], function () {
            Route::get('/', [KategoriController::class, 'index'])
                ->name('index')
                ->middleware('permission:kategori_mitra.view');
             Route::get('/data', [KategoriController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:kategori_mitra.view');
            Route::get('/create', [KategoriController::class, 'create'])
                ->name('create')
                ->middleware('permission:kategori_mitra.create');
            Route::post('/store', [KategoriController::class, 'store'])
                ->name('store')
                ->middleware('permission:kategori_mitra.create');
            Route::get('/{id}/edit', [KategoriController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:kategori_mitra.edit');
            Route::put('/{id}/update', [KategoriController::class, 'update'])
                ->name('update')
                ->middleware('permission:kategori_mitra.edit');
            Route::delete('/{id}/delete', [KategoriController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:kategori_mitra.delete');
        });

         // Master Data Daftar Fakultas
        Route::group(['prefix' => 'daftar_fakultas', 'as' => 'daftar_fakultas.'], function () {
            Route::get('/', [FakultasController::class, 'index'])
                ->name('index')
                ->middleware('permission:daftar_fakultas.view');
            Route::get('/data', [FakultasController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:daftar_fakultas.view');
            Route::get('/create', [FakultasController::class, 'create'])
                ->name('create')
                ->middleware('permission:daftar_fakultas.create');
            Route::post('/store', [FakultasController::class, 'store'])
                ->name('store')
                ->middleware('permission:daftar_fakultas.create');
            Route::get('/{id}/edit', [FakultasController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:daftar_fakultas.edit');
            Route::get('/{fakultas_id}/prodi', [FakultasController::class, 'detail_prodi'])
                ->name('detail')
                ->middleware('permission:daftar_fakultas.detail');;
            Route::put('/{id}/update', [FakultasController::class, 'update'])
                ->name('update')
                ->middleware('permission:daftar_fakultas.edit');
            Route::delete('/{id}/delete', [FakultasController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:daftar_fakultas.delete');
        });

         // Master Data Daftar Prodi
        Route::group(['prefix' => 'daftar-prodi', 'as' => 'daftar_prodi.'], function () {
            Route::get('/', [ProdiController::class, 'index'])
                ->name('index')
                ->middleware('permission:daftar_prodi.view');
            Route::get('/data', [ProdiController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:daftar_prodi.view');
            Route::get('/create', [ProdiController::class, 'create'])
                ->name('create')
                ->middleware('permission:daftar_prodi.create');
            Route::post('/store', [ProdiController::class, 'store'])
                ->name('store')
                ->middleware('permission:daftar_prodi.create');
            Route::get('/{id}/edit', [ProdiController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:daftar_prodi.edit');
            Route::put('/{id}/update', [ProdiController::class, 'update'])
                ->name('update')
                ->middleware('permission:daftar_prodi.edit');
            Route::delete('/{id}/delete', [ProdiController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:daftar_prodi.delete');
        });

         // Master Data Daftar jenis dokumen
        Route::group(['prefix' => 'jenis-dokumen', 'as' => 'jenis_dokumen.'], function () {
            Route::get('/', [JenisDokumenController::class, 'index'])
                ->name('index')
                ->middleware('permission:jenis_dokumen.view');
            Route::get('/data', [JenisDokumenController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:jenis_dokumen.view');
            Route::get('/create', [JenisDokumenController::class, 'create'])
                ->name('create')
                ->middleware('permission:jenis_dokumen.create');
            Route::post('/store', [JenisDokumenController::class, 'store'])
                ->name('store')
                ->middleware('permission:jenis_dokumen.create');
            Route::get('/{id}/edit', [JenisDokumenController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:jenis_dokumen.edit');
            Route::put('/{id}/update', [JenisDokumenController::class, 'update'])
                ->name('update')
                ->middleware('permission:jenis_dokumen.edit');
            Route::delete('/{id}/delete', [JenisDokumenController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:jenis_dokumen.delete');
        });
        // Jenis Kegiatan
        Route::group(['prefix' => 'jenis-kegiatan', 'as' => 'jenis_kegiatan.'], function () {
            Route::get('/', [BentukKegiatanController::class, 'index'])
                ->name('index')
                ->middleware('permission:jenis_dokumen.view');
            Route::get('/data', [BentukKegiatanController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:jenis_dokumen.view');
            Route::get('/create', [BentukKegiatanController::class, 'create'])
                ->name('create')
                ->middleware('permission:jenis_dokumen.create');
            Route::post('/store', [BentukKegiatanController::class, 'store'])
                ->name('store')
                ->middleware('permission:jenis_dokumen.create');
            Route::get('/{id}/edit', [BentukKegiatanController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:jenis_dokumen.edit');
            Route::put('/{id}/update', [BentukKegiatanController::class, 'update'])
                ->name('update')
                ->middleware('permission:jenis_dokumen.edit');
            Route::delete('/{id}/delete', [BentukKegiatanController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:jenis_dokumen.delete');
        });

        Route::group(['prefix' => 'sasaran-kerja', 'as' => 'sasaran_kerja.'], function () {
            Route::get('/', [SasaranKerjaController::class, 'index'])
                ->name('index')
                ->middleware('permission:jenis_dokumen.view');
            Route::get('/data', [SasaranKerjaController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:jenis_dokumen.view');
            Route::get('/create', [SasaranKerjaController::class, 'create'])
                ->name('create')
                ->middleware('permission:jenis_dokumen.create');
            Route::post('/store', [SasaranKerjaController::class, 'store'])
                ->name('store')
                ->middleware('permission:jenis_dokumen.create');
            Route::get('/{id}/edit', [SasaranKerjaController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:jenis_dokumen.edit');
            Route::put('/{id}/update', [SasaranKerjaController::class, 'update'])
                ->name('update')
                ->middleware('permission:jenis_dokumen.edit');
                Route::delete('/{id}/delete', [SasaranKerjaController::class, 'destroy'])
                ->name('destroy');
                Route::get('/{id}/detail', [SasaranKerjaController::class, 'show'])
                ->name('show')
                ->middleware('permission:jenis_dokumen.delete');
                Route::delete('/{id}/delete/indikator', [SasaranKerjaController::class, 'destroyIndikator'])
                ->name('destroy_indikator')
                ->middleware('permission:jenis_dokumen.delete');
                Route::put('/{id}/update/indikator', [SasaranKerjaController::class, 'updateIndikator'])
                    ->name('update_indikator')
                    ->middleware('permission:jenis_dokumen.edit');
                Route::post('{id}/store/indikator', [SasaranKerjaController::class, 'storeIndikator'])
                ->name('store_indikator')
                ->middleware('permission:jenis_dokumen.create');
                });


         // Master Data Daftar Ruanglinkgup
        Route::group(['prefix' => 'ruang_lingkup', 'as' => 'ruang_lingkup.'], function () {
            Route::get('/', [RuangLingkupController::class, 'index'])
                ->name('index')
                ->middleware('permission:ruang_lingkup.view');
            Route::get('/create', [RuangLingkupController::class, 'create'])
                ->name('create')
                ->middleware('permission:ruang_lingkup.create');
            Route::get('/data', [RuangLingkupController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:ruang_lingkup.view');
            Route::post('/store', [RuangLingkupController::class, 'store'])
                ->name('store')
                ->middleware('permission:ruang_lingkup.create');
            Route::get('/{id}/edit', [RuangLingkupController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:ruang_lingkup.edit');
            Route::put('/{id}/update', [RuangLingkupController::class, 'update'])
                ->name('update')
                ->middleware('permission:ruang_lingkup.edit');
            Route::delete('/{id}/delete', [RuangLingkupController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:ruang_lingkup.delete');
        });
    });

    //Prodi
    Route::group(['prefix' => 'Rencana-Kerjasama', 'as' => 'rencana-kerjasama.'], function () {
            Route::get('/', [PengajuanRencanaController::class, 'index'])
                ->name('index');
                // ->middleware('permission:rencana_kerjasama.view');
             Route::get('/data', [PengajuanRencanaController::class, 'getData'])
                ->name('getData');
                // ->middleware('permission:rencana_kerjasama.view');
            Route::get('/create', [PengajuanRencanaController::class, 'create'])
                ->name('create');
                // ->middleware('permission:rencana_kerjasama.create');
            Route::post('/store', [PengajuanRencanaController::class, 'store'])
                ->name('store');
                // ->middleware('permission:rencana_kerjasama.create');
            Route::get('/{id}/edit', [PengajuanRencanaController::class, 'edit'])
                ->name('edit');
                // ->middleware('permission:rencana_kerjasama.edit');
            Route::put('/{id}/update', [PengajuanRencanaController::class, 'update'])
                ->name('update');
                // ->middleware('permission:rencana_kerjasama.edit');
            Route::delete('/{id}/delete', [PengajuanRencanaController::class, 'destroy'])
                ->name('destroy');
                // ->middleware('permission:rencana_kerjasama.delete');
            Route::get('/{id}/detail', [PengajuanRencanaController::class, 'show'])
                ->name('show');
                // ->middleware('permission:rencana_kerjasama.view');
            Route::patch('/{id}/update-feedback', [PengajuanRencanaController::class, 'upadatefeedback'])
                ->name('update-feedback');
                // ->middleware('permission:rencana_kerjasama.view');
            Route::get('/{id}/file', [PengajuanRencanaController::class, 'viewFile'])
                ->name('view-file');
    });

    Route::group(['prefix' => 'Berkas-MoU', 'as' => 'berkas-MoU.'], function () {
            Route::get('/', [BerkasMoUController::class, 'index'])
                ->name('index');
                // ->middleware('permission:berkas_mou.view');
             Route::get('/data', [BerkasMoUController::class, 'getData'])
                ->name('getData');
                // ->middleware('permission:berkas_mou.view');
            Route::get('/create', [BerkasMoUController::class, 'create'])
                ->name('create');
                // ->middleware('permission:berkas_mou.create');
            Route::post('/store', [BerkasMoUController::class, 'store'])
                ->name('store');
                // ->middleware('permission:berkas_mou.create');
            Route::get('/{id}/edit', [BerkasMoUController::class, 'edit'])
                ->name('edit');
                // ->middleware('permission:berkas_mou.edit');
            Route::put('/{id}/update', [BerkasMoUController::class, 'update'])
                ->name('update');
                // ->middleware('permission:berkas_mou.edit');
            Route::delete('/{id}/delete', [BerkasMoUController::class, 'destroy'])
                ->name('destroy');
                // ->middleware('permission:berkas_mou.delete');
            Route::get('/{id}/detail', [BerkasMoUController::class, 'show'])
                ->name('show');
                // ->middleware('permission:berkas_mou.view');
            Route::patch('/{id}/update-feedback', [BerkasMoUController::class, 'updateFeedback'])
                ->name('update-feedback');
            Route::get('/{id}/file', [BerkasMoUController::class, 'viewFile'])
                ->name('view-file');
             Route::get('/{id}/file', [BerkasMoUController::class, 'viewFileFinal'])
                ->name('view-file-final');
    });

     Route::group(['prefix' => 'Berkas-MoA', 'as' => 'berkas-MoA.'], function () {
            Route::get('/', [BerkasMoAController::class, 'index'])
                ->name('index');
                // ->middleware('permission:berkas_mou.view');
             Route::get('/data', [BerkasMoAController::class, 'getData'])
                ->name('getData');
                // ->middleware('permission:berkas_mou.view');
            Route::get('/create', [BerkasMoAController::class, 'create'])
                ->name('create');
                // ->middleware('permission:berkas_mou.create');
            Route::post('/store', [BerkasMoAController::class, 'store'])
                ->name('store');
                // ->middleware('permission:berkas_mou.create');
            Route::get('/{id}/edit', [BerkasMoAController::class, 'edit'])
                ->name('edit');
                // ->middleware('permission:berkas_mou.edit');
            Route::put('/{id}/update', [BerkasMoAController::class, 'update'])
                ->name('update');
                // ->middleware('permission:berkas_mou.edit');
            Route::delete('/{id}/delete', [BerkasMoAController::class, 'destroy'])
                ->name('destroy');
                // ->middleware('permission:berkas_mou.delete');
            Route::get('/{id}/detail', [BerkasMoAController::class, 'show'])
                ->name('show');
                // ->middleware('permission:berkas_mou.view');
    });

    //Operator
        Route::group(['prefix' => 'Manajemen-Kerjasama', 'as' => 'Manajemen-Kerjasama.'], function () {
            Route::get('/', [ManajemenKerjasamaController::class, 'index'])
                ->name('index')
                ->middleware('permission:kerjasama.view');
             Route::get('/data', [ManajemenKerjasamaController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:kerjasama.view');
            Route::get('/create', [ManajemenKerjasamaController::class, 'create'])
                ->name('create')
                ->middleware('permission:kerjasama.create');
            Route::post('/store', [ManajemenKerjasamaController::class, 'store'])
                ->name('store')
                ->middleware('permission:kerjasama.create');
            Route::get('/{id}/edit', [ManajemenKerjasamaController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:kerjasama.edit');
            Route::put('/{id}/update', [ManajemenKerjasamaController::class, 'update'])
                ->name('update')
                ->middleware('permission:kerjasama.edit');
            Route::delete('/{id}/delete', [ManajemenKerjasamaController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:kerjasama.delete');

        });

        Route::group(['prefix' => 'Manajemen-Mitra', 'as' => 'Manajemen-Mitra.'], function () {
            Route::get('/', [ManajemenMitraController::class, 'index'])
                ->name('index')
                ->middleware('permission:mitra.view');
                Route::get('/{id}/detail', [ManajemenMitraController::class, 'show'])
            ->name('show')
            ->middleware('permission:mitra.view'); // perlu di add permission
             Route::get('/data', [ManajemenMitraController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:mitra.view');
            Route::get('/create', [ManajemenMitraController::class, 'create'])
                ->name('create')
                ->middleware('permission:mitra.create');
            Route::post('/store', [ManajemenMitraController::class, 'store'])
                ->name('store')
                ->middleware('permission:mitra.create');
            Route::get('/{id}/edit', [ManajemenMitraController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:mitra.edit');
            Route::put('/{id}/update', [ManajemenMitraController::class, 'update'])
                ->name('update')
                ->middleware('permission:mitra.edit');
            Route::delete('/{id}/delete', [ManajemenMitraController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:mitra.delete');
        });


        Route::group(['prefix' => 'PIC-MITRA', 'as' => 'Pic-Mitra.'], function () {
            Route::get('/{mitra_id}/data', [PicmitraController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:mitra.view');
            Route::get('/{mitra_id}/create', [PicmitraController::class, 'create'])
                ->name('create')
                ->middleware('permission:mitra.create');
            Route::post('/store', [PicmitraController::class, 'store'])
                ->name('store')
                ->middleware('permission:mitra.create');
            Route::get('/{id}/edit', [PicmitraController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:mitra.edit');
            Route::put('/{id}/update', [PicmitraController::class, 'update'])
                ->name('update')
                ->middleware('permission:mitra.edit');
            Route::delete('{id}/delete', [PicmitraController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:mitra.delete');// perlu di add permission
        });

        Route::group(['prefix' => 'Manajemen-Kerjasama', 'as' => 'Manajemen-Kerjasama.'], function () {
            Route::get('/', [ManajemenKerjasamaController::class, 'index'])
                ->name('index')
                ->middleware('permission:mitra.view');
            Route::get('/{id}/detail', [ManajemenKerjasamaController::class, 'show'])
            ->name('show')
            ->middleware('permission:mitra.view'); // perlu di add permission
             Route::get('/data', [ManajemenKerjasamaController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:mitra.view');
            Route::get('/create', [ManajemenKerjasamaController::class, 'create'])
                ->name('create')
                ->middleware('permission:mitra.create');
            Route::post('/store', [ManajemenKerjasamaController::class, 'store'])
                ->name('store')
                ->middleware('permission:mitra.create');
            Route::get('/{id}/edit', [ManajemenKerjasamaController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:mitra.edit');
            Route::put('/{id}/update', [ManajemenKerjasamaController::class, 'update'])
                ->name('update')
                ->middleware('permission:mitra.edit');
            Route::delete('/{id}/delete', [ManajemenKerjasamaController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:mitra.delete');
        });

        Route::group(['prefix' => 'Repository_kerjasama', 'as' => 'Repository_kerjasama.'], function () {
            Route::get('/', [RepositoryKerjasamaController::class, 'index'])
                ->name('index')
                ->middleware('permission:mitra.view');
            Route::get('/{id}/detail', [RepositoryKerjasamaController::class, 'show'])
            ->name('show')
            ->middleware('permission:mitra.view'); // perlu di add permission
            Route::get('/data', [RepositoryKerjasamaController::class, 'getData'])
                ->name('getData')
                ->middleware('permission:mitra.view');
            Route::get('/data/indikator/{sasaran_id}', [RepositoryKerjasamaController::class, 'getIndikatorBySasaran'])
                ->name('getIndikatorBySasaran')
                ->middleware('permission:mitra.view');
            Route::get('/create', [RepositoryKerjasamaController::class, 'create'])
                ->name('create')
                ->middleware('permission:mitra.create');
            Route::post('/store', [RepositoryKerjasamaController::class, 'store'])
                ->name('store')
                ->middleware('permission:mitra.create');
            Route::get('/{id}/edit', [RepositoryKerjasamaController::class, 'edit'])
                ->name('edit')
                ->middleware('permission:mitra.edit');
            Route::put('/{id}/update', [RepositoryKerjasamaController::class, 'update'])
                ->name('update')
                ->middleware('permission:mitra.edit');
            Route::delete('/{id}/delete', [RepositoryKerjasamaController::class, 'destroy'])
                ->name('destroy')
                ->middleware('permission:mitra.delete');
            Route::get('view-file/{id}', [RepositoryKerjasamaController::class, 'viewFile'])
            ->name('view-file')
            ->middleware('signed');
            Route::get('get-indikator/{id}', [RepositoryKerjasamaController::class, 'getindikator'])
            ->name('getindikator');

        });

        Route::get('/geo-mitra',[GeoMitraController::class,'index'])->name('geomitra.index');




    // ========================================
    // MODULE: NOTIFIKASI
    // ========================================
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/datatables', [NotifikasiController::class, 'datatables'])->name('datatables');
        Route::get('/terbaru', [NotifikasiController::class, 'getNotifikasiTerbaru'])->name('terbaru');
        Route::get('/jumlah-belum-dibaca', [NotifikasiController::class, 'getJumlahBelumDibaca'])->name('jumlah-belum-dibaca');
        Route::post('/{id}/tandai-dibaca', [NotifikasiController::class, 'tandaiSudahDibaca'])->whereNumber('id')->name('tandai-dibaca');
        Route::post('/tandai-semua-dibaca', [NotifikasiController::class, 'tandaiSemuaSudahDibaca'])->name('tandai-semua-dibaca');
        Route::delete('/hapus-sudah-dibaca', [NotifikasiController::class, 'hapusSemuaSudahDibaca'])->name('hapus-sudah-dibaca');
        Route::delete('/{id}', [NotifikasiController::class, 'hapus'])->whereNumber('id')->name('hapus');
        Route::get('/{id}/buka', [NotifikasiController::class, 'buka'])->whereNumber('id')->name('buka');
    });

    // ========================================
    // MODULE: BACKUP DATABASE
    // ========================================
    Route::prefix('backup-database')->name('backup-database.')->group(function () {
        Route::middleware('permission:backup_database.view')->group(function () {
            Route::get('/', [BackupDatabaseController::class, 'index'])->name('index');
            Route::get('/datatables', [BackupDatabaseController::class, 'datatables'])->name('datatables');
        });

        Route::middleware('permission:backup_database.create')->group(function () {
            Route::post('/backup', [BackupDatabaseController::class, 'backup'])->name('backup');
        });

        Route::middleware('permission:backup_database.download')->group(function () {
            Route::get('/download/{file}', [BackupDatabaseController::class, 'download'])->name('download');
        });

        Route::middleware('permission:backup_database.delete')->group(function () {
            Route::delete('/{file}', [BackupDatabaseController::class, 'destroy'])->name('destroy');
        });
    });

    // ========================================
    // MODULE: ROLE MANAGEMENT
    // ========================================
    Route::prefix('role')->name('role.')->group(function () {
        Route::middleware('permission:role.view')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/datatables', [RoleController::class, 'datatables'])->name('datatables');
            Route::get('/detail/{id}', [RoleController::class, 'show'])->name('show');
        });

        Route::middleware('permission:role.create')->group(function () {
            Route::get('/tambah', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
        });

        Route::middleware('permission:role.edit')->group(function () {
            Route::get('/ubah/{id}', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update');
        });

        Route::middleware('permission:role.delete')->group(function () {
            Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
        });
    });

    // ========================================
    // MODULE: USER MANAGEMENT
    // ========================================
    Route::prefix('user')->name('user.')->group(function () {
        Route::middleware('permission:user.view')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/datatables', [UserController::class, 'datatables'])->name('datatables');
            Route::get('/detail/{id}', [UserController::class, 'show'])->name('show');
        });

        Route::middleware('permission:user.create')->group(function () {
            Route::get('/tambah', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store.data');
        });

        Route::middleware('permission:user.edit')->group(function () {
            Route::get('/ubah/{id}', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
        });

        Route::middleware('permission:user.delete')->group(function () {
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });
    });

    // ========================================
    // MODULE: PENGATURAN
    // ========================================
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::middleware('permission:pengaturan.view')->group(function () {
            Route::get('/', [PengaturanController::class, 'index'])->name('index');
        });

        Route::middleware('permission:pengaturan.edit')->group(function () {
            Route::get('/ubah', [PengaturanController::class, 'edit'])->name('edit');
            Route::put('/', [PengaturanController::class, 'update'])->name('update');
        });
    });

    // ========================================
    // MODULE: PROFIL & PASSWORD (Personal)
    // ========================================
    Route::middleware('permission:profile.edit')->group(function () {
        Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    });

    Route::middleware('permission:password.change')->group(function () {
        Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    });

    // ========================================
    // LOGOUT
    // ========================================
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');




     // API
            Route::get('/api/get-prodi-by-fakultas/{id}', [ManajemenKerjasamaController::class, 'getProdiByFakultas']);
            Route::get('/api/get-next-nomor/{jenisId}', [ManajemenKerjasamaController::class, 'getNextNomor']);
});
