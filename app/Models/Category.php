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
        return $this->hasMany(Event::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

}
