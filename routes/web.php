<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommitController;
use App\Http\Controllers\DownloadCommitAudioController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RepositoriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StarController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function(){
    // dd(\Auth::user()->hasVerifiedEmail());
    return view('test');
});

Route::get('/', function () {
    return redirect()->to(route('repositories.index',['order' => 'default']));
});

// Auth::routes();
// Auth::routes(['verify' => true]);
// 用户身份验证相关的路由
// App\Http\Controllers\Auth
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('logout', [LoginController::class,'logout'])->name('logout');

// 用户注册相关路由
Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class,'register']);

// 密码重置相关路由
Route::get('password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');

// 再次确认密码（重要操作前提示）
Route::get('password/confirm', [ConfirmPasswordController::class,'showConfirmForm'])->name('password.confirm');
Route::post('password/confirm', [ConfirmPasswordController::class,'confirm']);

// Email 认证相关路由
Route::get('email/verify', [VerificationController::class,'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class,'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class,'resend'])->name('verification.resend');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UsersController::class, ['only' => ['show', 'update', 'edit']]);

Route::resource('repositories', RepositoriesController::class, ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::get('repositories/{repository}/{slug?}',[ RepositoriesController::class,'show'])->name('repositories.show');

Route::get('repository_setting/{repository}/{slug?}',[RepositoriesController::class, 'showSetting'])->name('repository_setting.show');

Route::get('repository_comments/{repository}/{slug?}',[RepositoriesController::class, 'showComments'])->name('repository_comments.show');

Route::get('show_audio/{repository}/{slug?}/',[RepositoriesController::class, 'showAudio'])->name('repository_audio.show');

Route::get('edit_audio/{repository}/{slug?}',[RepositoriesController::class, 'editAudio'])->name('repository_audio.edit');

Route::get('edit_description/{repository}/{slug?}', [RepositoriesController::class,'editDescription'])->name('repositories.edit_description');

Route::put('repositories/{repository}/update_descritpion', [RepositoriesController::class,'updateDescription'])->name('repositories.update_description');

Route::put('repositories/{repository}/update_name', [RepositoriesController::class,'updateName'])->name('repositories.update_name');

Route::delete('repositories/{repository}',[RepositoriesController::class, 'destroy'])->name('repositories.destroy');

Route::get('init/{repository}/{slug?}',[RepositoriesController::class, 'init'])->name('repositories.init');

// Route::get()

Route::post('upload_image', [RepositoriesController::class,'uploadImage'])->name('repositories.upload_image');

Route::post('upload_audio', [RepositoriesController::class,'uploadAudio'])->name('repositories.upload_audio');


Route::post('comments', [CommentController::class, 'store'])->name('comments.store');

Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::resource('notifications', NotificationsController::class, ['only' => ['index']]);

Route::post('repositories/{repository}/commits', [CommitController::class, 'store'])->name('commits.store');

Route::get('commits/{commit}/download-all-audio', [DownloadCommitAudioController::class, 'all'])->name('commit-download-all-audio');

Route::get('search', [SearchController::class, 'index'])->name('search');

Route::post('repository-stars/{repository}', [StarController::class, 'store'])->name('repository-stars.store');

Route::delete('repository-stars/{repository}', [StarController::class, 'destroy'])->name('repository-stars.destroy');
