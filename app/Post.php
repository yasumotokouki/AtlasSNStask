<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
// 　　モデルに新しいレコードを作成する際に、マスアサインメント（Mass Assignment）に使用される属性（カラム）を指定
    protected $fillable = [
        'user_id',
        'post',
        'username'

    ];
//One-to-Many
    public function user(){
        return  $this->belongsTo('App\User');
    }
    // 各投稿は特定のユーザーに関連付けられるという関係定義

// 　　多対多の関係を定義
    public function follows(){
        return $this->belongsToMany('App\User', 'follows', 'following_id', 'followed_id');
    }
// 　　特定のユーザーがどの投稿をフォローしているかを取得する
    public function followUsers(){
        return $this->belongsToMany('App\User', 'follows', 'followed_id', 'following_id');
    }
}
