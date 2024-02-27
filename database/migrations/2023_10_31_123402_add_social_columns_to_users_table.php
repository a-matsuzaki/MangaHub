<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションを実行する
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_name')->nullable()->after('password'); // プロバイダ名 (e.g., 'google', 'line')
            $table->string('provider_id')->nullable()->unique()->after('provider_name'); // プロバイダから提供される一意のID
        });
    }

    /**
     * マイグレーションの変更を元に戻す
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('provider_name');
            $table->dropColumn('provider_id');
        });
    }
};
