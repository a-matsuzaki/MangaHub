<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MangahubController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes（ウェブルート）
|--------------------------------------------------------------------------
|
| アプリケーションのウェブルートをここで登録します。これらのルートは
| RouteServiceProviderによって読み込まれ、すべてのルートは
| "web"ミドルウェアグループに割り当てられます。素晴らしいものを作成しましょう！
|
*/

// 'mangahub'というURLプレフィックスの下でのルートをグループ化
// このグループの全てのルートは、ユーザーがログインしていることを要求（authミドルウェア）
Route::middleware('auth')->prefix('mangahub')->group(function () {
    // '/mangahub'のURLで、MangahubControllerのindexメソッドを呼び出し
    Route::get('/', [MangahubController::class, 'index'])->name('mangahub');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証関連のルートの読み込み
require __DIR__.'/auth.php';
