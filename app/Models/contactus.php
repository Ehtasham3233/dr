<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contactus extends Model
{
    use HasFactory;

    protected $table = 'contact_us';

    protected $fillable = [
        'name', 'email', 'subject', 'body', 'ip', 'created_at', 'updated_at'
    ];
}
