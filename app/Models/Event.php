<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'brefdescription',
        'content',
        'start_date',
        'end_date',
        'location',
        'image',
        'category_id',
        'status',
        'user_id',
    ];

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

}
