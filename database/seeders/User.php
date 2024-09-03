<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User as ModelsUser;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ModelsUser::create([
            'company_id' => 1,
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'remember_token' => null,
            'role' => 'super',
            'created_at' => date("Y-m-d H:i:s")
        ]);

    }
}
