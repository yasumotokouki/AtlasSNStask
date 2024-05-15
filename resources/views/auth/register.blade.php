<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <!--IEブラウザ対策-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="ページの内容を表す文章" />
  <title></title>
  <link rel="stylesheet" href="http://127.0.0.1:8000/css/reset.css ">
  <link rel="stylesheet" href="http://127.0.0.1:8000/css/logout.css ">
  <!--スマホ,タブレット対応-->
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <!--サイトのアイコン指定-->
  <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
  <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
  <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
  <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
  <!--iphoneのアプリアイコン指定-->
  <link rel="apple-touch-icon-precomposed" href="画像のURL" />
  <!--OGPタグ/twitterカード-->
  <style>
    .error-message .error-inner li {
      font-size: 14px;
      color: red;
    }
  </style>
</head>

<body>
    <div class="atlas-logout-box"></div>
    <div class="atlas-box">
        <header>
            <h1><img src="images/atlas.png" class="logout-atlas"></h1>
            <p class="social"><a class="social-design">Social Network Service</a></p>
        </header>
    </div>

    <div id="container">

        <?php if (isset($errors) && $errors->any()): ?>
            <div class="error-message">
                <div class="error-inner">
                    <?php foreach ($errors->all() as $error): ?>
                        <?php if (!in_array($error, [
                            'The username field is required.',
                            'The mail field is required.',
                            'The password field is required.'
                        ])): ?>
                            <li><?= $error ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <div class="register-from">
            <div class="logout-inner">
                <form method="POST" action="http://127.0.0.1:8000/register" accept-charset="UTF-8">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">


                    <p class="new-user"><a class="new-user-design">新規ユーザー登録</a></p>

                    <div class="form">
                        <label for="user name">ユーザー名</label>
                        <input class="input" name="username" type="text" value="<?= old('username') ?>">
                        <?php if ($errors->has('username')): ?>
                            <p class="error-message"><?= __('2文字以上,12文字以内。') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="margin-form form">
                        <label for="メールアドレス">メールアドレス</label>
                        <input class="input" name="mail" type="text" value="<?= old('mail') ?>">
                        <?php if ($errors->has('mail')): ?>
                            <p class="error-message"><?= __('5文字以上,40文字以内。登録済みメールアドレス使用不可') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="margin-form form">
                        <label for="password">パスワード</label>
                        <input class="input" name="password" type="password" value="" id="password">
                        <?php if ($errors->has('password')): ?>
                            <p class="error-message"><?= __('英数字のみ
。8文字以上,20文字以内。') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="margin-form form">
                        <label for="password_confirmation">パスワード確認</label>
                        <input class="input" name="password_confirmation" type="password" value="" id="password_confirmation">
                        <?php if ($errors->has('password_confirmation')): ?>
                            <p class="error-message"><?= __('英数字のみ。8文字以上,20文字以内。Password入力欄と一致') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="btn-form">
                        <input class="btn btn-danger" type="submit" value="新規登録">
                    </div>

                    <div class="white new-user"><a href="/login">ログイン画面へ戻る</a></div>

                </form>
            </div>
        </div>
    </div>

    <script src="JavaScriptファイルのURL"></script>
    <script src="JavaScriptファイルのURL"></script>
</body>
</html>
