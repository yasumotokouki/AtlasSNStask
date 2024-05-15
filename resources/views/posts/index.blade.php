@extends('layouts.login')

@section('content')

  <form action="/create" enctype="multipart/form-data" method="post">
@csrf
    <!-- 投稿 -->
<div class="post-input-wrapper">
    <img class="form_icon" src="{{ asset('/' . ltrim(Auth::user()->images, '/')) }}" alt="ユーザーアイコン">&nbsp;
    <textarea class="form_text" name="post_tweet" placeholder="投稿内容を入れてください" required></textarea>
    <input type="image" class="container-btn" name="submit" src="{{ asset('images/post.png') }}" value="投稿">
    <div class="validation-message"></div>
</div>


  </form>

@foreach($posts as $post)
    <!--フォロワーの投稿 -->

<div class="post">

    <div class="flex post_look">
        <a href="{{ route('other-profile', ['id' => $post->user->id]) }}">

            <img src="{{ asset('' .  $post->user->images) }}" class="user_img">
        </a>
        <h2 class="post_user">{{$post->user->username}}</h2>
        <p class="post_date">{{$post->created_at}}</p>
    </div>
</div>


<div class="flex contents">
      <p class="post_text">{!! nl2br(e($post->post)) !!}</p>
    @if(Auth::user()->id == $post->user_id)


    <div class="content">
            <!-- 編集 -->
    <a class="js-modal-open" post="{{ $post->post }}" post_id="{{ $post->id }}"><img src="images/edit.png"></a>
            <!-- 削除 -->
        <style>
    .post_delete img {
        transform: scale(1.3);
    }
</style>
<a class="post_delete" href="/post/{{ $post->id }}/delete" onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか?')" onmouseover="changeImage(this, 'images/trash.png')" onmouseout="changeImage(this, 'images/trash-h.png')">
    <img src="images/trash-h.png" id="trashImage">
</a>

        <script>
            function changeImage(element, newImageSrc) {
                var image = element.querySelector('img');
                  if (image) {
                          image.src = newImageSrc;
                  }
               }
        </script>


    </div>

    @endif
</div>



        <!-- モーダルの中身 -->
<div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
        <div class="modal__content">
            <form action="/update" method="POST" onsubmit="return validateForm()">
    @csrf
    <input type="hidden" name="id" class="modal_id" value="{{ $post->id }}">
    <textarea name="post" class="modal_post" oninput="checkLength(this)">{{ $post->post }}</textarea>
   <input type="image" alt="更新" src="images/edit.png" width="50" height="50" style="margin-left: 480px;">


</form>

<script>
    function checkLength(textarea) {
        var maxLength = 150;
        if (textarea.value.length > maxLength) {
            textarea.value = textarea.value.substring(0, maxLength);
            alert("150文字を超えています。");
        }
    }

    function validateForm() {
        var maxLength = 150;
        var textarea = document.querySelector('.modal_post');
        if (textarea.value.length > maxLength) {
            alert("150文字を超えています。");
            return false;
        }
        return true;
    }
</script>

        </div>
</div>
 @endforeach

@endsection
