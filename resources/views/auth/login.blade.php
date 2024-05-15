@extends('layouts.logout')

@section('content')

{!! Form::open(['url' => '/login']) !!}

<!-- <p><img src="images/welcome.png" class="welcome-img"></p> -->

<div class="logout-container">

<p class="new-user"><a class="new-user-design">AtlasSNSへようこそ</a></p>
<p class="label-text">{{ Form::label('メールアドレス') }}</p>
<p>{{ Form::text('mail',null,['class' => 'input']) }}</p>
<p class="label-text">{{ Form::label('パスワード') }}</p>
<p>{{ Form::password('password',['class' => 'input']) }}</p>

{{-- <p>{{ Form::submit('ログイン')}}</p> --}}
<div class="login-next">
    <div class="login-position">
    <div class="btn-form">
      {{ Form::submit('ログイン',['class' => 'btn btn-danger']) }}
    </div>

</div>
</div>

<p class="new-user"><a href="/register" class="new-user-design">新規ユーザーの方はこちら</a></p>

</div>
{!! Form::close() !!}



@endsection
