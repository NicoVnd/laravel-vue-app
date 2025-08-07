Bonjour,

Merci pour votre candidature. Afin de mieux évaluer vos compétences techniques, nous vous proposons de réaliser le test pratique suivant.

🧩 Contexte du projet
Nous développons une plateforme de rédaction d’articles de blog intégrant les fonctionnalités suivantes :

Un éditeur WYSIWYG (What You See Is What You Get) pour rédiger les articles

L’insertion de variables dynamiques dans le contenu (ex : nom de l’utilisateur, date, etc.)

Une personnalisation du contenu selon l’utilisateur connecté

Exemple d’usage :
L'auteur écrit :
"Bonjour {{nom_utilisateur}}, voici mon nouvel article sur..."

Le lecteur Pierre verra :
"Bonjour Pierre, voici mon nouvel article sur..."

🛠️ Instructions techniques
Technologies attendues :

Frontend : HTML, CSS, JavaScript  =>  Vue.js

Backend : Laravel (PHP)

Livrables :

Le code source complet du projet

Un fichier README.md expliquant :

Comment installer et exécuter votre projet

Les principales fonctionnalités implémentées

🧑‍💻 À réaliser
1. Éditeur d’article (WYSIWYG)
Créez une interface d’édition avec les fonctionnalités suivantes :

Fonctionnalités de base :

Zone d’édition de texte enrichi

Boutons de mise en forme : Gras, Italique, Souligné

Insertion de liens

Fonctionnalité spéciale : Variables dynamiques

Ajoutez un bouton "Insérer une variable" qui affiche un menu déroulant avec :

{{nom_utilisateur}} → nom du lecteur

{{date_lecture}} → date du jour

Les variables insérées doivent être visuellement distinctes (ex : couleur différente)

Interface attendue (exemple) :



[Gras] [Italique] [Souligné] [Liste] [Lien] [Variables ▼]

┌────────────────────────────────────────────┐
│       LE CONTENU DE L'ARTICLE              │
└────────────────────────────────────────────┘

[ Sauvegarder ]

2. Moteur d’injection de variables
Créer une variable 

var data  = {
      nom_utilisateur: 'Pierre',
}
Implémentez un système qui remplace automatiquement les variables par les informations enregistrées dans la variable data 

pour cet exemple Bonjour {{nom_utilisateur}} va être remplacé par Bonjour Pierre 

3. Structure du projet Laravel attendue (3 pages)

Page d’accueil : affichage de la liste des articles (design libre : tableau, cartes, etc.)

Page de lecture d’un article : affiche le contenu final avec les variables injectées + un bouton "Modifier" pour modifier l'article

Page de création d’un article : formulaire avec l’éditeur WYSIWYG

📦 Livraison
Dépôt du projet sur GitHub

Merci de nous transmettre le lien du dépôt

Date limite de rendu: 7 jours 


N’hésitez pas à nous contacter si vous avez des questions.
Bonne chance ! 🚀