<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Créer les rôles s'ils n'existent pas déjà
        if (!Role::where('name', 'user')->exists()) {
            Role::create(['name' => 'user']);
        }
        
        if (!Role::where('name', 'redacteur')->exists()) {
            Role::create(['name' => 'redacteur']);
        }
    }
}