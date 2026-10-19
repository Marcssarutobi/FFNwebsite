<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'image',
        'title_light',
        'title',
        'subtitle',
        'text',
        'button_label',
        'button_link',
    ];

}
