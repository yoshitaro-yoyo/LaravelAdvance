<header class="mb-5">
            
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            
        <a class="navbar-brand" href="/">YouTube-Curation</a>
            
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
            
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="nav navbar-nav navbar-right">
{{-- Authとはファサードと言われる。通常長��と表現しないといけないクラスを短縮して記述できる --}}
{{-- Illuminate\Support\Facades\Auth::class ⇒ Auth : ファサードは aliases 内で設定。laravel-quest＞config＞app.php --}}
{{-- Authファサードを利用した関数 ⇒ Auth::check()：ユーザがログイン状態にあるかどうかを判定する|Auth::user()|ログイン中のユーザを取得する  --}}
{{-- DB::connection()や、Route::getもDBファサードやRouteファサード|Laravelドキュメント https://readouble.com/laravel/5.5/ja/facades.html --}}
                @if (Auth::check())
                
                    <li class="nav-item">{!! link_to_route('logout', 'ログアウト', [], ['class' => 'nav-link']) !!}</li>
                    <li class="nav-item">{!! link_to_route('users.show','マイページ',['id'=>Auth::id()],['class'=>'nav-link']) !!}</li>
                    <li class="nav-item">{!! link_to_route('movies.create','動画を登録する',['id'=>Auth::id()],['class'=>'nav-link']) !!}</li>
{{--movies.create（ルーティング名）アクションにリンクされていて、パラメータに渡したい名。['id'=>Auth::id()]でログインしているユーザのIDを渡すことになる--}}
                    
                @else
                
                    <li class="nav-item">{!! link_to_route('signup', '新規ユーザ登録', [], ['class' => 'nav-link']) !!}</li>
                    <li class="nav-item">{!! link_to_route('login', 'ログイン', [], ['class' => 'nav-link']) !!}</li>
                
                @endif
                
            </ul>
        </div>
            
    </nav>
            
</header>