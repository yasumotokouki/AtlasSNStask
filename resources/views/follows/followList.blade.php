@extends('layouts.login')

@section('content')
<div class="">
  <div class="content">
    <div class="follow_title">
      <h2 class="title">Follow&nbsp;List</h2>
    </div>
    <div class="follow_user">
      @foreach($users as $user)
      @if(Auth::user()->id != $user->id)
      <a href="{{ route('/other-profile',[ 'id' => $user->id ])}}">
        @if(Auth::user()->isFollowing($user->id))
        <img src="{{ asset($user->images) }}" alt="ユーザーアイコンです">
        @endif
      </a>
      @endif
      @endforeach
    </div>
  </div>
  <div class="follow_list">
    @foreach($posts as $post)
    <div class="post">
      <div class="flex post_look">
        <img src="{{ asset('' .  $post->user->images) }}" class="user_img">
        <h2 class="post_user">{{$post->user->username}}</h2>
        <p class="post_date">{{$post->created_at}}</p>
      </div>
      <div class="flex contents">
        <p class="post_text">{{$post->post}}</p>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
