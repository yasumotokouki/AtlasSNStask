@extends('layouts.login')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

<div class="search_inner">
  <div class="search_content">
    <div class="search_form flex">
      <div>
<form action="{{ url('/searchList')}}" method="GET">
    @csrf
    <input type="text" name="keyword" placeholder="ユーザー名">
    <button type="submit" class="btn btn-info search_icon" type="submit">
        <i class="fas fa-search"></i>  <!-- 虫眼鏡アイコンを追加 -->
    </button>
</form>
      </div>
      <div class="search_keyword">
        @if(!empty($keyword))
        <div class="search_list">
          <p>検索ワード：{{ $keyword }}</p>
        </div>
        @endif
      </div>
    </div>
    <div class="search_user">
      <div class="">
        @foreach($users as $user)
        <div class="d-flex justify-content-between">
          <div class="col-md-8">
            <div class="">
              <div class="">
                @if(Auth::user()->id != $user->id)
                <div class="d-flex justify-content-between post_look">
                  <div class="flex">
                    <div class="search_img"><img src="{{ asset($user->images) }}">&nbsp;</div>
                    <div class="post_user">名前：{{ $user->username }}&nbsp;</div>
                  </div>
                  <div class="search_btn">
                    @if(Auth::user()->isFollowing($user->id))
                    <form action="{{ url('/unFollow')}}" method="POST">
                      @csrf
                      <input type="hidden" name="user_id" value="{{$user->id}}">
                      <button type="submit" class="btn btn-danger">フォロー解除</button>
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
                @endif
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
