<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
    * Get the post that owns the comment.
    */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
