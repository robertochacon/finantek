<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'person_id',
        'company_id',
        'status',
    ];

    public function person()
    {
    	return $this->hasMany('App\Models\Persons', 'id', 'person_id');
    }

}
