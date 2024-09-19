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
        'personal_references',
        'family_references',
        'business_references',
        'expenses_home',
        'expenses_credit_quotas',
        'expenses_other',
        'warranty',
        'status',
    ];

    public function person()
    {
    	return $this->hasMany('App\Models\Persons', 'id', 'person_id');
    }

}
