@extends('layouts.login')

@section('content')

<script src="{{ asset('js/script.js') }}"></script>

<div class="inner">
  <div class="inner_box">

    <div class="user_box">
      <div class="flex">
        <div class="flex">
          <div class="user">
            <img src="{{ asset($user->images) }}">&nbsp;
          </div>
          <div class=" user_box">
            <div class="flex">
              <span class="name">name</span>&nbsp;
              <p class="user_name">{{ $user->username }}</p>
            </div>
            <div class="flex">
              <span class="bio">bio</span>&nbsp;
              <p class="user_bio">{{ $user->bio }}</p>
            </div>
          </div>
        </div>
        <div class="follow_btn">
          @if(Auth::user()->isFollowing($user->id))
          <form action="{{ url('/unFollow')}}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <button type="submit" class="btn-danger">フォロー解除</button>
          </form>
          @else
          <form action="{{ url('/follow')}}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <button type="submit" class="btn btn-primary">フォローする</button>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="">
    @foreach($posts as $post)
    <div class="post">
      <div class="flex post_look">
        <img src="{{ asset($user->images) }}" class="user_img">
        <h2 class="post_user">{{$post->user->username}}</h2>
        <p class="post_date">{{$post->created_at}}</p>
      </div>
      <div class=" flex contents">
        <p class="post_text">{!! nl2br(e($post->post)) !!}</p>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
