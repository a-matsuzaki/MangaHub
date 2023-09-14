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
        // 'manga_series' テーブルを作成
        Schema::create('manga_series', function (Blueprint $table) {
            // 主キー（id）
            $table->id();

            // ユーザーID（usersテーブルとの外部キー制約を持つ）
            $table->unsignedBigInteger('user_id');

            // タイトル
            $table->string('title')->comment('タイトル');

            // 著者（null可）
            $table->string('author')->nullable()->comment('著者');

            // 出版社（null可）
            $table->string('publication')->nullable()->comment('出版社');

            // ノートやメモ（null可）
            $table->text('note')->nullable()->comment('メモ（備考）');

            // 作成日時・更新日時
            $table->timestamps();

            // user_idとusersテーブルのidカラムとの外部キー制約
            // usersテーブルの該当レコードが削除された場合、このテーブルの該当レコードも連動して削除される
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * マイグレーションの変更を元に戻す。
     */
    public function down(): void
    {
        // 'manga_series' テーブルを削除
        Schema::dropIfExists('manga_series');
    }
};
