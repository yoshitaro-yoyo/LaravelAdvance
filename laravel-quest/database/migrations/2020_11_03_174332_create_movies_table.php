{{-- このファイルは Aphp artisan make:migration マイグレーションファイル名(create_movie_table) --create=テーブル名(movie)で作成された --}}
{{-- マイグレーションファイルをデータベースに反映させるためには、artisanコマンドを使用。$ php artisan migrate --}}
{{-- マイグレーションファイルをGITで管理すれば、誰がどのカラムを追加したか詳細にわかる --}}
{{-- DBにテーブル作成したら次は$ php artisan make:model Movie でモデルを作成する --}}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{//Laravelのマイグレーション実現flow
 //①マイグレ��ションファイルの作成ーup/downメソッド持つクラスとして記述されるプログラムコード テーブル定義に対する変更内容が書かれるファイルの雛形。
 // マイグレーション実行時にはupメソッドが実行されるのでその前にupメソッドを編集。Schema::create() でテーブルを作成。第一引数がテーブル名、第二引数の無名関数がカラム定義。
 //②マイグレーションコマンドの実行 DBに反映される
 //③-1 DBにテーブルが作成される。またDBに対して DDL が発行される。・データ操作言語（DML）：データをあれこれ・データ定義言語（DDL）：箱をあれこれ・データ制御言語（DCL）：権限をあれこれ
 //③−2 マイグレーションテーブル作成 一度実行された実行済みとしてマイグレーションファイルに格納される。再度実行しても何も起きない。
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');                           //id：各動画に付ける連番
            $table->integer('user_id')->unsigned()->index();    //user_id：動画を登録したユーザのＩ���   unsigned() は、マイナスの値は保存できないようにする制限。
                                                                //index() は、検索速度を早めることができる関数。index() が付けられたカラムのみを抽出して素早く対象動画の情報を得る事が可能
                                                                //動画は特にユーザとの関わりが深いため（どのユーザが所有しているかが重要であるので）、user_idにindex()を付ける。('user_id')を優先的に検索する。
            $table->string('url');                              //url： YouTube動画のURL
            $table->string('comment')->nullable();              //comment： 動画に対するコメント （nullableでコメントなしでも投稿できる仕様に）
            $table->timestamps();                               //timestamps：動画登録日時・動画更新日時
            
            //下記コードは「外部キー制約」といわれるコード。
            //このテーブルのカラム('user_id')と、usersテーブルのカラム('id')が一致していて、別テーブルはusersテーブルのことを示す。また、idカラムを持っているレコード（ユーザ自体）
            //が削除された場合は、この動画情報も一緒に削除されるこの外部キー制約によって、テーブル同士の相互性を高める。例えば、１つの動画が存在しないユーザの所有物として登録された場合、
            //動画自体はテーブル上に保存されるが、存在しないユーザに属するということはユーザに所属していない扱いになってしまう。その場合、動画は存在するにも関わらず表示されない可能性等があり、
            //その動画はデータとして不十分なものとなる。つまり、外部キー制約を設けることによって、そのような中途半端なデータを生み出さないように対策を打っている。
            
            //user_id を外部キー制約にかける。制約にかける共通の部分は id カラム。それは users テーブルに有りそのテーブルの
            //id カラムと user id は一致させるように制約をかけている
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
