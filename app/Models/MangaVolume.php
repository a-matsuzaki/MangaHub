<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangaVolume extends Model
{
    use HasFactory;

    /**
    * id: 巻数ID, autoincrement, 主キー, not null
    * series_id: シリーズID integer, not null
    * user_id: ユーザーID integer, not null
    * type: 通常盤かどうか, boolean, not null
    * volume: 巻数 integer, not null
    * is_owned: 所有ステータス boolean, not null
    * is_read: 読書ステータス boolean, not null
    * wants_to_buy: 購入意向 boolean, not null
    * wants_to_read: 読書意向 boolean, not null
    * note: string, メモ（備考） length 1000, null許可
    * timestamps(updated_at, created_at)
    *
    */

    /**
     * この漫画ボリュームを所有するユーザーを取得。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この漫画ボリュームが属する漫画シリーズを取得。
     */
    public function mangaSeries()
    {
        return $this->belongsTo(MangaSeries::class, 'series_id');
    }
}
