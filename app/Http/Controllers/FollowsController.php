<?php

namespace App\Http\Controllers;
use App\User;
use App\Users;
use App\Post;
use Auth;
use DB;
use Validator;
use App\Follow;
use Illuminate\Http\Request;



class FollowsController extends Controller
{
    //
    public function followList(){
    // usersテーブルからユーザーの情報を取得する処理を追加する。
    $posts = Post::get();

    // ユーザーがフォローしているユーザーのIDを取得
    $following_id = Auth::user()->follows()->pluck('followed_id');

    // フォローしているユーザーの投稿を取得（ユーザー情報も一緒に取得）
    $posts = Post::with('user')->whereIn('user_id', $following_id)->latest()->get();

    // フォローしているユーザーの情報を取得
    $users = User::whereIn('id', $following_id)->get();

    return view('follows.followList', compact('posts', 'users'));
}


    public function followerList(){
        $posts = Post::get();
        $followed_id = Auth::user()->follower()->pluck('following_id');
        $posts = Post::with('user')->whereIn('user_id', $followed_id)->latest()->get();
        $users = User::whereIn('id',$followed_id)->get();
        return view('follows.followerList',compact('posts','users'));
    }

    public function follow(Request $request){
        $id = $request->input('user_id');
        \DB::table('follows')->insert([
            'following_id' => Auth::user()->id,
            'followed_id'  => $id
        ]);

        return redirect('/search');
    }

    public function unFollow(Request $request)
    {
        $id = $request->input('user_id');
        Follow::where('following_id', Auth::user()->id)->where('followed_id',$id)->delete();

        return redirect('/search');
    }

}
