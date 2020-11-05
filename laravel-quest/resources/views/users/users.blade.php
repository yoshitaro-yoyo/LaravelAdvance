{{-- indexアクション ユーザー一覧を表示させるページ --}}
{{-- ここで行っているのは、foreach文で$usersから各ユーザを抽出し、各ユーザの動画情報 $movies の一番最近登録された動画情報を抜き出す --}}
{{-- Laravelでは @php ~ @endphp で、＜?php ~?＞と同じくＰＨＰの記述の開始と終了の宣言を表す --}}

<h2 class="mt-5 mb-5">users</h2>

<div class="movies row mt-5 text-center">

            {{-- ＄userが所有しているmovieの情報を取得して、最新の動画情報だけを取得。＄movieにこれを代入している --}}
    @foreach ($users as $key => $user)

        @php
        
            $movie=$user->movies->last();       
        
        @endphp
        
        @if($loop->iteration % 3 == 1 && $loop->iteration !=1)    
            {{-- ＄userのforeach（繰り返している）回数がこの変数に入る。繰り返しの数値が３で割ったときにあまりが１になる時、４人目のユーザーが現れる前に改行を行う(一人目のときは除く)--}}
        
            </div> 
            
            <div class="movies row mt-3 text-center">
        
        @endif
        
            <div class="col-lg-4 mb5">  {{-- 画面幅ラージ以上、4✕３で１２のグリッドシステムなので一人あたり４の画面幅をとる事にする --}}
                
                <div class="movie text-left d-inline-block">  
                    
                        ＠{!! link_to_route('users.show',$user->name,['id'=>$user->id]) !!}
                        {{-- 動画で表示されるユーザー情報の表示 --}}
                        
                        <div>                                 {{-- 動画情報 --}}
                            @if($movie)                       {{-- 動画情報が存在する or 子な場合を定義する --}}
                            
                                <iframe width="290" height="163.125" src="{{ 'https://www.youtube.com/embed/'.$movie->url }}?controls=1&loop=1&playlist={{ $movie->url }}" frameborder="0"></iframe>
                                {{-- iframeは動画情報を小窓のようにページに埋め込める。画面幅指定。urlカラム（YouTube動画ID）を変数（$movie->url）として代入することによって、ユーザの登録動画を表示させようとしている --}}
                                {{-- ?controls=1で動画上にバー表示 loop=1でどうがの繰返しでplaylist={{ $movie->url }}で動画のURLを指定している。frameborder="0"で外枠を消す --}}
                            
                            @else
                                 <iframe width="290" height="163.125" src="https://www.youtube.com/embed/" frameborder="0"></iframe>
                                {{-- 動画情報がない場合は黒枠表示される --}} 
                            
                            @endif
                        </div>
                        
                        <p>
                            @if(isset($movie->comment))  
                               {{ $movie->comment }}     
                            @endif
    
{{-- ＠if（isset（$movie->comment））という記述のところで、動画のcommentカラムが存在すればそのコメント内容を表示させるようする。 --}}
{{-- isset関数は変数の中身がNullかどうか確認する --}}
                        </p>
                    
                </div>
                
            </div>
        
    @endforeach
    
</div>

{{ $users->links('pagination::bootstrap-4') }}
{{-- １ページ目に９名までのユーザを表示し、１０名以上のユーザ情報があったら２ページ以上に渡って表示させる場合の次ページリンクを表示 --}}
{{-- 次は、動画を登録できるように、登録フォームMoviesController　createアクションをつくっていきましょう。 --}}

