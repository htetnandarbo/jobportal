<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
    protected $guarded = [];
    protected $appends = ['comment_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCommentAtAttribute(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
