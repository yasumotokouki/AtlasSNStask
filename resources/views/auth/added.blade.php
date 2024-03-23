@extends('layouts.logout')

@section('content')



<div class="added-from">

  <div class="added-inner">

    @if (Session::has('username'))
      <p class="added-main">{{ session('username') }}さん</p>
    @endif

    <p class="added-sub">ようこそ！AtlasSNSへ！</p>


    <p class="added-nice">ユーザー登録が完了しました。</p>
    <p class="added-nice">早速ログインをしてみましょう!</p>

    <a href="/login">
      <div class="btn-form">
      {{ Form::submit('ログイン画面へ',['class' => 'btn btn-danger']) }}
    </div>

    </a>



  </div>

</div>

@endsection
