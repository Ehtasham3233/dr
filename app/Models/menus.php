<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menus extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'status', 'slug', 'type','ip','created_by','updated_by', 'is_parent',
    ];
}
