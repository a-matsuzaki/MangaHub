<?php

namespace App\Models;

// Eloquentのファクトリー機能: テストデータの生成やデータベースのシード時に使用
use Illuminate\Database\Eloquent\Factories\HasFactory;
// 認証用の基本的なUserクラス: 認証に必要な基本的なプロパティやメソッドを提供
use Illuminate\Foundation\Auth\User as Authenticatable;
// 通知機能のトレイト: ユーザーへの通知を簡単に送ることができるようにする
use Illuminate\Notifications\Notifiable;
// SanctumのAPIトークン機能のトレイト: APIトークンを用いた認証の機能を提供
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    // APIトークンによる認証
    use HasApiTokens;

    // Eloquentのファクトリー
    use HasFactory;

    // Eloquentの通知
    use Notifiable;

    /**
     * このモデルで代入を許可する属性のリスト。
     * これにより、$user->fill($requestData)のような操作が安全に行えます。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * シリアル化時（例：JSON応答など）に隠蔽される属性。
     * このリストに含まれる属性は公開されません。
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // パスワードはシリアル化時に非表示にする
        'remember_token', // remember_tokenも非表示にする
    ];

    /**
     * 属性のデータ型をキャストするための設定。
     * これにより、特定の属性を特定の型に自動的に変換できます。
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // メールの確認日時を日時型として取得
        'password' => 'hashed',
    ];

    /**
     * Userが所有している漫画シリーズを取得。
     * hasManyリレーションを使用して、対応するMangaSeriesモデルのインスタンスを取得します。
     */
    public function mangaSeries()
    {
        return $this->hasMany(MangaSeries::class);
    }

    /**
     * Userが所有している漫画の巻数を取得。
     * hasManyリレーションを使用して、対応するMangaVolumeモデルのインスタンスを取得します。
     */
    public function mangaVolumes()
    {
        return $this->hasMany(MangaVolume::class);
    }
}
