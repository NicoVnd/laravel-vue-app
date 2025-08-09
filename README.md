# 📰 Plateforme de Rédaction d’Articles

Une application Laravel + Vue.js permettant la création, la modification et la lecture d’articles de blog avec **insertion de variables dynamiques** (personnalisation du contenu pour chaque utilisateur).

---

## 🚀 Fonctionnalités

### 🔹 Éditeur WYSIWYG
- Mise en forme : **gras**, *italique*, _souligné_
- Insertion de liens
- Menu pour insérer des **variables dynamiques** :
  - `{{nom_utilisateur}}` → remplacé par le nom du lecteur
  - `{{date_lecture}}` → remplacé par la date du jour
- Les variables sont affichées dans une couleur distincte pour les reconnaître facilement.

### 🔹 Gestion des articles
- **Page d’accueil** : liste des articles (design libre)
- **Page de lecture** : contenu affiché avec les variables remplacées
- **Page de création/modification** : éditeur WYSIWYG pour rédiger les articles

### 🔹 Personnalisation du contenu
Lorsqu’un utilisateur lit un article :
- `{{nom_utilisateur}}` → remplacé par son prénom/nom
- `{{date_lecture}}` → remplacé par la date du jour

---

## 👥 Comptes de démonstration

### ✏️ Rédacteurs (création & modification d’articles)
| Nom       | Email                       | Mot de passe   |
|-----------|-----------------------------|----------------|
| Nicolas   | nicolas@redacteur.xyz       | password123    |
| William   | william@redacteur.xyz       | password123    |
| Benjamin  | benjamin@redacteur.xyz      | password123    |
| Patrick   | patrick@redacteur.xyz       | password123    |

### 👤 Utilisateurs classiques (lecture uniquement)
| Nom            | Email                  | Mot de passe   |
|----------------|------------------------|----------------|
| Marie Dupont   | marie@user.xyz         | password123    |
| Jean Martin    | jean@user.xyz          | password123    |
| Sophie Bernard | sophie@user.xyz        | password123    |
| Lucas Moreau   | lucas@user.xyz         | password123    |
| Emma Leroy     | emma@user.xyz          | password123    |
| Thomas Petit   | thomas@user.xyz        | password123    |

---

## 📦 Installation

### 1️⃣ Cloner le projet
```bash
git clone https://github.com/NicoVnd/laravel-vue-app
cd laravel-vue-app
```

### 2️⃣ Installer les dépendances
```bash
composer install
npm install
```

### 3️⃣ Configurer les variables d'environnement
```bash
cp .env.example .env
```
Puis configurer :
La connexion à la base de données (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_la_base
DB_USERNAME=utilisateur
DB_PASSWORD=mot_de_passe
```

### 4️⃣ Générer la clé de l'application
```bash
php artisan key:generate
```

### 5️⃣ Lancer les migrations et insérer les comptes de test
```bash
php artisan migrate --seed
```

### 6️⃣ Lancer le serveur de développement backend
```bash
php artisan serve
```
### 7️⃣ Lancer le serveur de développement frontend
```bash
npm run dev
```

---

### 🛠 Technologies utilisées

- **Backend** : Laravel (PHP)
- **Frontend** : Vue.js (JavaScript)
- **CSS** : TailwindCSS
- **Base de données** : MySQL
- **Éditeur** : Quill.js (WYSIWYG)

### 🖼 Aperçu des pages

**Accueil** → Liste des articles

**Lecture** → Contenu avec variables remplacées

**Création** → Éditeur WYSIWYG avec insertion de variables

**⚠️ Avertissement**
Ce projet a été développé dans le cadre d'un test technique. Il n'est pas destiné à être utilisé en production.








