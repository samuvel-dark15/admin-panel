<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['created_by', 'status'];

    public function values()
    {
        return $this->hasMany(BlogValue::class);
    }
}
