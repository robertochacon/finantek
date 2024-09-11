<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types_documents extends Model
{
    use HasFactory;

    protected $table = 'types_documents';

    protected $fillable = [
        'company_id',
        'name',
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
