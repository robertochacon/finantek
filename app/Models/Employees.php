<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'person_id',
        'company_id',
        'supervisor_id',
        'position',
        'salary',
        'contract_start_date',
        'status',
    ];

    public function person()
    {
    	return $this->hasMany('App\Models\Persons', 'id', 'person_id');
    }
}
