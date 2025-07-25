<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FungiEducation extends Model
{
    use HasFactory;

    protected $table = 'fungi_educations';

    protected $fillable = [
        'slug',
        'title',
        'brief_description', // Added field for brief description
        'content',
        'image',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
