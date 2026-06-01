<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = [
        'user_id',
        'domain',
        'title',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function last_log()
    {
        return $this->hasOne(Log::class)->latestOfMany('created_at');
    }
}
