<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class episode_videos extends Model
{
    use HasFactory;

    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }
}
