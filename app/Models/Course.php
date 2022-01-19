<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'detail', 'price', 'time', 'url'
    ];

    /**
     * Get the comments for the course.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_courses', 'courses_id', 'categories_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'courses_users',  'courses_id', 'users_id')->withPivot(['admin']);
    }
}
