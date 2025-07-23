<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brief_description',
        'profession',
        'content',
        'image',
        'type',
        'facebook_link',
        'twitter_link',
        'linkedin_link',
        'instagram_link',
    ];
}
