<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types_loans extends Model
{
    use HasFactory;

    protected $table = 'types_loans';

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'interest_rate',
        'max_term_months',
        'min_amount',
        'max_amount',
        'legal_fees',
        'late_fee_percentage',
        'grace_days',
        'requirements',
        'status',
        'insurance',
    ];

    protected $casts = [
        'requirements' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }
}
