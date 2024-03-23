
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="js/script.js"></script>
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

</head>
<body>
<header>
  <div id="head">
            <div class="header-icon">
                <div class="div"><a href="/top"><img  class="top-logo" src="{{ asset('images/atlas.png') }}"></a></div>

            </div>
    <div class="header-list">

    <div class="overlay">
       <div id="accordion" class="accordion-container">
                        <h4 class="accordion-title js-accordion-title">{{ auth()->user()->username }}さん</h4>
                        <div class="accordion-content">
                            <a href="/top"><div class="nav-item">HOME</div></a>
                            <a href="/profile"><div class="nav-item">プロフィール</div></a>
                            <a href="/logout"><div class="nav-item nav-bottom">ログアウト</div></a>
                        </div>
        </div>
        <div class="user-icon">
            <a href="/profile">
                <img class="user-avatar" src="{{ asset('/' . ltrim(Auth::user()->images, '/')) }}" alt="{{ auth()->user()->username }}のアイコン">
            </a>
        </div>

    </div>


</div>
</header>
 <div id="row">
        <div id="container">
            @yield('content')
        </div >
        <div id="side-bar">
            <div id="confirm">
                <p>{{ auth()->user()->username }}さんの</p>


                <div class="flex-box">
                    <p>フォロー数</p>
                    <p class="count">{{ \App\Follow::where('following_id', Auth::id())->count() }}人</p>
                </div>


                <!-- <div class="blue-btn">
                    <p class="btn"><a href="/follow-list">フォローリスト</a></p>
                </div> -->


                <div class="follow-btn">
                    <a href="/followList">
                    <div class="blue-btn">
                        <div>
                            <p class="btn">フォローリスト</p>
                        </div>
                    </div>
                    </a>
                </div>

                <div class="flex-box">
                    <p>フォロワー数</p>
                    <p class="count">{{ \App\Follow::where('followed_id', Auth::id())->count() }}人</p>
                </div>

                <!-- <div class="blue-btn">
                    <p class="btn"><a href="/follower-list">フォロワーリスト</a></p>
                </div> -->

                <div class="follower-btn">
                    <a href="/followerList">
                        <div class="blue-btn">
                            <div>
                                <p class="btn">フォロワーリスト</p>
                            </div>
                        </div>
                    </a>
                </div>


            </div>

            <div class="search-area">
                <a href="/search">
                    <div class="blue-btn">
                        <div>
                            <p class="btn">ユーザー検索</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

</body>
</html>
