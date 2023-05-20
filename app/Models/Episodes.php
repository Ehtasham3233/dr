<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episodes extends Model
{
    use HasFactory;
    protected $fillable = [
        'status', 'drama_id', 'title','slug','home_recent','home_kshow','episodes_no',
        'type', 'date', 'download_url', 'meta_title', 'meta_kwd', 'meta_desc',
        'description', 'ip', 'created_by', 'updated_by', 'serv_id', 'reff_url'
    ];

    //protected $table = 'drama_episodes';

    protected $dates = ['created_at','date'];


    public function drama()
    {
        return $this->belongsTo(Drama::class, 'drama_id');
    }

    public function videos()
    {   
        return $this->hasMany(EpisodeVideos::class,'episode_id')->with('server');
    }


    public function server()
    {   
        return $this->belongsTo(Server::class,'server_id');
    }

}
