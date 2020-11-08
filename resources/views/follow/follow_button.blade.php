@if(Auth::check())
{{-- @if(Auth::check())により、ユーザがログイン認証を通っている場合のみ、ボタンを表示させる --}}
    @if (Auth::id() != $user->id)
{{-- ユーザが自分自身をフォローできないように、自分のIDと一致しないユーザIDに対してのみ、ボタンを表示 --}}
        @if (Auth::user()->is_following($user->id))
{{-- すでに$user_id をフォローしてしまってる場合、アンフォロー出来るということdeleteアクション --}}
            {!! Form::open(['route' => ['unfollow', $user->id], 'method' => 'delete']) !!}
                {!! Form::submit('このユーザのフォローを外す', ['class' => "button btn btn-danger mt-1"]) !!}
            {!! Form::close() !!}
            
        @else
{{-- 逆なのでフォローボタンを出現させる --}}
            {!! Form::open(['route' => ['follow', $user->id]]) !!}
                {!! Form::submit('このユーザをフォローする', ['class' => "button btn btn-primary mt-1"]) !!}
            {!! Form::close() !!}
            
        @endif
    
    @endif

@endif

{{-- これまでがボタンを表示させたい場所で@includeすると、 「フォローする」ボタン　もしくは　「フォローを外す」ボタンが表示 --}}
{{-- ボタンの配置「フォローする」ボタン「フォローを外す」ボタンを、トップページのユーザ一覧（users.blade.php）に置く。 --}}
{{-- コメントの下にボタンを表示させる。 laravel-quest　＞　resources　＞　views　＞　users　＞　users.blade.php --}}