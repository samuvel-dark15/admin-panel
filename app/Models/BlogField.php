<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogField extends Model
{
    protected $fillable = ['name', 'label', 'type', 'sort_order', 'nullable'];
}
