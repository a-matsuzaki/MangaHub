<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Socialite;

/**
 * SocialAuthController クラス。
 * ソーシャル認証を行うためのコントローラです。
 */
class SocialAuthController extends Controller
{
    /**
     * 指定されたプロバイダ（Googleなど）へユーザーをリダイレクトします。
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
        try {
            // ソーシャルプロバイダからユーザー情報を取得
            $socialUser = Socialite::driver($provider)->user();

            // データベースの変更をトランザクション内で行う
            $user = DB::transaction(function () use ($provider, $socialUser) {
                // メールアドレスまたはソーシャル認証のプロバイダ名・IDでユーザーを検索
                $user = User::where('email', $socialUser->getEmail())
                    ->orWhere(function ($query) use ($provider, $socialUser) {
                        $query->where('provider_name', $provider)
                            ->where('provider_id', $socialUser->getId());
                    })
                    ->first();

                if (!$user) {
                    // ユーザーが存在しない場合は新規作成
                    $user = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'provider_name' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'password' => Hash::make(Str::random(16)), // ソーシャル認証でのパスワードは通常不要。ここではランダムな文字列をセット
                    ]);
                } else {
                    // 既存のユーザーがいる場合は情報を更新
                    $user->update([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'provider_name' => $provider,
                        'provider_id' => $socialUser->getId(),
                    ]);
                }

                return $user;
            });

            // 検索されたまたは新しく作成されたユーザーでログイン
            Auth::login($user);

            // ログイン後のダッシュボードやホームページへリダイレクト
            return redirect('/');
        } catch (\Exception $e) {
            // エラーが発生した場合の処理を書く
            // ここでは単にログを記録し、エラーメッセージと共に前のページへ戻す
            \Log::error("Social auth error: {$e->getMessage()}");
            return redirect()->back()->with('error', 'ソーシャル認証に問題が発生しました。');
        }
    }
}
