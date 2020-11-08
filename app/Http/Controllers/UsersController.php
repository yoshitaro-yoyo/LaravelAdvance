<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; //追記

class UsersController extends Controller
{
    public function index()
    {
        $users=User::orderBy('id','desc')->paginate(9);
        
//$users = orderBy('id','desc')は「すべてのユーザをＩＤが新しい順（降順）に並び替える」という意味。orderBy()という順番を並び替える関数。
//->paginate(9);は、ページネーションを行う。上記の場合、「最新のユーザの内9人を取得する」という意味。

        return view('welcome', [
            'users'=>$users,
//view() の ( 'welcome' ) は、welcome.blade.phpを表示させるという意味。'users' => $users は$usersという変数をViewに持っていくという宣言。このように宣言された変数しか
//ControllerからViewに持って行って表示させることはで出来ない。記述形式としては連想配列の形を取る。左側の「users」が Viewで呼び出す変数の名前を示して、右側の「$users」がController、ここで作った変数を意味。
        
//このindexファンクションは welcome の view の方にページを取得して表示させる際に 上記で定義した変数 $users をお土産として持っていく
        
//ここまでしたらMovies の一覧を表示する共通の View として、 users.blade.php を作成
        ]);
    }
    
    public function show($id)
    {
        $user=User::find($id);
        $movies=$user->movies()->orderBy('id','desc')->paginate(9);

        $data=[
            'user'=>$user,
            'movies'=>$movies,
        ];

        $data += $this->counts($user);

        return view('users.show',$data);
    }
//counts関数をshowアクションの$dataに足す。showアクションをindexアクションの下に記述。
//$data += $this->counts($user);と記述すればこれだけでcounts($user)の戻り値が$dataに追加される。
    
    public function rename(Request $request)
    {
        $this->validate($request,[
                'channel'=>'required|max:20',
                'name'=>'required|max:15',
        ]);

        $user=\Auth::user();
        $movies=$user->movies()->orderBy('id', 'desc')->paginate(9);

        $user->channel=$request->channel;
        $user->name=$request->name;
        $user->save();
        
        $data=[
            'user'=>$user,
            'movies'=>$movies,
        ];
        
        $data += $this->counts($user);

        return view('users.show',$data);
    }
    
    
//ユーザ個別詳細ページ（マイページ）に、フォロー中・フォロワーの一覧を表示させる。まずはUsersController にフォロー中・フォロワーのユーザ情報を抽出する記述。その後Viewでページ表示させる
//各ページは、タブによって表示を切替えできるようにするが、共通している部分がある 。
//ユーザの動画一覧ページ（show.blade.php）
//ユーザのフォロー中一覧ページ（followings.blade.php）
//ユーザのフォロワー一覧ページ（followers.blade.php）
//なので、共通している部分の内容を、タブ（tabs.blade.php）として切り分けましょう。タブの中には、 followingsページ と followersページ に行けるリンクも入れておきましょう。
//また、ユーザ詳細ページからも、そのユーザをフォローできるように、ユーザ名の下に「フォローボタン」も設置しておきましょう。
    
    public function followings($id)
    {
        $user=User::find($id);
        $followings=$user->followings()->paginate(9);

        $data=[
            'user'=>$user,
            'users'=>$followings,
        ];

        $data += $this->counts($user);

        return view('users.followings',$data);
    }
    
    public function followers($id)
    {
        $user=User::find($id);
        $followers=$user->followers()->paginate(9);

        $data=[
            'user'=>$user,
            'users'=>$followers,
        ];

        $data += $this->counts($user);

        return view('users.followers',$data);
    }
}
