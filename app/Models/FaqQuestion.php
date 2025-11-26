<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
    protected $guarded = [ ];

    public function faqOptions()
    {
        return $this->hasMany(FaqOption::class, 'faq_question_id');
    }

    
}
