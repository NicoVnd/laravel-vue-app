<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Créer un utilisateur avec le rôle "user"
        $user = User::create([
            'name' => 'Utilisateur Test',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole('user');

        // Créer un utilisateur avec le rôle "rédacteur"
        $redacteur = User::create([
            'name' => 'Rédacteur Test',
            'email' => 'redacteur@test.com',
            'password' => Hash::make('password123'),
        ]);
        $redacteur->assignRole('redacteur');

        echo "Utilisateurs créés :\n";
        echo "- user@test.com (mot de passe: password123) - Rôle: user\n";
        echo "- redacteur@test.com (mot de passe: password123) - Rôle: rédacteur\n";
    }
}