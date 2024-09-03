<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [
        'company_id',
        'identification',
        'first_name',
        'last_name',
        'second_last_name',
        'birthdate',
        'gender',
        'status',
        'image',
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
