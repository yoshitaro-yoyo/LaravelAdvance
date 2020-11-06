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
    
//Userモデル にも１対多の関係を定義する。Movieモデルの user() は単数形で表現していた��、Userインスタンスが所有するMovieは複数あるのでmovies() という複数形を使って関数を作る。
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
//「User（this）モデルがMovieモデルを所有している」ということを明示する役割があり、実際のコード記述上でも、下記のようなコードで「Userインスタンスが所有しているMovieを取得」できる.   
//$user->movies()->get();  $user->movies; userの所有している情報を全て抽出できるようになる。
    
//登録機能が成立しているか tinker でデータベースの接続を確認してみる tinker : Laravelプロジェクトの「処理→実行→実行結果の表示」まで行ってくれる環境
//実際のウェブアプリ上で処理を実行しなくてもデータベースにログインして直接操作しなくても簡単に処理を行いその結果の成否を確認出来る。
//Movieモデルも連想配列形式で「動画情報を登録して保存する」という流れ。

//tinker上で登録機能が出来るようになったらブラウザ上でも出来るように実装していく。まずルーティングの記述。ログイン（新規ユーザー登録）した時のみ
//動画登録機能が利用できる、Moviesのルーティング。これにより、ログインしているユーザのみがMoviesControllerを使って、動画登録・削除できるようになる。


//中間テーブル専用のモデルを作っても良いが作らずともテーブルを操作できるコマンドがある。モデルを作らない代わりにそれらのコマンドを用いつつUserモデルに多対多の関係を書く。

//モデルに多対多の関係を定義するために、followings()とfollowers()という関数を定義
    public function followings()
    {
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }

    
/*belongsToMany関数を用いて記述しており、シンプルなコードで「あるユーザのフォロー中のユーザ」「あるユーザのフォロワーとなっているユーザ」を取得できる
  あるユーザのフォロー中のユーザを取得する： $user->followings        あるユーザのフォロワーとなっているユーザ を取得する： $user->followers
また、followings()関数の中身の引数の意味は以下の通。
第１引数：「Userモデルが、別の複数のUserモデルに所属している」ということを明示
第２引数：user_followテーブルという「中間テーブル」でユーザ同士が繋がっていることを示す
第３引数：中間テーブルに保存されている主体となるユーザ自身のＩＤカラム（user_id）を設定
第４引数：中間テーブルに保存されている関係先（相手）ユーザのＩＤカラム（follow_id）を設定
followings()で「あるユーザがフォローしているユーザ」を取得できる。followers()は、第３引数と第４引数を逆にして、「 あるユーザ をフォローしているユーザ」���取得できる。
どちらが主体となるのかを明確に定義するには３・４引数で設定。フォローは自分、フォロワーは相手が主体*/

//すでにフォローしていないか判定する
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id',$userId)->exists();
    }
//上記のfollowings関数ですでにフォローした人の'follow_id'とこれからフォローする人の$userIdが重複しないか判定。exits関数でかぶればtrueが返る。
    
    public function follow($userId)
    {
// すでにフォロー済みではないか？$existingは存在しているという変数、この中に上記のファンクションを入れる
        $existing=$this->is_following($userId);
// フォローする相手がユーザ自身ではないか？自分自身のIDをとこれからフォローするユーザのIDが一致すればこの変数は存在する。
        $myself=$this->id == $userId;
//kの2つの変数が存在するかしないかで条件を分けたい
        
// フォロー済みではない、かつフォロー相手がユーザ自身ではない場合、フォロー。上記両変数が存在しないときのみ以下を実行
        if (!$existing && !$myself) {
            $this->followings()->attach($userId);
        }
    }
    
    public function unfollow($userId)
    {
// すでにフォロー済みではないか？
        $existing=$this->is_following($userId);
// フォローする相手がユーザ自身ではないか？
        $myself=$this->id == $userId;
    
// すでにフォロー済みならば、フォローを外す
        if ($existing && !$myself) {
            $this->followings()->detach($userId);
        }
    }
    
/*下記コードで「フォローする」「フォローを外す」機能が実行可能に。
フォロー���る：　 $user->follow($userId)    $user（フォローを実行したいユーザ）->follow($userId)（フォローしたいユーザID）
フォローを外す：　 $user->unfollow($userId)
follow() 関数とunfollow()関数を実装するときには、「すでにフォロー済みではないか？」「フォローする相手がユーザ自身ではないか？」の２点を確認する必要がある。
最初に記述されているis_following()関数により、フォロー対象のユーザIDが、すでにフォローしているfollow_idと重複していないか判定し次に、フォロー対象のユーザIDがユーザ自分自身のIDと一致しているか判定。
この２つを判定してから、「フォロー」 「フォローを外す」 機能が実行されるようにする。「フォロー」 を実行することは、中間テーブルに情報を保存することを意味し、
「フォローを外す」を実行することは、中間テーブルから情報を削除することを意味。便利なコマンドであるattach()関数とdetach()関数を用いることで、中間テーブルのレコードを簡単に作成・消去することが可能。
attachとdetach Laravelドキュメント  https://readouble.com/laravel/5.5/ja/eloquent-relationships.html#updating-many-to-many-relationships
*/
}
