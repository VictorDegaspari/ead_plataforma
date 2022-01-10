<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'color', 'description'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'categories_courses', 'categories_id', 'courses_id');
    }
}
