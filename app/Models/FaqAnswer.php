<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqAnswer extends Model
{
    protected $guarded = [];


    public function option()
    {
        return $this->belongsTo(FaqOption::class, 'faq_option_id');
    }
}
