<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'status', 'icon', 'ip','created_by', 'country_id', 'genre',
        'tags', 'slug', 'movie_sub', 'movie_status', 'release_year','release_date',
        'reff_url', 'description','trailer_yt_url','cast','meta_title','meta_kwd',
        'meta_desc','first_char','movie_download_url','reff_url_detail','serv_id',
        'epiv_url'
    ];

    public function videos()
    {   
        return $this->hasMany(MoviesVideos::class,'movie_id')->with('server');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }
    public function genre()
    {
        return $this->hasMany(Moviegenre::class);
    }
    public function tags()
    {
        return $this->hasMany(Movietags::class);
    }
    public function othername()
    {
        return $this->hasMany(Moiveothername::class);
    }
}
