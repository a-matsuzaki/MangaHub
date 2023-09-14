<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangaSeries extends Model
{
    use HasFactory;

    /**
    * id: シリーズID, autoincrement, 主キー, not null
    * user_id: ユーザーID integer, not null
    * title: タイトル string, not null
    * author: 著者 string, length 255, null許可
    * publication: 出版社 string, length 255, null許可
    * note: text, メモ（備考） length 1000, null許可
    * timestamps(updated_at, created_at)
    *
    */

    /**
     * この漫画シリーズを所有するユーザーを取得。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この漫画シリーズに関連する漫画ボリュームを取得。
     */
    public function mangaVolumes()
    {
        return $this->hasMany(MangaVolume::class);
    }
}
