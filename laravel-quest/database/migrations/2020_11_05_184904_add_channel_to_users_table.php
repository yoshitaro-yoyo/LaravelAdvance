<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChannelToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('channel')->default('マイチャンネル');
            //$table->string('channel')で、「channel」というカラムを追加しておりdefault('マイチャンネル')という記述で、channelカラムの初期値を「マイチャンネル」に設定。
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('channel');
            //$table->dropColumn('channel');で、カラム削除のコマンド
        });
    }
}
