<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FieldValue extends Model
{
    use HasFactory;

    protected $table = 'field_values';

    protected $fillable = [
        'user_id',
        'field_id',
        'value',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
