<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mail', 'password', 'images',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // パスワードやトークンなどの機密情報を隠す
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAllUsers(Int $user_id)
    // 引数として $user_id を受け取る
    {
        return $this->Where('id', '<>', $user_id)->paginate(5);
        // 'id' 列が $user_id と等しくない行を選択＆5件ずつのユーザー情報が1ページに表示される
    }


// 　　特定のユーザー ID に該当するユーザー情報を取得する
    public function getUsers(Int $user_id)
    {
        return $this->Where('id', $user_id)->get();
        // 指定したユーザー ID に該当するユーザー情報を選択
    }

    public function getTimeLines(Int $user_id)
    {
        return $this->Where('user_id', $user_id)->orderBy('created_at','DESC');
        // created_at 列を基準に降順（新しいものから古いものへ）に並べ替え
    }


// ユーザーが他のユーザーをフォローできる仕組みを構築（多対多の関係を表現す）
    public function follower()
    {
        return $this->belongsToMany(self::class, 'follows', 'followed_id', 'following_id');
    }

    // ユーザーが他のユーザーをフォローする関係を表すための関数
    public function follows()
    {
        return $this->belongsToMany(self::class, 'follows', 'following_id', 'followed_id');
    }


    // 他のユーザーをフォローするためのアクションを表現
    public function follow(Int $user_id)
    // $user_id という引数を取り、フォロー対象のユーザーのIDを指定する
    {
        return $this->follows()->attach($user_id);
    }

    // 他のユーザーのフォローを解除するアクション
    public function unfollow(Int $user_id)
    // 指定されたユーザーのフォローを解除するためのアクションを定義
    {
        return $this->follows()->detach($user_id);
        // detach($user_id) メソッドを呼び出して、中間テーブルから指定したユーザーとのフォロー関係を解除
    }

    // 指定されたユーザーをフォローしているかどうかを判定する
    public function isFollowing(Int $user_id)
    {
        return $this->follows()->where('followed_id', $user_id)->exists();
        // where('followed_id', $user_id) を呼び出して、中間テーブル内で指定したユーザーをフォローしているかどうかを条件で絞り込み
        // exists() メソッドを呼び出して、条件を満たすレコードが存在するかどうかを確認

    }

    // フォローされているか
    public function isFollowed(Int $user_id)
    {
        $auth_id = auth()->user()->id;

        return $this->followers()->where('following_id', $user_id)->exists();
    }




    }
