{{-- 各ユーザの詳細ページであるshowアクションの先のViewを作って、記述。このshow.blade.phpでも、各ユーザが所有している動画を表示させる --}}

@extends('layouts.app')

@section('content')

<h1>{{ $user->channel }}</h1>
<h1 class="text-right">{{ $user->name }}</h1>

<h1>{{ $user->name }}</h1>

{{-- ユーザ名の下に「タブ」を表示させる.ユーザ所有の動画情報タブや、フォロワータブ等が切替えできるように --}}
<ul class="nav nav-tabs nav-justified mt-5 mb-2">
        <li class="nav-item nav-link {{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show',['id'=>$user->id]) }}">動 画<br><div class="badge badge-secondary">{{ $count_movies }}</div></a></li>
        <li class="nav-item nav-link"><a href="" class="">フォロワー<br><div class="badge badge-secondary"></div></a></li>
        <li class="nav-item nav-link"><a href="" class="">フォロー中<br><div class="badge badge-secondary"></div></a></li>
</ul>

@include('movies.movies', ['movies' => $movies])

@if(Auth::id() == $user->id)

        <h3 class="mt-5">表示名の変更</h3>
            
        <div class="row mt-5 mb-5">
          <div class="col-sm-6">
                  
                   {!! Form::open(['route' => 'rename', 'method' => 'put']) !!}
                      <div class="form-group">
                          {!! Form::label('channel', 'チャンネル名') !!}
                          {!! Form::text('channel', $user->channel, ['class' => 'form-control']) !!}
                      </div>
                      
                      <div class="form-group">
                          {!! Form::label('name', '名前') !!}
                          {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                      </div>
                      
                      {!! Form::submit('更新する？', ['class' => 'button btn btn-primary mt-2']) !!}
                   {!! Form::close() !!}
                
          </div>
        </div>
        
@endif

@endsection