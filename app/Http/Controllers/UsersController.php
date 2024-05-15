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

  public function follow(User $user) {
    $user->followers()->attach(Auth::id());
    return redirect()->route('other-profile', ['id' => $user->id]);
}

public function unfollow(User $user)
{
    $user->followers()->detach(Auth::id());
    return redirect()->route('other-profile', ['id' => $user->id]);
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
        $user = User::find($id);

        return view('users.other_profile', compact('posts','user'));
    }

   // プロフィール更新
public function updateProfile(Request $request)
{
    $request->validate([
            'username' => 'string|between:2,12|required',
    'mail' => 'string|email|between:5,40|required',
    'password' => 'string|between:8,20|required|confirmed',
    'bio' => 'string|max:150|nullable',
    'images' => 'mimes:jpg,png,bmp,gif,svg|nullable',
], [
    'username.required' => 'ユーザー名は必須です。',
    'username.string' => 'ユーザー名は文字列で入力してください。',
    'username.between' => 'ユーザー名は2文字以上12文字以下で入力してください。',
    'mail.required' => 'メールアドレスは必須です。',
    'mail.string' => 'メールアドレスは文字列で入力してください。',
    'mail.email' => '有効なメールアドレス形式で入力してください。',
    'mail.between' => 'メールアドレスは5文字以上40文字以下で入力してください。',
    'password.required' => 'パスワードは必須です。',
    'password.string' => 'パスワードは文字列で入力してください。',
    'password.between' => 'パスワードは8文字以上20文字以下で入力してください。',
    'password.confirmed' => 'パスワードが一致しません。',
    'bio.string' => '自己紹介は文字列で入力してください。',
    'bio.max' => '自己紹介は150文字以内で入力してください。',
    'images.mimes' => '画像ファイルはjpg、png、bmp、gif、svg形式のいずれかを選択してください。',
]);

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

    User::where('id', Auth::id())->update([
        'username' => $username,

        'mail' => $mail,
        'password' => bcrypt($password),
        'bio' => $bio,
        'images' => $images,
    ]);

    return redirect('/top')->with('newProfile', '更新完了しました');
}




       public function searchList(Request $request){
        $keyword = $request->input('keyword');

        $query = User::query();

        if (!empty($keyword)) {
            $query->where('username', 'LIKE', "%{$keyword}%");
        }
        $users = $query->get();
        return view('users.search',['users'=>$users,'keyword'=>$keyword]);
    }



}
