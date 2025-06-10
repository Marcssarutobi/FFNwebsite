<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function events()
    {
        return $this->morphedByMany(Event::class, 'categorizable');
    }

    public function projects()
    {
        return $this->morphedByMany(Project::class, 'categorizable');
    }

    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'categorizable');
    }

    public function galleries()
    {
        return $this->morphedByMany(Gallery::class, 'categorizable');
    }

}
