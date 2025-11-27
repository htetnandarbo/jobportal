<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function likes(){
        return $this->hasMany(ProjectLike::class, 'project_id');
    }

    public function likedby(User $user){
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function comments(){
        return $this->hasMany(ProjectComment::class, 'project_id');
    }

}
