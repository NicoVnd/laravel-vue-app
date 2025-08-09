<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        // Récupérer les rédacteurs
        $redacteurs = User::role('redacteur')->get();
        
        if ($redacteurs->isEmpty()) {
            echo "Aucun rédacteur trouvé. Veuillez d'abord exécuter le UserSeeder.\n";
            return;
        }

        $articles = [
            [
                'title' => 'LeBron James bat un nouveau record NBA',
                'content' => '<h1>LeBron James entre dans l\'histoire</h1><p>Salut {{nom_utilisateur}} ! Aujourd\'hui le {{date_lecture}}, nous assistons à un moment historique dans la NBA. LeBron James vient de battre le record de points en carrière, dépassant Kareem Abdul-Jabbar avec ses 38 388 points.</p><p>Cette performance exceptionnelle marque une nouvelle ère dans le basketball professionnel. Les fans du monde entier célèbrent cet exploit remarquable.</p>',
            ],
            [
                'title' => 'Les Warriors remportent leur 7e match consécutif',
                'content' => '<h1>Golden State Warriors en forme</h1><p>Bonjour {{nom_utilisateur}}, en cette date du {{date_lecture}}, les Golden State Warriors continuent leur série impressionnante avec une 7e victoire consécutive.</p><p>Stephen Curry a encore brillé avec 35 points, confirmant son statut de meilleur tireur à 3 points de l\'histoire de la NBA.</p>',
            ],
            [
                'title' => 'Draft NBA 2024 : Les prospects à suivre',
                'content' => '<h1>La Draft NBA approche</h1><p>Cher {{nom_utilisateur}}, alors que nous sommes le {{date_lecture}}, la Draft NBA 2024 se profile à l\'horizon. Plusieurs prospects français sont attendus dans le premier tour.</p><p>Victor Wembanyama reste le favori pour la première position, avec son profil unique de 2m24 et ses qualités techniques exceptionnelles.</p>',
            ],
            [
                'title' => 'Giannis Antetokounmpo mène Milwaukee aux playoffs',
                'content' => '<h1>Le Greek Freak en action</h1><p>Salut {{nom_utilisateur}} ! Ce {{date_lecture}}, Giannis Antetokounmpo a encore démontré pourquoi il est considéré comme l\'un des meilleurs joueurs de la ligue.</p><p>Avec 45 points et 15 rebonds, il a mené les Milwaukee Bucks vers une victoire cruciale pour leur qualification en playoffs.</p>',
            ],
            [
                'title' => 'La rivalité Lakers vs Celtics continue',
                'content' => '<h1>Un classique de la NBA</h1><p>Bonjour {{nom_utilisateur}}, en ce {{date_lecture}}, la rivalité historique entre les Lakers et les Celtics a encore offert un spectacle magnifique.</p><p>Les deux équipes se sont livrées une bataille acharnée, rappelant les grandes heures des années 80 avec Magic Johnson et Larry Bird.</p>',
            ],
            [
                'title' => 'Luka Dončić : Le phénomène slovène',
                'content' => '<h1>Luka Dončić impressionne</h1><p>Cher {{nom_utilisateur}}, aujourd\'hui {{date_lecture}}, Luka Dončić a encore prouvé qu\'il est l\'un des talents les plus prometteurs de sa génération.</p><p>Avec un triple-double à seulement 24 ans, il rejoint des légendes comme Magic Johnson dans les records de précocité.</p>',
            ],
            [
                'title' => 'Les Spurs misent sur la jeunesse',
                'content' => '<h1>San Antonio reconstruit</h1><p>Salut {{nom_utilisateur}} ! Le {{date_lecture}}, les San Antonio Spurs continuent leur reconstruction autour de jeunes talents prometteurs.</p><p>Gregg Popovich, l\'entraîneur légendaire, mise sur le développement de ses rookies pour retrouver les sommets.</p>',
            ],
            [
                'title' => 'Kevin Durant rejoint les Suns',
                'content' => '<h1>KD change d\'équipe</h1><p>Bonjour {{nom_utilisateur}}, en cette date du {{date_lecture}}, Kevin Durant a été transféré aux Phoenix Suns dans un échange majeur.</p><p>Cette arrivée fait des Suns un prétendant sérieux au titre NBA cette saison.</p>',
            ],
            [
                'title' => 'Jayson Tatum mène Boston vers le titre',
                'content' => '<h1>Les Celtics en route vers le titre</h1><p>Cher {{nom_utilisateur}}, aujourd\'hui {{date_lecture}}, Jayson Tatum confirme son statut de superstar avec une performance de 50 points.</p><p>Les Boston Celtics semblent avoir trouvé la formule gagnante pour leur 18e titre NBA.</p>',
            ],
            [
                'title' => 'Joel Embiid domine la peinture',
                'content' => '<h1>The Process continue</h1><p>Salut {{nom_utilisateur}} ! Ce {{date_lecture}}, Joel Embiid a encore dominé la raquette avec 40 points et 20 rebonds.</p><p>Le pivot des Philadelphia 76ers prouve qu\'il est l\'un des meilleurs joueurs intérieurs de la ligue actuelle.</p>',
            ],
            [
                'title' => 'Damian Lillard et ses tirs impossibles',
                'content' => '<h1>Dame Time</h1><p>Bonjour {{nom_utilisateur}}, en ce {{date_lecture}}, Damian Lillard a encore frappé avec un tir à 3 points depuis le logo central.</p><p>Le meneur de Portland continue d\'émerveiller les fans avec ses tirs de très longue distance.</p>',
            ],
            [
                'title' => 'La montée en puissance des Nuggets',
                'content' => '<h1>Denver vise le titre</h1><p>Cher {{nom_utilisateur}}, aujourd\'hui {{date_lecture}}, les Denver Nuggets confirment leurs ambitions avec Nikola Jokić en leader.</p><p>Le pivot serbe, double MVP, guide son équipe vers les sommets de la Conférence Ouest.</p>',
            ],
            [
                'title' => 'Zion Williamson retrouve sa forme',
                'content' => '<h1>Le retour de Zion</h1><p>Salut {{nom_utilisateur}} ! Le {{date_lecture}}, Zion Williamson montre enfin tout son potentiel après ses blessures.</p><p>Avec sa puissance athlétique unique, il redonne espoir aux fans des New Orleans Pelicans.</p>',
            ],
            [
                'title' => 'Ja Morant électrise Memphis',
                'content' => '<h1>L\'explosion de Ja Morant</h1><p>Bonjour {{nom_utilisateur}}, en cette date du {{date_lecture}}, Ja Morant continue d\'impressionner avec ses dunks spectaculaires.</p><p>Le jeune meneur des Memphis Grizzlies apporte un style de jeu électrisant à la NBA.</p>',
            ],
            [
                'title' => 'Les Finals NBA 2024 approchent',
                'content' => '<h1>Direction les Finals</h1><p>Cher {{nom_utilisateur}}, aujourd\'hui {{date_lecture}}, les playoffs NBA touchent à leur fin et les Finals se profilent.</p><p>Deux équipes vont bientôt se disputer le titre suprême dans une série au meilleur des 7 matchs qui promet d\'être épique.</p>',
            ],
        ];

        foreach ($articles as $index => $articleData) {
            $redacteur = $redacteurs->random();
            
            Article::create([
                'title' => $articleData['title'],
                'content' => $articleData['content'],
                'user_id' => $redacteur->id,
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }

        echo "15 articles sur la NBA créés avec succès !\n";
    }
}