<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MangahubController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ウェブルートの定義
|--------------------------------------------------------------------------
| アプリケーションのウェブルートはこのファイルで登録されます。
| RouteServiceProviderによって全てのルートが読み込まれます。
| "web"ミドルウェアグループがすべてのルートに自動的に適用されます。
|
*/

// トップページへのアクセス時の表示ビューを指定
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボードページに関するルート定義
// authとverifiedミドルウェアを適用し、認証およびメール確認が完了しているユーザーのみがアクセス可能
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Mangahubに関するルート定義グループ
 * "mangahub"というURLプレフィックスを持つ。
 * authミドルウェアを適用し、認証済みのユーザーのみがアクセス可能。
 */
Route::middleware('auth')->prefix('mangahub')->group(function () {
    // メインのMangahubページ
    Route::get('/', [MangahubController::class, 'index'])->name('mangahub');

    // IDの詳細ページ
    Route::get('/detail/{id}', [MangahubController::class, 'detail'])->name('mangahub.detail');

    // IDのシリーズ編集ページ
    Route::get('/editSeries/{id}', [MangahubController::class, 'editSeries'])->name('mangahub.editSeries');

    // IDのボリューム編集ページ
    Route::get('/editVolume/{id}', [MangahubController::class, 'editVolume'])->name('mangahub.editVolume');

    // 新規作成ページ
    Route::get('/new', [MangahubController::class, 'new'])->name('mangahub.new');

    // シリーズの更新操作
    Route::patch('/updateSeries', [MangahubController::class, 'updateSeries'])->name('mangahub.updateSeries');

    // ボリュームの更新操作
    Route::patch('/updateVolume', [MangahubController::class, 'updateVolume'])->name('mangahub.updateVolume');

    // 新規データの作成操作
    Route::post('/create', [MangahubController::class, 'create'])->name('mangahub.create');

    // IDのデータの削除操作
    Route::delete('/remove/{id}', [MangahubController::class, 'remove'])->name('mangahub.remove');
});

/**
 * プロフィールに関するルート定義グループ
 * authミドルウェアを適用し、認証済みのユーザーのみがアクセス可能。
 */
Route::middleware('auth')->group(function () {
    // プロフィール編集ページ
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // プロフィール情報の更新操作
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // プロフィールの削除操作
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Laravelのデフォルトの認証関連ルート
require __DIR__ . '/auth.php';
