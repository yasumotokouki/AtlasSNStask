<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Post;
use App\Follow;

class PostsController extends Controller
{
    public function index(){
    // すべての投稿をデータベースから取得
    $posts = Post::get();
    // ログインユーザーがフォローしているユーザーのIDを取得
    $following_id = Auth::user()->follows()->pluck('followed_id');
    // 各投稿に関連するユーザー情報を事前にロード、フォローしているユーザーのIDリストまたはログインユーザー自身の投稿のいずれかに一致する投稿を選択
    $posts = Post::with('user')->whereIn('user_id', $following_id)->orWhere('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
    // 最終的に、フィルタリングされた投稿データをビューに渡す
    return view('posts.index',['posts'=>$posts]);
}

public function post(Request $request)
{
    if ($request->isMethod('post')) {

        $data = $request->input();
        $user_id = Auth::id();
        $post = $request->input('newPost');

        // バリデーションルールの定義
        $validator = Validator::make($data, [
            'form_text' => 'required|min:1|max:150',
        ]);

        // バリデーションが失敗した場合の処理
        if ($validator->fails()) {
            return redirect('/top')
                ->withErrors($validator)
                ->withInput();
        }

        // バリデーションを通過した場合の処理
        // 新しい投稿をデータベースに作成
        $this->create($data);
        // postsテーブルに新しい投稿を挿入
        \DB::table('posts')
            ->insert([
                'post' => $post,
                'user_id' => $user_id
            ]);

        return redirect('/top');
    }
}



public function postTweet(Request $request)
{
// 新しい投稿をデータベースに保存する
        $post = new Post();

            $validator = Validator::make($request->all(), [
        'post_tweet' => 'required|string|min:1|max:150',
    ], [
        'post_tweet.required' => '投稿内容を入力してください',
        'post_tweet.min' => '投稿内容は1文字以上で入力してください',
        'post_tweet.max' => '投稿内容は150文字以内で入力してください',
    ]);

    if ($validator->fails()) {
        return redirect('/top')
                    ->withErrors($validator)
                    ->withInput();
    }


        $post->user_id = Auth::user()->id;
        $post->post = $request->post_tweet;
        $post->save();
        return redirect('/top')->with('message','投稿完了');
    }



     public function delete($id)
    //  削除する対象の投稿のIDを指定
     {
        \DB::table('posts')
        ->where('id', $id)
        ->delete();

        return redirect('index');
    }

   public function update(Request $request)
    //$idとpost のデータを取得
     {
        $id = $request->input('id');
        $post = $request->input('post');
        \DB::table('posts')
            ->where('id', $id)
            ->update(
                ['post' => $post]
            );
         return redirect('top');
    }


public function show(){
// フォローしているユーザーのidを取得
  $following_id = Auth::user()->follows()->pluck(' ① ');

// フォローしているユーザーのidを元に投稿内容を取得
  $posts = Post::with('user')->whereIn(' ② ', $following_id)->get();

  return view('yyyy', compact('posts'));
}
}
