<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('/', function () { return view('welcome'); });  以下のコードに書き換え

Route::get('/','UsersController@index');  //UsersController＠indexアクションを経由して、Topページを表示する。
 
Route::get('signup','Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup','Auth\RegisterController@register')->name('signup.post');

Route::get('login','Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login')->name('login.post');
Route::get('logout','Auth\LoginController@logout')->name('logout');

/*
ログインフォームを表示する
ログインフォームに入力された内容（メールアドレス・パスワードなどを）を送信する
ログアウトを行う
*/

Route::resource('users','UsersController',['only'=>['show']]);
//上記のRoute::resource()で、���つのルーティング記述の短縮バージョンと  'only' 記述で show actionのみに限定するという記述。
//将来的にactionを増やす可能性があるのでresource(短縮形)を使用している。
     
Route::group(['prefix'=>'users/{id}'],function() 
//prefix でユーザIDの表示を必須と定義する。
    {
    Route::get('followings','UsersController@followings')->name('followings');
//ROUTINEが followings なのでパラメータに表示、UsersControllerを使ってfollowings アクションとする。followingsルーティングと命名
//これがフォローユーザを一覧表示させるルーティング。下記がフォロワーを取得するルーティングとなる
    Route::get('followers','UsersController@followers')->name('followers');
    });

Route::group(['middleware'=>'auth'],function() 
{
//チャンネル名・ユーザ名を変更するrenameルーティング「Route::groupの中の記述」ログイン済みのユーザしか、名前変更のrenameルーティングにはアクセスできないように
//['middleware' => 'auth']としログイン認証を通ったユーザのみ、内部のルーティングにアクセスできるようにしている。つまり、/MoviesControllerにアクセスできるようになる.
    Route::put('users','UsersController@rename')->name('rename');
//ここまでしたら まずUsersControllerを作り、各アクションを作成。最初に��ップページを表示する「indexアクション」を記述。$ php artisan make:controller UsersController  
//で UsersController を作成。 laravel-quest　＞　app　＞　Http　＞　Controllers　＞　UsersController.php

//フォローにまつわる４つのルーティングを追記。ログイン認証を通っていないユーザでも、「誰が誰をフォローしているのか」を確認できるようにしたいので
//フォロー中のユーザを取得するfollowingsルーティングと、フォロワーを取得するfollowersルーティングに関してはログイン認証を通っていないユーザでもアクセスできるようにする。
//逆に、ログイン認証（auth）を通過したユーザだけがアクセスできるルーティング内に、followルーティングとunfollowルーティングを設けて、ログインユーザのみが
//「フォロー」「フォローを外す」を実行できるようにする。

    Route::group(['prefix'=>'users/{id}'],function() 
//フォロー関連の４つのルーティングは、['prefix' => 'users/{id}']と記述したルーティンググループを設けてどのユーザのフォロワー・フォロー中のユーザを操作・表示するのか」を明示するようにし��いる。
//これは何を示しているかというと、URLに「/users/{ユーザのID番号}/」が記載されるということ。つまり、followルーティングの場合（ユーザID１番の場合）、URLは 例）https://●●●●/users/1/follow のような形
    {
        Route::post('follow','UserFollowController@store')->name('follow');
//followを実行しようとしているのでpost、同じ理由でstoreアクションを用いる。
        Route::delete('unfollow','UserFollowController@destroy')->name('unfollow');
//中間tableのレコードを消す、のでdestroyアクション
    });
    
    Route::resource('movies','MoviesController', ['only'=>['create','store','destroy']]);
//７つのルーティング省略形、create', 'store', 'destroy にonly で限定している
});
