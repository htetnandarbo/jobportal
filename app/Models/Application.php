<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $guarded = [ ];

    protected $appends = ['schedule_sent'];

    public function job(){
        return $this->belongsTo(Post::class, 'job_id', 'id');
    }

    public function candidate(){
        return $this->belongsTo(User::class, 'candidate_id', 'id');
    }

    public function employer(){
        return $this->belongsTo(User::class, 'employer_id', 'id');
    }

    public function schedule(){
        return $this->hasOne(Schedule::class, 'application_id');
    }

    public function getScheduleSentAttribute(){
        return $this->schedule()->exists();
    }

    
}
