<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqOption extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(FaqQuestion::class, 'faq_question_id');
    }

    public function faqAnswer()
    {
        return $this->hasOne(FaqAnswer::class, 'faq_option_id');
    }
    
}
