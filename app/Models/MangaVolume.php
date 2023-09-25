<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 漫画の各ボリュームを表すモデル
 */
class MangaVolume extends Model
{
    // EloquentのFactoryトレイトを使用して、データベースファクトリーをこのモデルに関連付ける
    use HasFactory;

    // モデルの属性の一部のみをデータベースに保存・更新を許可するための配列
    protected $fillable = [
        'user_id',          // ユーザーID
        'type',             // ボリュームのタイプ（例: 通常、特別など）
        'volume',           // ボリューム番号
        'is_owned',         // 所有しているかどうかのフラグ
        'is_read',          // 既読かどうかのフラグ
        'wants_to_buy',     // 購入を希望するかどうかのフラグ
        'wants_to_read',    // 読みたいと思っているかどうかのフラグ
    ];

    /**
     * この漫画ボリュームの所有者として関連付けられているユーザーモデルを取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この漫画ボリュームが属している漫画シリーズモデルを取得する
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mangaSeries()
    {
        return $this->belongsTo(MangaSeries::class, 'series_id');
    }
}
