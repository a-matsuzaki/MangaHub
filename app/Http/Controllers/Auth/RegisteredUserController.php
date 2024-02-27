<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * ユーザー登録処理を担当するコントローラー
 */
class RegisteredUserController extends Controller
{
    /**
     * ユーザー登録ビューを表示する。
     *
     * @return View ユーザー登録ビュー
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * 新規登録リクエストを処理する。
     *
     * @param Request $request ユーザーからの登録リクエスト
     * @return RedirectResponse 登録後のリダイレクトレスポンス
     * @throws \Illuminate\Validation\ValidationException バリデーションエラーが発生した場合にスロー
     */
    public function store(Request $request): RedirectResponse
    {
        // 入力値のバリデーションを実行
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // 名前は必須、文字列、最大255文字
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class], // メールアドレスは必須、ユニーク
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // パスワードは必須、確認入力と一致、デフォルトルールを適用
        ]);

        // ユーザーモデルをデータベースに保存
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // パスワードはハッシュ化して保存
        ]);

        // 登録イベントを発行
        event(new Registered($user));

        // 新規登録したユーザーで自動ログイン
        Auth::login($user);

        // 登録後、ホームページにリダイレクト
        return redirect(RouteServiceProvider::HOME);
    }
}
