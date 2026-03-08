<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{


    protected $fillable = [
        'user_id',
        'user_input',
        'ai_output',
        'language',
        'tone',
        'language'
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
