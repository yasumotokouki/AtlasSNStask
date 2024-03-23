@extends('layouts.login')

@section('content')
<div class="inner">
  <div class="">
    <!-- エラーメッセージ表示 -->
     @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="contact-body">
      <div class="d-flex justify-content-center">
        <div class="contact-img">
           @if (Auth::user()->images === 'dawn.png')
      @else
      <img src="{{ asset('/' .  ltrim(Auth::user()->images, '/')) }}" alt="アイコン">
      @endif
        </div>
        <div class="flex">
           <form action="/updateProfile" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- 名前 -->
            <div class="contact-item">
              <div class="contact-title">
                <label for="username">user&nbsp;name</label>
              </div>
              <input type="hidden" name="id" value="{{  $users->id }}" />
              <input type="text" id="username" name="username" value="{{ $users->username }}" />
            </div>
            <!-- メール -->
            <div class="contact-item">
              <div class="contact-title">
                <label for="mail">mail&nbsp;address</label>
              </div>
              <input type="text" id="mail" name="mail" value="{{ $users->mail }}" />
            </div>
            <!-- パスワード -->
            <div class="contact-item">
              <div class="contact-title">
                <label for="password">password&nbsp;</label>
              </div>
              <input type="password" id="password" name="password" />
            </div>
            <!--パスワード確認 -->
            <div class="contact-item">
              <div class="contact-title">
                <label for="password_confirm">password&nbsp;confirm</label>
              </div>
              <input type="password" id="password_confirm" name="password_confirmation" />
            </div>
            <!-- 自己紹介 -->
            <div class="contact-item">
              <div class="contact-title">
                <label for="bio" class="">bio</label>
              </div>
              <input id="bio" name="bio" value="{{ $users->bio  }}">
            </div>
            <!-- アイコン -->
            <!-- アイコン -->
<div class="contact-item">

              <div class="contact-title">

                <label for="images">icon&nbsp;image</label>

              </div>

              <label class="file_upload">

                <input type="file" id="images" name="images" value="ファイルを選択" class="icon_select" />

              </label>

            </div>

            <input type="submit" value="更新" class="btn btn-danger btn-update" />
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
