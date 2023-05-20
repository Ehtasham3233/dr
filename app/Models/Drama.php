<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drama extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id', 'title', 'first_char', 'is_kshow','slug','description','icon',
        'release_year', 'release_date', 'cast','trailer_yt_url', 'drama_status', 
        'meta_title','meta_kwd', 'meta_desc', 'reff_url', 'status', 'ip', 'created_by',
        'updated_by'
    ];


    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function episodes()
    {
        return $this->hasMany(Episodes::class)->where('fetch_status','=', 1)->orderby('episodes_no','DESC');
    }


    public function genre()
    {
        return $this->hasMany(Dramagenre::class,'drama_id');
    }


    public function tags()
    {
        return $this->hasMany(Dramatags::class,'drama_id');
    }

    public function othername()
    {
        return $this->hasMany(Dramaothername::class);
    }
}
