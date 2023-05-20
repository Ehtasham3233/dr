<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'site_pages_meta';

    protected $fillable = [
        'page_name', 'page_title', 'meta_title','ip','created_by','updated_by',
        'meta_kwd', 'meta_desc', 'page_text_top', 'page_text_bottom'
    ];
}
