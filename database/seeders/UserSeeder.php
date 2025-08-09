<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Rédacteurs
        $redacteurs = [
            [
                'name' => 'Nicolas',
                'email' => 'nicolas@redacteur.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'William',
                'email' => 'william@redacteur.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Benjamin',
                'email' => 'benjamin@redacteur.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Patrick',
                'email' => 'patrick@redacteur.xyz',
                'password' => Hash::make('password123'),
            ],
        ];

        // Utilisateurs normaux
        $users = [
            [
                'name' => 'Marie Dupont',
                'email' => 'marie@user.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jean Martin',
                'email' => 'jean@user.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie@user.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Lucas Moreau',
                'email' => 'lucas@user.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Emma Leroy',
                'email' => 'emma@user.xyz',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Thomas Petit',
                'email' => 'thomas@user.xyz',
                'password' => Hash::make('password123'),
            ],
        ];

        // Créer les rédacteurs
        foreach ($redacteurs as $redacteurData) {
            $redacteur = User::create($redacteurData);
            $redacteur->assignRole('redacteur');
        }

        // Créer les utilisateurs normaux
        foreach ($users as $userData) {
            $user = User::create($userData);
            $user->assignRole('user');
        }

        echo "Utilisateurs créés :\n";
        echo "Rédacteurs :\n";
        foreach ($redacteurs as $redacteur) {
            echo "- {$redacteur['email']} (mot de passe: password123) - Rôle: rédacteur\n";
        }
        echo "\nUtilisateurs :\n";
        foreach ($users as $user) {
            echo "- {$user['email']} (mot de passe: password123) - Rôle: user\n";
        }
    }
}