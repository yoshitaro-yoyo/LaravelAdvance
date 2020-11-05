<?php
    //DBにmovieテーブル作成後に作成されたモデル(MVCにおける「データベース」関連の処理を担当する部分)
    //このアプリケーションでは、主に２種類のモデルを使用。ユーザ(利用者)とモデルムービー(動画)モデル


namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{   //３つのカラム（'user_id','url','comment'）を一度に入力→保存できるようにfillable変数を定義する
    protected $fillable = ['user_id','url','comment']; //配列

    public function user()  //このモデルに１対多の関係を定義するために、user() という関数を定義
    {
        return $this->belongsTo(User::class);
    //MovieモデルがUserモデルに所属していることを明示し、シンプルなコードで「Movieインスタンスが属しているユーザを取得」できる
    //$movie->user()->get();  $movie->user; 続けてUserモデル（User.php）にも１対多の関係を定義する。Movieモデルの user() は単数形
    //で表現していたが、Userインスタンスが所有するMovieは複数あるので、movies() という複数形を使って関数作成。
    }
}