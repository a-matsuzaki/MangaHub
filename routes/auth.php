<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// ゲストユーザー（ログインしていないユーザー）のためのルートをグループ化
Route::middleware('guest')->group(function () {
    // ユーザー登録ページを表示するためのGETリクエストのルートを定義
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // ユーザー登録を処理するためのPOSTリクエストのルートを定義
    Route::post('register', [RegisteredUserController::class, 'store']);

    // ログインページを表示するためのGETリクエストのルートを定義
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // ログイン処理をするためのPOSTリクエストのルートを定義
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // パスワードを忘れた場合のページを表示するためのGETリクエストのルートを定義
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // パスワードリセットリンクをメールで送信するためのPOSTリクエストのルートを定義
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // パスワードリセットフォームを表示するためのGETリクエストのルートを定義
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // 新しいパスワードを設定するためのPOSTリクエストのルートを定義
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    // ソーシャルプロバイダへのリダイレクトを処理するルート
    Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider'])
        ->name('social.redirect');

    // ソーシャルプロバイダからのコールバックを処理するルート
    Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])
        ->name('social.callback');
});

// 認証済みのユーザー専用のルートをグループ化
Route::middleware('auth')->group(function () {
    // メールアドレスの確認を促すページを表示するためのGETリクエストのルートを定義
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // メールで送られた認証リンクを検証するためのGETリクエストのルートを定義
    // 署名付きURLとリクエストの数を制限するミドルウェアが適用されます。
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // メールアドレス確認通知を再送するためのPOSTリクエストのルートを定義
    // このルートもリクエスト数を制限するミドルウェアが適用されます。
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // パスワード確認フォームを表示するためのGETリクエストのルートを定義
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // パスワード確認処理をするためのPOSTリクエストのルートを定義
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // パスワード変更処理をするためのPUTリクエストのルートを定義
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // ログアウト処理をするためのPOSTリクエストのルートを定義
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
