<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'domain_id',
        'response_result',
        'response_code',
        'response_time',
        'response_error'
    ];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
