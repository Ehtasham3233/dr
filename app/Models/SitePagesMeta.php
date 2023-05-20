<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePagesMeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'site_title_sort', 'email', 'phone','ip','created_by','updated_by',
        'site_logo', 'logo_mobile', 'site_icon','site_img', 'address', 'com_type',
        'fb_url', 'twtr_url', 'yt_url', 'google_url', 'pin_url', 'reddit_url',
        'vimeo_url', 'linkedin_url', 'ins_url', 'tele_url', 'footer_text', 'befor_head',
        'after_body', 'before_body','admin_light_logo', 'admin_dark_logo'
    ];
}
