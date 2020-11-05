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

Route::get('/', 'UsersController@index');  //UsersController＠indexアクションを経由して、Topページを表示する。
 
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

/*
ログインフォームを表示する
ログインフォームに入力された内容（メールアドレス・パスワードなどを）を送信する
ログアウトを行う
*/

Route::resource('users', 'UsersController', ['only' => ['show']]);
//上記のRoute::resource()で、７つのルーティング記述の短縮バージョンと  'only' 記述で show actionのみに限定するという記述。
//将来的にactionを増やす可能性があるのでresource(短縮形)を使用している。
     
Route::group(['middleware' => 'auth'], function () {
    //チャンネル名・ユーザ名を変更するrenameルーティング「Route::groupの中の記述」ログイン済みのユーザしか、名前変更のrenameルーティングにはアクセスできないように
    Route::put('users', 'UsersController@rename')->name('rename');
    Route::resource('movies', 'MoviesController', ['only' => ['create', 'store', 'destroy']]);
});
//['m iddleware' => 'auth']としログイン認証を通ったユーザのみ、内部のルーティングにアクセスできるようにしている。つまり、
//MoviesControllerにアクセスできるようになる

//ここまでしたら まずUsersControllerを作り、各アクションを作成。最初にトップページを表示する「indexアクション」を記述。
//$ php artisan make:controller UsersController  で UsersController を作成。
//laravel-quest　＞　app　＞　Http　＞　Controllers　＞　UsersController.php