<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPages extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_title', 'status', 'slug', 'title_menu',
        'meta_title', 'meta_keyword', 'meta_description', 'content',
        'ip','created_by',
    ];
}
