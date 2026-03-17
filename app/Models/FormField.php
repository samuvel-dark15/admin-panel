<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'name','type','length','default','nullable','ai','label'
    ];

    public function values()
    {
        return $this->hasMany(FieldValue::class);
    }
}
