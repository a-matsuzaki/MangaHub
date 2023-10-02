<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

// Laravelの設定値を定義した配列を返すファイルです。
return [

    // -------------------------------------------------------------------------
    // アプリケーションの名前
    // -------------------------------------------------------------------------
    // この値はアプリケーションの名前です。フレームワークが通知や他の場所でアプリケーションの名前を
    // 表示する必要がある場合に使用されます。
    'name' => env('APP_NAME', 'MyMangaHub'),

    // -------------------------------------------------------------------------
    // アプリケーションの環境
    // -------------------------------------------------------------------------
    // この値はアプリケーションが現在実行されている"環境"を決定します。
    'env' => env('APP_ENV', 'production'),

    // -------------------------------------------------------------------------
    // アプリケーションのデバッグモード
    // -------------------------------------------------------------------------
    // アプリケーションがデバッグモードにある場合、詳細なエラーメッセージが表示されます。
    'debug' => (bool) env('APP_DEBUG', false),

    // -------------------------------------------------------------------------
    // アプリケーションのURL
    // -------------------------------------------------------------------------
    // このURLは、Artisanコマンドラインツールを使用してURLを正しく生成するためにコンソールに使用されます。
    'url' => env('APP_URL', 'https://mymangahub-3085a442181b.herokuapp.com/'),

    // アセットのURL
    'asset_url' => env('ASSET_URL'),

    // -------------------------------------------------------------------------
    // アプリケーションのタイムゾーン
    // -------------------------------------------------------------------------
    // アプリケーションのデフォルトのタイムゾーンを指定できます。
    'timezone' => 'Asia/Tokyo',

    // -------------------------------------------------------------------------
    // アプリケーションのロケール設定
    // -------------------------------------------------------------------------
    // アプリケーションのデフォルトのロケールを指定します。
    'locale' => 'ja',

    // -------------------------------------------------------------------------
    // アプリケーションのフォールバックロケール
    // -------------------------------------------------------------------------
    // 現在のロケールが利用できない場合に使用するロケールを指定します。
    'fallback_locale' => 'en',

    // -------------------------------------------------------------------------
    // Fakerのロケール
    // -------------------------------------------------------------------------
    // データベースのシード用の偽のデータを生成する際に使用するロケールを指定します。
    'faker_locale' => 'ja_JP',

    // -------------------------------------------------------------------------
    // 暗号化キー
    // -------------------------------------------------------------------------
    // このキーは暗号化サービスに使用されます。
    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    // -------------------------------------------------------------------------
    // メンテナンスモードのドライバ
    // -------------------------------------------------------------------------
    // メンテナンスモードの状態を決定し、管理するためのドライバを指定します。
    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    // -------------------------------------------------------------------------
    // 自動ロードされるサービスプロバイダ
    // -------------------------------------------------------------------------
    // ここにリストされているサービスプロバイダは、アプリケーションへのリクエスト時に自動的にロードされます。
    'providers' => ServiceProvider::defaultProviders()->merge([
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),

    // -------------------------------------------------------------------------
    // クラスのエイリアス
    // -------------------------------------------------------------------------
    // この配列のクラスエイリアスはアプリケーションが開始されたときに登録されます。
    'aliases' => Facade::defaultAliases()->merge([])->toArray(),

    // SSLを強制するかどうか
    'force_ssl' => env('FORCE_SSL', false)

];
