<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'category_id',
    ];

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

}
