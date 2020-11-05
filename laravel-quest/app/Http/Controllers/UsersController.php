<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; //追記

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(9);
        //$users = orderBy('id','desc')は「すべてのユーザをＩＤが新しい順（降順）に並び替える」という意味。orderBy()という順番を並び替える関数。
        //->paginate(9);は、ページネーションを行う。上記の場合、「最新のユーザの内9人を取得する」という意味。
        return view('welcome', [
            'users' => $users,
        //view() の ( 'welcome' ) は、welcome.blade.phpを表示させるという意味。'users' => $users は$usersという変数をViewに持っていくという宣言。
        //このように宣言された変数しか、ControllerからViewに持って行って表示させることはで出来ない。記述形式としては連想配列の形を取る。
        //左側の「users」が Viewで呼び出す変数の名前を示して、右側の「$users」がController、ここで作った変数を意味。
        
        //このindexファンクションは welcome の view の方にページを取得して表示させる際に 上記で定義した変数 $users をお土産として持っていく
        
        //ここまでしたらMovies の一覧を表示する共通の View として、 users.blade.php を作成
        ]);
    }
    
     public function show($id)
    {
        $user = User::find($id);
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);

        $data=[
            'user' => $user,
            'movies' => $movies,
        ];

        $data += $this->counts($user);

        return view('users.show',$data);
    }
    //counts関数をshowアクションの$dataに足す。showアクションをindexアクションの下に記述。
    //$data += $this->counts($user);と記述すればこれだけでcounts($user)の戻り値が$dataに追加される。
}
