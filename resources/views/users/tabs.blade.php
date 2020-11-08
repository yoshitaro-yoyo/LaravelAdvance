<h1>{{ $user->channel }}</h1>
<h1 class="text-right">{{ $user->name }}</h1>

@include('follow.follow_button',['user'=>$user])

{{-- ユーザ名の下に「タブ」を表示させる.ユーザ所有の動画情報タブや、フォロワータブ等が切替えできるように --}}

<ul class="nav nav-tabs nav-justified mt-5 mb-2">
        <li class="nav-item nav-link {{ Request::is('users/'.$user->id) ? 'active':'' }}"><a href="{{ route('users.show',['id'=>$user->id]) }}">動 画<br><div class="badge badge-secondary">{{ $count_movies }}</div></a></li>
        <li class="nav-item nav-link {{ Request::is('users/*/followers') ? 'active':'' }}"><a href="{{ route('followers',['id'=>$user->id]) }}">フォロワー<br><div class="badge badge-secondary">{{ $count_followers }}</div></a></li>
        <li class="nav-item nav-link {{ Request::is('users/*/followings') ? 'active':'' }}"><a href="{{ route('followings',['id'=>$user->id]) }}">フォロー中<br><div class="badge badge-secondary">{{ $count_followings }}</div></a></li>
</ul>