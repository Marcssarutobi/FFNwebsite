<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expeditions extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'title',
        'brefdescription',
        'start_date',
        'end_date',
        'location',
        'image',
        'bailleur',
        'content',
        'user_id',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
