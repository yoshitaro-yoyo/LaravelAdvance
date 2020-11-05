{{-- 各ユーザの詳細ページであるshowアクションの先のViewを作って、記述。このshow.blade.phpでも、各ユーザが所有している動画を表示させる --}}

@extends('layouts.app')

@section('content')


<h1>{{ $user->name }}</h1>

{{-- ユーザ名の下に「タブ」を表示させる.ユーザ所有の動画情報タブや、フォロワータブ等が切替えできるように --}}

<ul class="nav nav-tabs nav-justified mt-5 mb-2">
        <li class="nav-item nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show',['id'=>$user->id]) }}">動 画<br><div class="badge badge-secondary">{{ $count_movies }}</div></a></li>
        <li class="nav-item nav-link"><a href="" class="">フォロワー<br><div class="badge badge-secondary"></div></a></li>
        <li class="nav-item nav-link"><a href="" class="">フォロー中<br><div class="badge badge-secondary"></div></a></li>
</ul>

@include('movies.movies', ['movies' => $movies])

@endsection