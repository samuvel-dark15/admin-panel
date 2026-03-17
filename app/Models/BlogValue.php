<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogValue extends Model
{
    protected $fillable = [
        'blog_id',
        'blog_field_id',
        'value'
    ];

    // 🔗 BlogValue → Blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // 🔗 BlogValue → BlogField
    public function field()
    {
        return $this->belongsTo(BlogField::class, 'blog_field_id');
    }
}
