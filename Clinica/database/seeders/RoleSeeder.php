<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'admin',
                'description' => 'Administrador del sistema'
            ],
            [
                'name' => 'dentista',
                'description' => 'Especialista en odontología'
            ],
            [
                'name' => 'clinico',
                'description' => 'Médico clínico general'
            ],
        ]);
    }
}
