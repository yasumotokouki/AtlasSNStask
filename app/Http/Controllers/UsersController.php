<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Follow;
use App\User;
use App\Post;


class UsersController extends Controller
{
// 　　フォロー関係を確立する処理
    public function follow(User $user) {
        $user->isFollowing()->attach(Auth::id());
        return redirect('/search');
    }
    // フォロー解除
    public function unfollow(User $user)
    {
        $user->isFollowed()->detach(Auth::id());
        // detachがログインしているユーザー（Auth::id() で取得）と指定したユーザーとのフォロー関係を解除する操作

         return redirect('/search');
    }

    public function search(){
        $users = User::get();
        return view('users.search', compact('users'));
        // compact('users') は、$users 変数をビューに渡すための省略記
    }
        public function profile(){
        $users = Auth::user();
        return view('users.profile', compact('users'));
    }


    public function otherProfile($id){
        $posts = Post::with('user')->where('user_id',$id)->latest()->get();
        // Post::with('user'): →Post モデルの user 関連（リレーションシップ）を事前に読み込む
        // where('user_id', $id): →特定のユーザー（指定された $id に対応するユーザー）が投稿したポストのみを選択
        // latest(): →投稿を最新のものから順に並べ替え
        $user = User::find($id);

        return view('users.other_profile', compact('posts','user'));
    }

   // プロフィール更新
public function updateProfile(Request $request)
{
    // ユーザーからの入力データを検証するためのルールを定義
    $request->validate([
        'username' => 'string|between:2,12|required',
        'mail' => 'string|email|between:5,40|required',
        'password' => 'string|between:8,20|required|confirmed',
        'bio' => 'string|max:150|nullable',
        'images' => 'mimes:jpg,png,bmp,gif,svg|nullable',
    ]);

// ↓バリデーションが成功した後に、各入力項目のデータを取得
    $username = $request->input('username');
    $mail = $request->input('mail');
    $password = $request->input('password');
    $bio = $request->input('bio');
    $inputImages = $request->file('images');

    if (!empty($inputImages)) {
        $images = $inputImages->getClientOriginalName();
        $image = $inputImages->storeAs('public/images', $images);
        $images = Storage::url($image);

    } elseif (!(Auth::user()->images === 'Atlas.png' || empty(Auth::user()->images))) {
        $images = Auth::user()->images;
    } else {
        $images = null;
    }
    // 新しい画像がアップロードされておらず、かつ既存の画像もない場合のデフォルト処理

    // データベース内のusersテーブルから特定の条件を満たすユーザーを検索し検索条件に一致するレコードの情報を更新
    User::where('id', Auth::id())->update([
        'username' => $username,
        //  ユーザー名が変更された場合、新しいユーザー名を設定
        'mail' => $mail,
        'password' => bcrypt($password),
        // パスワードが変更された場合、新しいパスワードを bcrypt ハッシュ化して設定
        'bio' => $bio,
        'images' => $images,
        // ユーザーの画像が変更された場合、新しい画像の URL を設定
    ]);

    return redirect('/top')->with('newProfile', '更新完了しました');
}



       public function searchList(Request $request){
        $keyword = $request->input('keyword');
// 　　　　ユーザーが検索フォームに入力したキーワードを取得

// 　　　　 users テーブルのクエリを作成
        $query = User::query();
        // ↓キーワードが存在する場合のみ検索条件を追加する
        if (!empty($keyword)) {
            $query->where('username', 'LIKE', "%{$keyword}%");
            // username 列に対してキーワードを部分一致検索するクエリ条件を追加
        }
        $users = $query->get();
        // クエリを実行し、検索条件に一致するユーザーレコードを取得
        return view('users.search',['users'=>$users,'keyword'=>$keyword]);
    }



}
