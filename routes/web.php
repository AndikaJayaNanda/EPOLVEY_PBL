<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaSurveyController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\SurveyAnalysisController;
use App\Http\Controllers\SurveyController;
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
    return view('welcome');
});

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['auth','role:Admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/create-survey', [AdminController::class, 'create_survey'])
        ->name('admin.create_survey');

    Route::get('/result-survey', [AdminController::class, 'result_survey'])
        ->name('admin.result_survey');

    Route::get('/manage-accounts', [AdminController::class, 'manage_accounts'])
        ->name('admin.manage_accounts');

    //analys
    Route::get('/surveys/analysis', [SurveyAnalysisController::class, 'index'])
            ->name('admin.analys_survey');

    
    Route::get('/add_survey', [SurveyController::class, 'create'])
        ->name('admin.add_survey');

    Route::post('/store_survey', [SurveyController::class, 'store'])
        ->name('admin.store_survey');

    Route::post('/surveys/store', [SurveyController::class, 'store'])
        ->name('admin.store_survey');

    Route::get('/surveys/{survey}/edit', [SurveyController::class, 'edit'])
        ->name('admin.edit_survey');
    Route::put('/surveys/{survey}', [SurveyController::class, 'update'])
        ->name('admin.update_survey');

    Route::delete('/surveys/{survey}', [SurveyController::class, 'destroy'])
        ->name('admin.delete_survey');

    Route::get('/surveys/{survey}/pertanyaan', [PertanyaanController::class, 'create'])
        ->name('admin.pertanyaan');
    Route::post('/surveys/{survey}/pertanyaan', [PertanyaanController::class, 'store'])
        ->name('admin.store_pertanyaan');

    Route::get('/pertanyaan/{id}/edit', [PertanyaanController::class, 'editPertanyaan'])
        ->name('admin.edit_pertanyaan');

    Route::put('/pertanyaan/{id}', [PertanyaanController::class, 'updatePertanyaan'])
        ->name('admin.update_pertanyaan');

    Route::delete('/pertanyaan/{id}', [PertanyaanController::class, 'deletePertanyaan'])
        ->name('admin.delete_pertanyaan');

    Route::get('/result_survey', [AdminController::class, 'result_survey'])
        ->name('admin.result_survey');

    //Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])
        ->name('admin.jadwal');
    Route::get('/jadwal/create', [JadwalController::class, 'create'])
        ->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])
        ->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit']) 
        ->name('jadwal.edit');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])
        ->name('jadwal.update');


    Route::get('/profil', [AdminController::class, 'profil'])
        ->name('admin.profil');

    //Account
    Route::get('/accounts/create', [AccountController::class, 'create'])
        ->name('admin.account_create');
    Route::post('/accounts/store', [AccountController::class, 'store'])
        ->name('admin.account_store');
    Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])
        ->name('admin.account_edit');
    Route::put('/accounts/{id}', [AccountController::class, 'update'])
        ->name('admin.account_update');
    Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])
        ->name('admin.account_delete');    

});


Route::prefix('dosen')->middleware(['auth','role:Dosen'])->group(function () {
    Route::get('/dashboard', [DosenController::class, 'index'])
        ->name('dosen.dashboard');

    Route::get('/result', [DosenController::class, 'result'])
        ->name('dosen.result');

    Route::get('/result/detail', [DosenController::class, 'detail_result'])
        ->name('dosen.detail_result');

    Route::get('/profil', [DosenController::class, 'profil'])
        ->name('dosen.profil');
});

Route::prefix('mahasiswa')->middleware(['auth','role:Mahasiswa'])->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'index'])
        ->name('mahasiswa.dashboard');

    Route::get('/survey', [MahasiswaController::class, 'survey'])
        ->name('mahasiswa.survey');
    Route::get('/survey/{id}', [MahasiswaSurveyController::class, 'show'])
        ->name('mahasiswa.survey_detail');
    Route::get('/survey/{surveyId}/question/{questionIndex}', [MahasiswaSurveyController::class, 'showQuestion'])
        ->name('mahasiswa.survey.answer');
    Route::post('/survey/{id}/submit', [MahasiswaSurveyController::class, 'submitSurvey'])
        ->name('mahasiswa.survey.submit');

    // Route untuk melihat semua jawaban survei
    Route::get('/surveys/{surveyId}/answer/{questionIndex}', [MahasiswaSurveyController::class, 'answer'])
    ->name('mahasiswa.survey.start');


    //profil
    Route::get('/profil/{id}', [MahasiswaController::class, 'profil'])
        ->name('mahasiswa.profil');
    Route::get('/profil/{id}/edit', [MahasiswaController::class, 'edit'])
        ->name('mahasiswa.profil_edit');
    Route::put('/profil/{id}', [MahasiswaController::class, 'update'])
        ->name('mahasiswa.update_profil');
        
});