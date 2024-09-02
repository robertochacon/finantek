<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'full_name',
        'short_name',
        'rnc',
        'website',
        'phone',
    ];

    public function users()
    {
    	return $this->hasMany('App\Models\User', 'company_id');
    }

}
