<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $table = 'visitor_logs';

    protected $fillable = [
        'visitor_key',
        'ip_hash',
        'user_agent_hash',
        'path',
        'visited_date',
    ];

    protected $casts = [
        'visited_date' => 'date',
    ];
}