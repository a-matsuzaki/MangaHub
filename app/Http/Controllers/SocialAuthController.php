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
        // ソーシャル認証プロバイダからユーザー情報を取得
        $user = Socialite::driver($provider)->user();

        // TODO: 取得したユーザー情報を使用して、データベースにユーザーを登録/ログインするロジックを実装

        // ログイン後の適切なページへリダイレクト
        return redirect('/home');
    }
}
