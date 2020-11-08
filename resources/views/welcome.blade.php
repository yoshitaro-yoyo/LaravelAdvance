@extends('layouts.app')

@section('content')
        
    <div class="center jumbotron bg-warning">
            
        <div class="text-center text-white">
            <h1>YouTubeまとめ × SNS</h1>
        </div>
            
    </div>
    
    <div class="text-right">
        {{-- ログイン時のみ表示される --}}
        @if(Auth::check())
            {{ Auth::user()->name }}
        @endif

    </div>
    
    @include('users.users', ['users'=>$users])
{{-- users.usersでusersフォルダのusers.blade.phpに飛ぶ。ControllerからViewに変数を持っていく場合と同様に、Viewから別のViewに変数を持ち込む場合も、$usersという変数をViewに渡すための宣言 --}}
{{-- users.blade.phpをwelcome.blade.phpの中で@includeするとログイン後に表示されるトップページにユーザ名やユーザの最新の動画情報が一覧として表示される --}}
@endsection