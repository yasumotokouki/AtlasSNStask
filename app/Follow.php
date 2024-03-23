<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function followingIds(Int $user_id)
    {
        return $this->where('following_id',$user_id)->get();
        // following_id 列が指定した $user_id と一致する行を選択
    }
    //
}
