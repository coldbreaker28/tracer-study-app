<?php

use App\Events\Notifikasi;
use App\Events\TestEvent;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\components\AcaraController;
use App\Http\Controllers\components\AdminController;
use App\Http\Controllers\components\AlumniController;
use App\Http\Controllers\components\GuruController;
use App\Http\Controllers\components\QuestionnaireController;
use App\Http\Controllers\components\siswaController;
use App\Http\Controllers\components\SuperAdminController;
use App\Models\Siswa;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',                             [siswaController::class, 'index_guest']);

Route::get('/dashboard',         [AuthController::class, 'dashboard'])->name('home');

Route::get('login',                         [AuthController::class, 'index'])->name('login');
Route::post('post-login',                   [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration',                  [AuthController::class, 'registration'])->name('register');
Route::post('post-registration',            [AuthController::class, 'postRegistration'])->name('register.post');
// Route::get('dashboard',                     [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('admin/update/profile/{slug}', [AuthController::class, 'profile'])->name('update.profile');
Route::post('admin/profile/update/{slug}', [AuthController::class, 'update_profile'])->name('admin.update-profile');

Route::get('logout',                        [AuthController::class, 'logout'])->name('logout');

Route::get('forget-password',               [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forgot-password',              [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}',        [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password',               [ForgotPasswordController::class, 'submitResetPassword'])->name('reset.password.post');

// Rute untuk user -> Admin
Route::get('admin/dashboard',               [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('admin/create',                  [AdminController::class, 'create'])->name('admin.create');
Route::post('admin/post-create',            [AdminController::class, 'postCreate'])->name('admin.create.post');
Route::get('admin/detail/{slug}',           [AdminController::class, 'detail'])->name('admin.detail');
Route::get('admin/edit/{slug}',             [AdminController::class, 'edit'])->name('admin.edit');
Route::put('admin/update/{id}',             [AdminController::class, 'editPost'])->name('admin.edit.post');
Route::delete('admin/destroy/{id}',         [AdminController::class, 'destroy'])->name('admin.destroy');

Route::get('admin/laporan',                 [AdminController::class, 'rinci'])->name('admin.laporan');

Route::get('admin/laporan/data_jurusan',                 [AdminController::class, 'dataJurusan'])->name('admin.laporan.jurusan');
Route::get('admin/data_jurusan/add',    [AdminController::class, 'JurusanForm'])->name('admin.jurusan.add');
Route::post('admin/data_jurusan/add/verify',    [AdminController::class, 'jurusanAdd'])->name('admin.jurusan.verify');
Route::get('admin/data_jurusan/{id}',   [AdminController::class, 'jurusanEdit'])->name('admin.jurusan.edit');
Route::put('admin/data_jurusan/{id}',   [AdminController::class, 'jurusanUpdate'])->name('admin.jurusan.update');
Route::delete('admin/destroy/jurusan/{id}',     [AdminController::class, 'jurusanDestroy'])->name('admin.jurusan.destroy');

Route::get('admin/dashboard/user',                  [AdminController::class, 'user'])->name('admin.data-user');
Route::get('admin/dashboard/user/{slug}/{id}',           [AdminController::class, 'userDetail'])->name('admin.data-user.ditel');
Route::post('/admin/data-user/update/{id}',             [AdminController::class, 'updateUser'])->name('admin.data-user.update');
Route::delete('admin/dashboard/user/{id}',           [AdminController::class, 'userDetail'])->name('admin.data-user.destroy');

Route::get('admin/cek-karir',               [AdminController::class, 'cekKarir'])->name('admin.karir');
Route::get('admin/sheet',                   [AdminController::class, 'showPage'])->name('admin.sheet.get');
Route::get('admin/ekspor_to_PDF',           [AdminController::class, 'createPDF'])->name('admin.sheet.pdf');
Route::get('admin/ekspor_to_Excel',         [AdminController::class, 'exportExcel'])->name('admin.sheet.excel');
Route::get('admin/ekspor_to_CSV',           [AdminController::class, 'exportCSV'])->name('admin.sheet.csv');
Route::post('admin/import-csv',              [AdminController::class, 'importCSV'])->name('admin.import.csv');

// Rute untuk Acara Admin dan Super Admin
Route::get('acara/admin/dashboard',                     [AcaraController::class, 'index'])->name('events.admin.dashboard')->middleware('auth');
Route::get('acara/admin/new-event',                     [AcaraController::class, 'create'])->name('events.admin.create')->middleware('auth');
Route::get('acara/admin/edit-event/{id}',               [AcaraController::class, 'editEvent'])->name('events.admin.edit');
Route::get('acara/admin/detail-event/{id}',             [AcaraController::class, 'showEvent'])->name('events.admin.detail');

Route::delete('acara/destroy-event/{id}',                   [AcaraController::class, 'destroy'])->name('events.destroy');
Route::put('acara/update-event/{id}',                       [AcaraController::class, 'update'])->name('events.update');
Route::post('acara/post-event',                             [AcaraController::class, 'store'])->name('events.post')->middleware('auth');
// Rute untuk Alumni atau client 
// Route::get('/',                               [AlumniController::class, 'home'])->name('home');

Route::get('/detail_mading/{id}',                       [siswaController::class, 'detail_mading'])->name('index.detail_mading');


Route::get('/test-push', function () {
    event(new TestEvent('Mas Ansa Ganteng!'));
    return "Event dispatched!";
});
// Route::get('test', function () {
//     event(new TestEvent('Someone'));
//     return "Event has been sent!";
// })->name('send');
Route::get('test', function () {
    event(new \App\Events\Notifikasi('Ini adalah pesan notifikasi test'));
    return back();
})->name('send');

Route::middleware(['auth', 'level:guru'])->group(function () {
    Route::get('guru/{slug}/index',                 [GuruController::class, 'home'])->name('guru.index');
});

Route::get('questionnaires/index', [QuestionnaireController::class, 'index'])->name('questionnaires.index');
Route::middleware(['auth'])->group(function () {
    Route::resource('questionnaires', QuestionnaireController::class);
    Route::get('questionnaires/{questionnaire}/questions/create', [QuestionnaireController::class, 'createQuestion'])->name('questionnaires.createQuestion');
    Route::post('questionnaires/{questionnaire}/questions', [QuestionnaireController::class, 'storeQuestion'])->name('questionnaires.storeQuestion');
    Route::get('questionnaires/{questionnaire}/questions', [QuestionnaireController::class, 'showQuestions'])->name('questionnaires.showQuestions');
    Route::get('questions/{question}/edit', [QuestionnaireController::class, 'editQuestion'])->name('questions.editQuestion');
    Route::put('questions/{question}', [QuestionnaireController::class, 'updateQuestion'])->name('questions.updateQuestion');
    Route::delete('questions/{question}', [QuestionnaireController::class, 'destroyQuestion'])->name('questions.destroyQuestion');
    Route::get('questionnaires/{questionnaire}/answer', [QuestionnaireController::class, 'answer'])->name('questionnaires.answer');
    Route::post('questionnaires/{questionnaire}/submit', [QuestionnaireController::class, 'submitAnswer'])->name('questionnaires.submitAnswer');
    Route::get('questionnaires/{questionnaire}/answers', [QuestionnaireController::class, 'showAnswers'])->name('questionnaires.showAnswers');
});

Route::get('/{slug}/index',                                 [siswaController::class, 'home'])->name('siswa.index')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/{slug}/profile', [siswaController::class, 'editProfile'])->name('siswa.edit-profile');
    Route::post('/profile/update/{slug}',               [siswaController::class, 'updateProfile'])->name('user.update_profile');
    Route::get('/{slug}/update/form_update',                [siswaController::class, 'form_karir'])->name('siswa.form_karir');
    Route::post('/{slug}/update/karir',                     [siswaController::class, 'update_karir'])->name('siswa.update_karir');
    Route::get('/{slug}/event',                             [siswaController::class, 'index_acara'])->name('siswa.event');
    Route::get('/{slug}/event/create',                      [siswaController::class, 'buatMading'])->name('siswa.buat-mading');
    Route::get('/{slug}/event/create/store',                      [siswaController::class, 'store_mading'])->name('siswa.store-mading');
    Route::get('/{slug}/event/{id}/detail',                 [siswaController::class, 'acara_detail'])->name('siswa.event-detail');
    Route::get('/{slug}/event/questionnaires/{questionnaire}/show',         [siswaController::class, 'showQuestionnaires'])->name('siswa.questionnaires-show');
    Route::get('/{slug}/event/questionnaires/{questionnaire}/answer/',         [siswaController::class, 'answerQuestions'])->name('siswa.questionnaires-answer');
    Route::post('/{slug}/event/questionnaires/{questionnaire}/answer/submit',         [siswaController::class, 'submitAnswerSiswa'])->name('siswa.submit-questionnaires-answer');
});