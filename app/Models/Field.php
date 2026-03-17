<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'fields';

    protected $fillable = [
        'name',
        'label',
        'module',
        'type',
        'length',
        'default_value',
        'nullable',
        'placeholder',
        'options',
        'sort_order',
    ];

    public function values()
{
    return $this->hasMany(FieldValue::class);
}
}
