<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
//後で記述する UsersController＠showアクションで、Movieの登録数を表示させる。表示させるためにはController.phpに登録動画の数を数える処理を記述
//下記のように書くことで、全てのControllerでcounts関数を使えば動画の登録数を取得できるようになる。全てのControllerが以下のController.phpを継承しているため。
        
    public function counts($user) {
        $count_movies=$user->movies()->count();
        $count_followings=$user->followings()->count();
        $count_followers=$user->followers()->count();

        return [
            'count_movies'=>$count_movies,
            'count_followings'=>$count_followings,
            'count_followers'=>$count_followers,
        ];
    }
//このcounts関数をshowアクションの$dataに足す。まずはshowアクションをindexアクションの下に記述$data += $this->counts($user);と記述。これだけでcounts($user)の戻り値が、$dataに追加される。
//フォロー中の数、フォロワーの数---ユーザが所有している動画の数を、counts関数を使って表示させる処理をしたがここでは、ユーザがフォロー中の数、ユーザのフォロワーの数をそれぞれ表示させたい。
//動画の所有数のときと同じく、 Controllerクラスの中の counts関数 に記述することですべてのコントローラで フォロー中の数 ・ フォロワーの数を取得できる。
}
