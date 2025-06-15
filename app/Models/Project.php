<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'brief_description',
        'content',
        'image',
        'category_id',
        'status',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
