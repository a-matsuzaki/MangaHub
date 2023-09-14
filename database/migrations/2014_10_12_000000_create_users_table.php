<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行します。
     */
    public function up(): void
    {
        // 'users' テーブルを作成
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // 主キー
            $table->string('name');  // 名前
            $table->string('email')->unique();  // メールアドレス（一意）
            $table->timestamp('email_verified_at')->nullable();  // メールの確認日時（null可）
            $table->string('password');  // パスワード
            $table->rememberToken();  // "記憶する"トークン（自動ログイン機能用）
            $table->timestamps();  // 作成日時・更新日時
        });
    }

    /**
     * マイグレーションを元に戻します。
     */
    public function down(): void
    {
        // 'users' テーブルを削除
        Schema::dropIfExists('users');
    }
};
