<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
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

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

}
