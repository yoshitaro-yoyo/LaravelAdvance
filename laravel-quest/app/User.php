<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //Userモデル にも１対多の関係を定義する。Movieモデルの user() は単数形で表現していたが、Userインスタンスが所有する
    //Movieは複数あるのでmovies() という複数形を使って関数を作る。
    public function movies()
    {
        return $this->hasMany(Movie::class);
    //「User（this）モデルがMovieモデルを所有している」ということを明示する役割があり、実際のコード記述上でも、下記のようなコードで「Userインスタンスが所有しているMovieを取得」できる.   
    //$user->movies()->get();  $user->movies; userの所有している情報を全て抽出できるようになる。
    }
    
    //登録機能が成立しているか tinker でデータベースの接続を確認してみる
    // tinker : Laravelプロジェクトの「処理→実行→実行結果の表示」まで行ってくれる環境
    //実際のウェブアプリ上で処理を実行しなくてもデータベースにログインして直接操作しなくても簡単に処理を行いその結果の成否を確認出来る。
    //Movieモデルも連想配列形式で「動画情報を登録して保存する」という流れ。
    
    //tinker上で登録機能が出来るようになったらブラウザ上でも出来るように実装していく。まずルーティングの記述。ログイン（新規ユーザー登録）した時のみ
    //動画登録機能が利用できる、Moviesのルーティング。これにより、ログインしているユーザのみがMoviesControllerを使って、動画登録・削除できるようになる。
    //
}
