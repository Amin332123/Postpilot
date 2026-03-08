<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'user_subscriptions';
    protected $fillable = [
        'user_id',
        'plan',
        'monthly_limit',
        'used_this_month',
        'price',
        'status',
        'starts_at',
        'ends_at',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }





    protected $casts = [
    'starts_at' => 'datetime',
    'ends_at' => 'datetime',
];
}
