<?php


use App\Http\Controllers\Admin\AsetKantor\KategoriAsetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Finance\CoaController;
use App\Http\Controllers\Admin\Finance\SubKategoriAnggaranController;
use App\Http\Controllers\Admin\Finance\KategoriAnggaranController;
use App\Http\Controllers\Admin\Finance\KelompokAkunCoaController;
use App\Http\Controllers\Admin\Finance\MasterBankController;
use App\Http\Controllers\Admin\Finance\MasterPeriodeAnggaranController;
use App\Http\Controllers\Admin\HR\DapertemenController;
use App\Http\Controllers\Admin\HR\JabatanController;
use App\Http\Controllers\Admin\RoleControlelr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Route Super Admin
|--------------------------------------------------------------------------
*/

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard_admin');


    Route::get('/role', [RoleControlelr::class, 'index'])
        ->name('role');
    Route::get('/role/data', [RoleControlelr::class, 'data'])
        ->name('role.data');
    Route::post('/role/simpan', [RoleControlelr::class, 'simpan'])
        ->name('role.simpan');
    Route::post('role/hapus', [RoleControlelr::class, 'hapus'])
        ->name('role.hapus');


    /*
        |--------------------------------------------------------------------------
        | Route Bagian HR Untuk Admin Manajemen Dapertemen
        |--------------------------------------------------------------------------
        */

    Route::get('/hr/dapertemen', [DapertemenController::class, 'index'])
        ->name('dapertemen');
    Route::get('/hr/dapertemen/data', [DapertemenController::class, 'data'])
        ->name('dapertemen.data');
    Route::post('/hr/dapertemen/simpan', [DapertemenController::class, 'simpan'])
        ->name('dapertemen.simpan');
    Route::get('/hr/dapertemen/getDataById/{id}', [DapertemenController::class, 'getDataById'])
        ->name('dapertemen.getDataById');
    Route::post('/hr/dapertemen/update', [DapertemenController::class, 'update'])
        ->name('dapertemen.update');
    Route::post('/hr/dapertemen/hapus', [DapertemenController::class, 'hapus'])
        ->name('dapertemen.hapus');


    /*
    |--------------------------------------------------------------------------
    | Route Bagian HR Untuk Admin Manajemen Jabatan
    |--------------------------------------------------------------------------
    */

    Route::get('/hr/jabatan', [JabatanController::class, 'index'])
        ->name('jabatan');
    Route::get('/hr/jabatan/data', [JabatanController::class, 'data'])
        ->name('jabatan.data');
    Route::get('/hr/jabatan/listDapertemen', [JabatanController::class, 'listDapertemen'])
        ->name('jabatan.listDapertemen');
    Route::post('/hr/jabatan/simpan', [JabatanController::class, 'simpan'])
        ->name('jabatan.simpan');
    Route::get('/hr/jabatan/getDataById/{id}', [JabatanController::class, 'getDataById'])
        ->name('jabatan.getDataById');
    Route::post('/hr/jabatan/update', [JabatanController::class, 'update'])
        ->name('jabatan.update');
    Route::post('/hr/jabatan/hapus', [JabatanController::class, 'hapus'])
        ->name('jabatan.hapus');


    /*
    |--------------------------------------------------------------------------
    | Route Bagian Master Kategori Aset Kantor
    |--------------------------------------------------------------------------
    */

    Route::get('/master/kategori-aset', [KategoriAsetController::class, 'index'])
        ->name('master.kategori_aset');
    Route::get('/master/kategori-aset/data', [KategoriAsetController::class, 'data'])
        ->name('master.kategori_aset.data');
    Route::post('/master/kategori-aset/simpan', [KategoriAsetController::class, 'simpan'])
        ->name('master.kategori_aset.simpan');
    Route::get('/master/kategori-aset/getDataById/{id}', [KategoriAsetController::class, 'getDataById'])
        ->name('master.kategori_aset.getDataById');
    Route::post('/master/kategori-aset/update', [KategoriAsetController::class, 'update'])
        ->name('master.kategori_aset.update');
    Route::post('/master/kategori-aset/hapus', [KategoriAsetController::class, 'hapus'])
        ->name('master.kategori_aset.hapus');
    Route::get('/master/kategori-aset', [KategoriAsetController::class, 'index'])
        ->name('kategori_aset_hr');



    /*
    |--------------------------------------------------------------------------
    | Route Bagian Kelompok Akun COA
    |--------------------------------------------------------------------------
    */

    Route::get('/finance/kelompok-akun-coa', [KelompokAkunCoaController::class, 'index'])
        ->name('kelompok_akun_coa');
    Route::get('/finance/kelompok-akun-coa/data', [KelompokAkunCoaController::class, 'data'])
        ->name('kelompok_akun_coa.data');
    Route::post('/finance/kelompok-akun-coa/simpan', [KelompokAkunCoaController::class, 'simpan'])
        ->name('kelompok_akun_coa.simpan');
    Route::get('/finance/kelompok-akun-coa/listAkunIndukCoa', [KelompokAkunCoaController::class, 'listAkunIndukCoa'])
        ->name('kelompok_akun_coa.listAkunIndukCoa');
    Route::post('/finance/kelompok-akun-coa/hapus', [KelompokAkunCoaController::class, 'hapus'])
        ->name('kelompok_akun_coa.hapus');

    /*
    |--------------------------------------------------------------------------
    | Route Bagian Manajemen COA
    |--------------------------------------------------------------------------
    */

    Route::get('/finance/coa', [CoaController::class, 'index'])
        ->name('coa');
    Route::get('/finance/coa/data', [CoaController::class, 'data'])
        ->name('coa.data');
    Route::get('/finance/coa/listAkunIndukCoa', [CoaController::class, 'listAkunIndukCoa'])
        ->name('coa.listAkunIndukCoa');
    Route::get('/finance/coa/listKelompokAkun', [CoaController::class, 'listKelompokAkun'])
        ->name('coa.listKelompokAkun');
    Route::post('/finance/coa/simpan', [CoaController::class, 'simpan'])
        ->name('coa.simpan');
    Route::post('/finance/coa/update', [CoaController::class, 'update'])
        ->name('coa.update');
    Route::get('/finance/coa/getDayaById/{id}', [CoaController::class, 'getDataById'])
        ->name('coa.getDataById');
    Route::post('/finance/coa/hapus', [CoaController::class, 'hapus'])
        ->name('coa.hapus');


    /*
    |--------------------------------------------------------------------------
    | Route Bagian Kategori Anggaran
    |--------------------------------------------------------------------------
    */

    Route::get('/finance/kategori-anggaran', [KategoriAnggaranController::class, 'index'])
        ->name('finance.kategori_anggaran');
    Route::get('/finance/kategori-anggaran/data', [KategoriAnggaranController::class, 'data'])
        ->name('finance.kategori_anggaran.data');
    Route::post('/finance/kategori-anggaran/simpan', [KategoriAnggaranController::class, 'simpan'])
        ->name('finance.kategori_anggaran.simpan');
    Route::post('/finance/kategori-anggaran/hapus', [KategoriAnggaranController::class, 'hapus'])
        ->name('finance.kategori_anggaran.hapus');


    /*
    |--------------------------------------------------------------------------
    | Route Bagian Sub Kategori Anggaran
    |--------------------------------------------------------------------------
    */

    Route::get('/finance/sub-kategori-anggaran', [SubKategoriAnggaranController::class, 'index'])
        ->name('finance.sub_kategori_anggaran');
    Route::get('/finance/sub-kategori-anggaran/data', [SubKategoriAnggaranController::class, 'data'])
        ->name('finance.sub_kategori_anggaran.data');
    Route::get('/finance/sub-kategori-anggaran/getDataById/{id}', [SubKategoriAnggaranController::class, 'getDataById'])
        ->name('finance.sub_kategori_anggaran.getDataById');
    Route::get('/finance/sub-kategori-anggaran/listCoa', [SubKategoriAnggaranController::class, 'listCoa'])
        ->name('finance.sub_kategori_anggaran.listCoa');
    Route::get('/finance/sub-kategori-anggaran/listKategoriAnggaran', [SubKategoriAnggaranController::class, 'listKategoriAnggaran'])
        ->name('finance.sub_kategori_anggaran.listKategoriAnggaran');
    Route::post('/finance/sub-kategori-anggaran/simpan', [SubKategoriAnggaranController::class, 'simpan'])
        ->name('finance.sub_kategori_anggaran.simpan');
    Route::post('/finance/sub-kategori-anggaran/update', [SubKategoriAnggaranController::class, 'update'])
        ->name('finance.sub_kategori_anggaran.update');
    Route::post('/finance/sub-kategori-anggaran/hapus', [SubKategoriAnggaranController::class, 'hapus'])
        ->name('finance.sub_kategori_anggaran.hapus');


    /*
    |--------------------------------------------------------------------------
    | Route Bagian Master Periode Anggaran
    |--------------------------------------------------------------------------
    */
    Route::get('/finance/master-periode-anggaran', [MasterPeriodeAnggaranController::class, 'index'])
        ->name('finance.master_periode_anggaran');
    Route::get('/finance/master-periode-anggaran/data', [MasterPeriodeAnggaranController::class, 'data'])
        ->name('finance.master_periode_anggaran.data');
    Route::post('/finance/master-periode-anggaran/simpan', [MasterPeriodeAnggaranController::class, 'simpan'])
        ->name('finance.master_periode_anggaran.simpan');

    /*
    |--------------------------------------------------------------------------
    | Route Bagian Master Bank
    |--------------------------------------------------------------------------
    */
    Route::get('/finance/master-bank', [MasterBankController::class, 'index'])
        ->name('finance.master-bank');
    Route::get('/finance/master-bank/data', [MasterBankController::class, 'data'])
        ->name('finance.master-bank.data');
    Route::post('/finance/master-bank/simpan', [MasterBankController::class, 'simpan'])
        ->name('finance.master-bank.simpan');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
