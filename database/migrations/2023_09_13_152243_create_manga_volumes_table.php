<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行する。
     */
    public function up(): void
    {
        // 'manga_volumes' テーブルを作成
        Schema::create('manga_volumes', function (Blueprint $table) {
            // 主キー（id）
            $table->id();

            // 'manga_series' テーブルへの外部キーとしてのシリーズID
            $table->unsignedBigInteger('series_id');

            // 'users' テーブルへの外部キーとしてのユーザーID
            $table->unsignedBigInteger('user_id');

            // 通常盤かどうかを示すフラグ
            $table->boolean('type')->comment('通常盤かどうか');

            // 巻数
            $table->integer('volume')->comment('巻数');

            // 所有しているかどうかを示すフラグ
            $table->boolean('is_owned')->comment('所有ステータス');

            // 既読かどうかを示すフラグ
            $table->boolean('is_read')->comment('読書ステータス');

            // 購入する意向があるかどうかを示すフラグ
            $table->boolean('wants_to_buy')->comment('購入意向');

            // 読む意向があるかどうかを示すフラグ
            $table->boolean('wants_to_read')->comment('読書意向');

            // メモや備考欄（null可）
            $table->text('note')->nullable()->comment('メモ（備考）');

            // 作成日時・更新日時
            $table->timestamps();

            // series_idカラムとmanga_seriesテーブルのidカラムとの外部キー制約
            // manga_seriesテーブルの該当レコードが削除された場合、このテーブルの関連レコードも連動して削除される
            $table->foreign('series_id')->references('id')->on('manga_series')->onDelete('cascade');

            // user_idカラムとusersテーブルのidカラムとの外部キー制約
            // usersテーブルの該当レコードが削除された場合、このテーブルの関連レコードも連動して削除される
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * マイグレーションの変更を元に戻す。
     */
    public function down(): void
    {
        // 'manga_volumes' テーブルを削除
        Schema::dropIfExists('manga_volumes');
    }
};
