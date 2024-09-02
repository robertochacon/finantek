<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Companies as ModelsCompanies;

class Companies extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsCompanies::create([
            'full_name' => 'Finantek',
            'short_name' => 'Finantek',
            'rnc' => '000000000',
            'website' => null,
            'phone' => null,
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
