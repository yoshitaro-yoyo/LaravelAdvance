<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
//store関数は、ユーザが他のユーザをフォローする処理を担当します。反対に、destroy関数は、ユーザがしているフォローを外す処理を担う。
//Userモデルに記述したfollow関数とunfollow関数を利用して記述している。
    public function store($id) 
    {
        \Auth::user()->follow($id);
        return back();
    }
    
    public function destroy($id) 
    {
        \Auth::user()->unfollow($id);
        return back();
    }
}
