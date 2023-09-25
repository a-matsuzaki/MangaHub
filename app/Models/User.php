<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Userモデル
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
    // APIトークンによる認証の機能を提供
    use HasApiTokens;

    // Eloquentのファクトリートレイトを使用
    use HasFactory;

    // 通知機能のトレイトを使用
    use Notifiable;

    /**
     * モデルが代入を許可する属性のリスト。
     * Eloquentのマスアサインメントの対策として指定。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * JSONとしてシリアル化する際や配列に変換する際に隠される属性のリスト。
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // セキュリティ上、公開されるべきでないため
        'remember_token', // セッションの永続化に使用されるが、公開されるべきでない
    ];

    /**
     * 特定の属性の値を自動的に型変換するための設定。
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // メール確認の日時をdatetime型にキャスト
        'password' => 'hashed',
    ];

    /**
     * ユーザーが所有する漫画シリーズを取得するリレーション。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mangaSeries()
    {
        return $this->hasMany(MangaSeries::class);
    }

    /**
     * ユーザーが所有する漫画ボリュームを取得するリレーション。
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mangaVolumes()
    {
        return $this->hasMany(MangaVolume::class);
    }
}
