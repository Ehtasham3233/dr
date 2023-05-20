<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'status', 'slug', 'main_heading',
        'meta_title', 'meta_keywords', 'meta_description', 'ip',
    ];
}
