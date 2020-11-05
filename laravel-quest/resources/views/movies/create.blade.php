{{-- 動画登録フォーム --}}

@extends('layouts.app')

@section('content')


    <div class="text-right">

        {{ Auth::user()->name }}

    </div>

        <h2 class="mt-5">動画を登録する</h2>

        {!! Form::open(['route'=>'movies.store']) !!}
            <div class="form-group mt-5">

                {!! Form::label('url','新規登録YouTube動画 "ID" を入力する',['class'=>'text-success']) !!}
                    <br>例）登録したいYouTube動画のURLが&thinspace;<span>https://www.youtube.com/watch?v=-bNMq1Nxn5o なら</span>
                    <div>&emsp;&emsp;"v="の直後にあ���&thinspace;"<span class="text-success">-bNMq1Nxn5o</span>" を入力</div>
                {!! Form::text('url',null,['class'=>'form-control']) !!}
                
                {!! Form::label('comment','登録動画へのコメント',['class'=> 'mt-3']) !!}
                {!! Form::text('comment',null,['class'=>'form-control']) !!}
                

                {!! Form::submit('新規登録する？',['class'=> 'button btn btn-primary mt-5 mb-5']) !!}

            </div>
        {!! Form::close() !!}


        <h2 class="mt-5">あなたの登録済み動画</h2>

        @include('movies.movies', ['movies' => $movies])
        
{{-- 動画情報を別のViewに分ける。こうすることで、後々の変更などにも強くる。保守性、容易変更性 --}}
{{-- moviesフォルダのmovies.blade.phpを表示しその際に、Viewから別のViewに変数を持ち込む。その場合も、$moviesという変数をViewに渡すための宣言をする ---}}
{{-- moviesフォルダのmovies.blade.phpはまだないので作成--}}

@endsection