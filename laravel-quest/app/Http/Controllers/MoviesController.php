<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; 
use App\Movie; 

class MoviesController extends Controller
{
    public function create()
        //ここで作るのはmovies/createというURLにアクセスした場合に表示される画面
    {
        $user = \Auth::user();
        //ログインをしているユーザーを取得。$userにろログインユーザーを入れることが出来る
        
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
        
        $data=[
            'user' => $user,
            'movies' => $movies,
        ];
        
        //２つの変数をViewに渡す、$dataという変数に２つの変数を配列形式で代入。
        
        return view('movies.create', $data);
        //渡し先はmoviesフォルダのcreate.blade.php $dataには２つの変数が入っている。
        //次はViewを作る。まず、メニューから新規登録フォームへ移動できるリンクを、ヘッダー部分に記述。ここでもLaravel Collectiveの link_to_route()
        //そしてmoviesフォルダを作成、その中にcreate.blade.php 動画登録フォームをつくる。
        //laravel-quest　＞　resources　＞　views　＞　movies　＞　create.blade.php
    }
         //動画登録フォームから「動画登録」のアクションを実行できるように実装。tinkerを用いて登録していたが、同じやり方でcreate関数を使って動画情報を保存
    
    public function store(Request $request)
    {

        $this->validate($request,[
            'url' => 'required|max:11',
            'comment' => 'max:36',
        ]);
            //バリデーションを掛けることで、URL入力を必須とし、URL・コメントのそれぞれの最大入力文字数を制限

        $request->user()->movies()->create([
            'url' => $request->url,
            'comment' => $request->comment,
        ]);
            // $requestの内容をuesrのmoviseに保存（create）。フォームに入力されたURL・コメントを、動画のそれぞれのカラムに入れ込む処理

        return back();
            //このように記述すると投稿が完了すると直前のページが自動的に表示。特定のViewなどを指定しなくとも、統一した記述内容で簡単に実装できる利点がある。
    }
    
      public function destroy($id)
    {
        $movie = Movie::find($id);

        if (\Auth::id() == $movie->user_id) {
            $movie->delete();
        }
        //削除実行処理を意味する、$movie->delete(); は、if文で囲むことにより自分以外の他のユーザの動画を勝手に削除されてしまうことがないように
        //ログインしているユーザIDと動画を所有しているユーザのIDが一致している場合のみ、削除処理を実行するように記述

        return back();
    }
}
