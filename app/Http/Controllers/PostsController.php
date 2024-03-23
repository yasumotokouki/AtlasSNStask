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

// フォームデータのバリデーションを行う。バリデーションが失敗した場合、エラーメッセージがセットされ、topページにリダイレクトされます。
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect('/top')
                ->withErrors($validator)
                ->withInput();
        }

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

        $validator = $request->validate([
            // post_tweetフィールドが必須で、文字列で、2文字以上200文字以下であることを確認
            'post_tweet' => 'required|string|min:2|max:200',
        ]);
        $post->user_id = Auth::user()->id;

        // ユーザーが入力した投稿内容を保持
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
