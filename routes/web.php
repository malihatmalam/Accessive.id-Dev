<?php


use RealRashid\SweetAlert\Facades\Alert;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/coba', function () {
    return view('admin.dashboard');
});


// Route::get('/viewlogincoba', function () {
//     return view('auth.login');
// });

/* ======== LOGIN & REGISTER ======== */
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/', function () {
    return view('auth.login');
})->name('login');
//Route::resource('user_datas', 'UserDatasController');


/* ======== DASHBOARD ======== */
Route::resource('main', 'DashboardController');
// Route::get('/monthly-income/{date?}', 'DashboardController@getMonthly')->name('income_statement');
// Route::get('/get_monthly_cash_flow/{year?}', 'DashboardController@get_monthly_cash_flow')->name('cash_flow');
// Route::get('/get_daily_cash_flow/{date?}', 'DashboardController@get_daily_cash_flow')->name('cash_flow_daily');


/* ======== GANTI PASSWORD ======== */
Route::resource('ganti_password', 'Auth\ChangePasswordController');

/* ======== MANAGEMENT PENGGUNA ======== */
Route::resource('user_management', 'UserManagementController');
Route::get('getDataUserManagement', [
    'uses' => 'UserManagementController@indexData',
    'as' => 'ajax.get.data.user.management.index'
]);
Route::get('detailUserManagement', 'UserManagementController@detailUserManagement');

/* ======== PLACE ======== */
Route::resource('place', 'PlaceController');
Route::get('getDataPlaceIndex', [
    'uses' => 'PlaceController@indexData',
    'as' => 'ajax.get.data.place.index'
]);
Route::get('place/facility/{id}', 'PlaceController@facility_edit')->name('place.edit.facility');
Route::get('place/guide/create/{id}', 'PlaceController@guide_create')->name('place.create.guide'); // id -> Place_id
Route::post('place/guide/store/{id}', 'PlaceController@guide_store')->name('place.store.guide'); // id -> Place_id
Route::get('place/guide/{guide_id}', 'PlaceController@guide_edit')->name('place.edit.guide'); // id -> Guide_id
Route::post('place/guide/update/{id}', 'PlaceController@guide_update')->name('place.update.guide'); // id -> Guide_id
Route::post('place/guide/delete/{id}', 'PlaceController@guide_delete')->name('place.delete.guide'); // id -> Guide_id
Route::post('deleted-guide-photo/{id}', 'PlaceController@guide_photo_deleted')->name('place.delete.photo');

Route::get('place/general/{id}', 'PlaceController@general_edit')->name('place.edit.general');
Route::post('place/general/update/{id}', 'PlaceController@general_update')->name('place.update.general');
Route::get('place/location/{id}', 'PlaceController@location_edit')->name('place.edit.location');
Route::post('place/location/update/{id}', 'PlaceController@location_update')->name('place.update.location');
Route::get('place/facility/{id}', 'PlaceController@facility_edit')->name('place.edit.facility');
Route::post('place/facility/update/{id}', 'PlaceController@facility_update')->name('place.update.facility');
Route::post('add-place-photo/{id}', 'PlaceController@photo_add')->name('place.add.photo');
Route::post('deleted-place-photo/{id}', 'PlaceController@photo_deleted')->name('place.delete.photo');

// Route::get('place/test/{id}', 'PlaceController@test_show')->name('place.edit.guide22');

Route::resource('place/place_photo', 'UserDatasController');
Route::resource('place/recomended_place', 'UserDatasController');

/* ======== CATEGORY & CATEGORY TYPE ======== */
Route::resource('category', 'CategoryController');
Route::get('getDataCategoryIndex', [
    'uses' => 'CategoryController@indexData',
    'as' => 'ajax.get.data.category.index'
]);
Route::get('detailCategory', 'CategoryController@detailCategory');
Route::resource('category/category_type', 'CategoryTypeController')->except('edit');;
Route::get('getDataCategoryTypesIndex', [
    'uses' => 'CategoryTypeController@indexData',
    'as' => 'ajax.get.data.category.type.index'
]);
Route::get('detailCategoryType', 'CategoryTypeController@detailCategoryType');
Route::get('testCategoryType/{id}', 'CategoryTypeController@test');


/* ======== FACILITY ======== */
Route::resource('facility_type', 'FacilityTypeController');
Route::get('getDataFacilityTypesIndex', [
    'uses' => 'FacilityTypeController@indexData',
    'as' => 'ajax.get.data.facility.type.index'
]);
Route::get('detailFacilityType', 'FacilityTypeController@detailFacilityType');

// Route::resource('facility/facility_type', 'UserDatasController');
// Route::resource('facility/facility_preference', 'UserDatasController');


/* ======== GUIDE ======== */
Route::resource('guide_type', 'GuideTypeController');
Route::get('getDataGuideTypesIndex', [
    'uses' => 'GuideTypeController@indexData',
    'as' => 'ajax.get.data.guide.type.index'
]);
Route::get('detailGuideType', 'GuideTypeController@detailGuideType');

// Route::resource('guide', 'UserDatasController');
// Route::resource('guide/guide_type', 'UserDatasController');
// Route::resource('guide/guide_photo', 'UserDatasController');




/* ======== REVIEW & COLLECTION ======== */



/* ======== SUPER ADMIN AUTHORITY ======== */
Route::prefix('super_admin')->middleware('auth')->name('superadmin.')->group(function(){
    Route::resource('/', 'AdminDashboardController');
    Route::get('user/user_register', 'AdminDashboardController@user_register')->name('user_register');
    Route::resource('user', 'UserMgtController');
    Route::post('user/set_status/{$id}', 'UserMgtController@changeStatus')->name('setStatus');
    Route::resource('/manajemen_admin', 'AdminMgtController');
});




/* ======== DASHBOARD ======== */
Route::resource('main', 'DashboardController');
Route::get('/monthly-income/{date?}', 'DashboardController@getMonthly')->name('income_statement');
Route::get('/get_monthly_cash_flow/{year?}', 'DashboardController@get_monthly_cash_flow')->name('cash_flow');
Route::get('/get_daily_cash_flow/{date?}', 'DashboardController@get_daily_cash_flow')->name('cash_flow_daily');

/* ======== ACCOUNT ======== */
Route::resource('/akun', 'AccountController');
Route::get('detailAccount', 'AccountController@detailAccount');

/* ======== CLASSIFICATION ======== */
Route::resource('classification', 'ClassificationController');
Route::get('detailClassification', 'ClassificationController@detailClassification');
Route::get('findClassification', 'ClassificationController@findClassification');

/* ======== INITIAL BALANCE ======== */
Route::resource('neraca_awal', 'InitialBalanceController');
Route::get('detail_balance', 'InitialBalanceController@detailBalance');

/* ======== TRIAL BALANCE ======== */
Route::resource('neraca_saldo', 'TrialBalanceController');
Route::get('export/neraca_saldo/{year}/{month?}', 'TrialBalanceController@export')->name('export.neraca_saldo');

/* ======== GENERAL JOURNAL ======== */
Route::resource('jurnal_umum', 'GeneralJournalController')->except('update');
Route::put('jurnal_umum/update', 'GeneralJournalController@update')->name('jurnal.update');
Route::delete('jurnal_umum/{id}/hapus', 'GeneralJournalController@destroyJournal');
Route::get('detailJournal', 'GeneralJournalController@detailJournal');
Route::get('test', 'GeneralJournalController@test');

/* ======== GENERAL LEDGER ======== */
Route::resource('buku_besar', 'GeneralLedgerController');

/* ======== REPORT ======== */
Route::get('laporan_laba_rugi', 'FinancialReportController@incomeStatement')->name('laporan_laba_rugi');
Route::get('export/laporan_laba_rugi/{year}/{month?}', 'FinancialReportController@incomeStatementExport')->name('export.laba_rugi');
Route::get('perubahan_ekuitas', 'FinancialReportController@changeInEquity')->name('perubahan_ekuitas');
Route::get('export/perubahan_ekuitas/{year}/{month?}', 'FinancialReportController@changeInEquityExport')->name('export.perubahan_ekuitas');
Route::get('neraca', 'FinancialReportController@balanceSheet')->name('neraca');
Route::get('export/neraca/{year}/{month?}', 'FinancialReportController@balanceSheetExport')->name('export.neraca');

/* ======== REPORT ======== */
Route::get('export_excel/laporan_laba_rugi/{year}/{month?}', 'FinancialReportController@incomeStatementExportExcel')->name('export.excel.laba_rugi');

/* ======== EMPLOYEE ======== */
Route::resource('karyawan','EmployeeController');
Route::get('detailEmployee', 'EmployeeController@detailEmployee');

/* ======== BISNIS ======== */
Route::resource('bisnis', 'BusinessController');
Route::get('detail_bisnis', 'BusinessController@detailBusiness');
Route::get('set_business/{id}', 'BusinessController@setBusiness')->name('setBusiness');

/* ======== PROFILE ======== */
Route::resource('profile', 'ProfileController')->except('update');
Route::put('profile/update', 'ProfileController@update')->name('profile.update');
Route::put('profile/karyawan/update', 'ProfileController@updateEmployee')->name('profile_karyawan.update');
Route::get('isPro', 'ProfileController@isPro');
Route::get('upgrade', 'ProfileController@upgrade')->name('upgrade');

/* ======== AKUN ANGGARAN ======== */
Route::resource('akun_anggaran', 'BudgetAccountController');
Route::get('detail_akun_anggaran', 'BudgetAccountController@detail')->name('akun.anggaran.detail');
Route::resource('rencana_anggaran', 'BudgetPlan_RealizationController');
Route::get('detail_anggaran', 'BudgetPlan_RealizationController@detail');
Route::get('detail_realisasi', 'BudgetPlan_RealizationController@detail_realization');
Route::get('realisasi_anggaran', 'BudgetPlan_RealizationController@realization')->name('realisasi.show');
Route::get('realisasi_anggaran/tambah/{year}/{month}', 'BudgetPlan_RealizationController@create_realization')->name('realisasi.create');
Route::post('realisasi_anggaran', 'BudgetPlan_RealizationController@store_realization')->name('realisasi.store');
Route::put('realisasi_anggaran/update', 'BudgetPlan_RealizationController@update_realization')->name('realisasi.update');
Route::delete('realisasi_anggaran/{id}', 'BudgetPlan_RealizationController@destroy_realization')->name('realisasi.delete');

Route::prefix('admin')->middleware('auth')->name('superadmin.')->group(function(){
    Route::resource('/', 'AdminDashboardController');
    Route::get('user/user_register', 'AdminDashboardController@user_register')->name('user_register');
    Route::resource('user', 'UserMgtController');
    Route::post('user/set_status/{$id}', 'UserMgtController@changeStatus')->name('setStatus');
    Route::resource('/manajemen_admin', 'AdminMgtController');
});

/* ======== GANTI PASSWORD ======== */
Route::resource('ganti_password', 'Auth\ChangePasswordController');

// Route::get('/', function () {
//     return view('auth.login');
    
// });


Route::get('/resetpassword', function () {
    $data = User::findOrFail(3);
    $data->email = 'perusahaan@gmail.com';
    $data->password = '$2y$10$zHOznHusSs4YYY.YFR7jbOuVw0MMcMiuqsEQh2jgNwS3nuUfvDyFC';
    $data->save();

    $data = User::findOrFail(1);
    $data->email = 'superadmin@bumdes.com';
    $data->password = '$2y$10$zHOznHusSs4YYY.YFR7jbOuVw0MMcMiuqsEQh2jgNwS3nuUfvDyFC';
    $data->save();
    
    $data = User::findOrFail(2);
    $data->email = 'admin@bumdes.com';
    $data->password = '$2y$10$zHOznHusSs4YYY.YFR7jbOuVw0MMcMiuqsEQh2jgNwS3nuUfvDyFC';
    $data->save();

    $data = User::findOrFail(4);
    $data->email = 'karyawan@gmail.com';
    $data->password = '$2y$10$zHOznHusSs4YYY.YFR7jbOuVw0MMcMiuqsEQh2jgNwS3nuUfvDyFC';
    $data->save();

    return 'password changed succesfully';
    
});

Auth::routes();
