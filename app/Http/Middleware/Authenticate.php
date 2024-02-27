<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * ユーザーが認証されていない場合にリダイレクトされるべきパスを取得します。
     *
     * @param Request $request 現在のリクエストインスタンス
     * @return string|null リダイレクトするパス、またはJSONリクエストの場合はnull
     */
    protected function redirectTo(Request $request): ?string
    {
        // リクエストがJSONを期待している場合は、リダイレクトせずにnullを返す
        // それ以外の場合は、'login'という名前のルート（通常はログインページ）へのリダイレクトを返す
        return $request->expectsJson() ? null : route('login');
    }
}
