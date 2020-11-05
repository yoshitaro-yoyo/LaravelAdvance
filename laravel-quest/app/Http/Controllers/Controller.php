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
        $count_movies = $user->movies()->count();

        return [
            'count_movies' => $count_movies,
        ];
    }
    //このcounts関数をshowアクションの$dataに足す。まずはshowアクションをindexアクションの下に記述$data += $this->counts($user);と記述。これだけでcounts($user)の戻り値が、$dataに追加される。
}
