<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

/**
 * SocialAuthController クラス。
 * ソーシャル認証を行うためのコントローラです。
 */
class SocialAuthController extends Controller
{
    /**
     * 指定されたプロバイダ（Google、LINEなど）へユーザーをリダイレクトします。
     *
     * @param  string  $provider  使用するソーシャル認証プロバイダの名前。
     * @return \Illuminate\Http\RedirectResponse プロバイダの認証ページへのリダイレクトレスポンス。
     */
    public function redirectToProvider($provider)
    {
        // ソーシャル認証プロバイダの認証ページへリダイレクト
        return Socialite::driver($provider)->redirect();
    }

    /**
     * ソーシャル認証プロバイダからのコールバックを処理します。
     * ユーザー情報を取得し、アプリケーションでのユーザー登録またはログインを行います。
     *
     * @param  string  $provider  使用するソーシャル認証プロバイダの名前。
     * @return \Illuminate\Http\RedirectResponse ログイン後の適切なページへのリダイレクトレスポンス。
     */
    public function handleProviderCallback($provider)
    {
        // ソーシャルプロバイダからユーザー情報を取得
        $socialUser = Socialite::driver($provider)->user();

        // メールアドレスまたはプロバイダIDに基づいてデータベース内でユーザーを検索
        $user = User::where('email', $socialUser->getEmail())
            ->orWhere('provider_id', $socialUser->getId())
            ->first();

        if (!$user) {
            // ユーザーがデータベース内に存在しない場合、新しいユーザーエントリを作成
            $user = User::create([
                'name' => $socialUser->getName(), // ソーシャルプロバイダから取得した名前
                'email' => $socialUser->getEmail(), // ソーシャルプロバイダから取得したメールアドレス
                'provider_name' => $provider, // ソーシャルプロバイダ名
                'provider_id' => $socialUser->getId(),  // ソーシャルプロバイダから取得した一意のID
                'password' => Hash::make(Str::random(16)), // パスワードはソーシャル認証では通常不要。ただし、ここではランダムな文字列をセット
            ]);
        }

        // 検索されたまたは新しく作成されたユーザーでログイン
        Auth::login($user);

        // ログイン後のダッシュボードやホームページへリダイレクト
        return redirect('/');
    }
}
