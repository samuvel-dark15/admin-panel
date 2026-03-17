<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormValue extends Model
{
    protected $table = 'form_values';

    protected $fillable = [
         'employee_id',
        'field_id',
        'value',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
