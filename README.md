# SlowRush-todolist
🗂️ SlowRush

**TodoList – Productivité Tranquille** ✅

📝 **À propos**

**SlowRush** est une application web de gestion de tâches (TodoList) simple, efficace et moderne.
Elle permet d’ajouter, d’organiser, de modifier, de supprimer et de suivre vos tâches au quotidien avec une interface claire et intuitive.
Les données sont stockées de manière sécurisée dans une base de données **MySQL**, garantissant la persistance et la fiabilité de vos données.

🖼️ **Aperçu de l’application**
![Aperçu de SlowRush](sl.JPG)
![Aperçu de l'ajout d'une tache](ai.png)

📊 **Tableau de bord**  
Le tableau de bord permet de :

**Visualiser** toutes vos tâches dans un tableau structuré.
**Trier** les tâches par date ou par titre (sans recharger la page).
**Filtrer** (à venir) les tâches par catégorie ou statut.
**Suivre** l’avancement de vos projets via un diagramme de Gantt (import possible).


➕ **Ajout d’une tâche**  
Une page dédiée (ajout.html) permet de créer une nouvelle tâche en renseignant :

📌 **Titre** : Nom de la tâche.
📝 **Description** : Détails de la tâche.
⚡ **Priorité** : Faible importance, Priorité moyenne, Primordiale, Capitale.
📅 **Date** : Date de début ou d’échéance.
⏳ **Durée** : Durée estimée en jours.
🔄 **État** : COMMENCE, EN COURS, TERMINER.

⚙️ **Fonctionnalités**
✅ Implémentées
| Fonctionnalité | Description |
| --- | --- |
| Ajout de tâches | Formulaire intuitif avec validation des champs. |
| Affichage dynamique | Tableau mis à jour automatiquement après chaque action. |
| Modification des tâches | Édition complète de tous les champs (titre, description, priorité, etc.). |
| Suppression des tâches | Avec confirmation avant suppression. |
| Marquer comme terminée | Bouton dédié avec indicateur visuel (✅ Terminée / ❌ Non terminée). |
| Tri des tâches | Par date (bubble sort) ou par titre (selection sort). |
| Stockage sécurisé | Base de données MySQL avec requêtes préparées (PDO). |
| Validation des données | Côté client (JavaScript) et côté serveur (PHP). |
| Gestion des erreurs | Messages clairs et codes HTTP appropriés. |

🧱 **Structure du projet**

SlowRush/
├── CSS/
│   ├── slow.css           # Styles pour la page principale
│   └── AJ.css             # Styles pour la page d'ajout
├── DATA/
│   └── DB.sql             # Script SQL pour la base de données
├── HTML/
│   ├── Slowrush.html      # Page principale (liste des tâches)
│   └── ajout.html         # Formulaire d'ajout de tâche
├── JS/
│   ├── slow.js            # Logique pour la page principale
│   └── aj.js              # Logique pour l'ajout de tâche
├── PHP/
│   ├── back.php           # Configuration de la connexion MySQL
│   ├── db.php             # Ajout d'une tâche en base de données
│   ├── aJ.php             # Récupération de toutes les tâches
│   ├── delete_task.php    # Suppression d'une tâche
│   ├── update_task.php    # Mise à jour d'une tâche
│   ├── get_task.php       # Récupération d'une tâche spécifique
│   └── toggle_task.php    # Basculer le statut "terminée"
├── README.md
└── LICENSE


💻 **Technologies utilisées**
| Technologie | Version | Utilisation |
| --- | --- | --- |
| HTML5 | - | Structure des pages |
| CSS3 | - | Styles et mise en page |
| JavaScript (Vanilla) | ES6+ | Logique côté client |
| PHP | 7.4+ | Backend et interaction avec MySQL |
| MySQL | 5.7+ | Stockage des données |

🛠️ Installation
📋 Prérequis
Avant de commencer, assurez-vous d’avoir les éléments suivants installés sur votre machine :
| Outil | Version | Lien |
| --- | --- | --- |
| Serveur web | Apache/Nginx | [Apache](https://httpd.apache.org/), [Nginx](https://www.nginx.com/) |
| PHP | 7.4+ | [php.net](https://www.php.net/) |
| MySQL | 5.7+ | [MySQL](https://www.mysql.com/) |
| Navigateur | Dernière version | Chrome, Firefox, Edge, Safari |
💡 Pour les débutants :
Utilisez XAMPP (Windows) ou WAMP pour une installation clé en main.


🚀 Étapes d’installation
1️⃣ Cloner ou télécharger le projet
git clone https://github.com/MathisDev-mp/SlowRush.git
Ou téléchargez le dépôt sous forme de fichier ZIP et extrayez-le.

2️⃣ Configurer la base de données


Créer la base de données :

Ouvrez phpMyAdmin (via http://localhost/phpmyadmin) ou utilisez la ligne de commande MySQL.
Exécutez le script DATA/DB.sql pour créer la base de données slowrush et la table taches :
mysql -u root -p slowrush < DATA/DB.sql
(Remplacez root par votre utilisateur MySQL si nécessaire)


Vérifier la structure :

Exécutez cette requête pour confirmer que la table est bien créée :
DESCRIBE slowrush.taches;

La table doit contenir les colonnes suivantes :

id (INT, PRIMARY KEY, AUTO_INCREMENT)
titre (VARCHAR)
description (TEXT)
priorite (VARCHAR)
date (DATE)
duree (INT)
etat (VARCHAR)
terminee (BOOLEAN, DEFAULT FALSE)

(Recommandé) Créer un utilisateur MySQL dédié :
CREATE USER 'slowrush_user'@'localhost' IDENTIFIED BY 'votre_mot_de_passe';
GRANT ALL PRIVILEGES ON slowrush.* TO 'slowrush_user'@'localhost';
FLUSH PRIVILEGES;

Puis mettez à jour les identifiants dans PHP/back.php :
$user = "slowrush_user";
$pass = "votre_mot_de_passe";

3️⃣ Configurer le serveur web


Placer les fichiers :

Copiez le dossier SlowRush dans le répertoire racine de votre serveur web.

XAMPP/WAMP : C:\xampp\htdocs\SlowRush (Windows) ou /var/www/html/SlowRush (Linux)
Hébergement web : Dans le dossier public_html ou www



Vérifier les permissions :

Assurez-vous que le serveur web (Apache/Nginx) a les droits de lecture/écriture sur les fichiers PHP.
Sous Linux :
sudo chmod -R 755 /var/www/html/SlowRush/

Démarrer le serveur :

XAMPP/WAMP : Lancez Apache et MySQL via le panneau de contrôle.
Serveur local :
sudo service apache2 start
sudo service mysql start

4️⃣ Accéder à l’application


Ouvrez votre navigateur web.


Accédez à l’URL suivante :
http://localhost/SlowRush/HTML/Slowrush.html
(Ajustez l’URL selon votre configuration serveur)

Tester l’application :
Cliquez sur "AJOUTER UNE TACHE" pour créer une nouvelle tâche.
Vérifiez que la tâche apparaît dans le tableau.
Testez les fonctionnalités :

✅ Marquer comme terminée (bouton vert/rouge)
✏️ Modifier une tâche
🗑️ Supprimer une tâche
📅 Trier par date/titre

⚠️ **Dépannage**

| Problème | Cause possible | Solution |
| --- | --- | --- |
| Page blanche | PHP non activé | Vérifiez que PHP est installé (php -v). Activez-le dans Apache (sudo a2enmod php). |
| Erreur de connexion à MySQL | Identifiants incorrects | Vérifiez PHP/back.php. Testez la connexion : mysql -u root -p. |
| Les tâches ne s’affichent pas | Table vide ou erreur SQL | Exécutez : SELECT * FROM slowrush.taches;. |
| Erreur 404 sur les fichiers PHP | Chemin incorrect | Vérifiez les chemins dans slow.js (ex: ../PHP/aJ.php). |
| Les modifications ne sont pas sauvegardées | Permissions insuffisantes | sudo chmod -R 755 /chemin/vers/SlowRush/PHP/. |
| Erreur "Access denied" MySQL | Utilisateur non autorisé | Créez un utilisateur dédié (voir étape 2.3). |

🚀 **Améliorations futures**
Voici les fonctionnalités avancées prévues pour les prochaines versions de SlowRush, classées par priorité et complexité :
| Fonctionnalité | Description | Priorité | Complexité | Technologies |
| --- | --- | --- | --- | --- |
| 🔐 Authentification des utilisateurs | Système de connexion/déconnexion avec gestion des sessions. Chaque utilisateur verra uniquement ses propres tâches. | ⭐⭐⭐⭐ | Moyenne | PHP (sessions), MySQL |
| 🗂️ Catégories et filtres | Classer les tâches par catégories (ex: Travail, Personnel, Études) et filtrer par catégorie/état/priorité. | ⭐⭐⭐ | Moyenne | MySQL, JavaScript |
| 📱 Interface responsive | Adaptation de l’interface pour les smartphones et tablettes (media queries CSS). | ⭐⭐⭐ | Facile | CSS3 |
| 📊 Diagramme de Gantt automatique | Génération automatique d’un diagramme de Gantt à partir des tâches (intégration de [Frappe Gantt](https://frappe.io/gantt)). | ⭐⭐⭐ | Moyenne | JavaScript (Frappe Gantt) |
| 🔄 Synchronisation en temps réel | Mise à jour automatique du tableau lors de l’ajout/modification/suppression d’une tâche (sans recharger la page). | ⭐⭐ | Avancée | WebSockets (PHP + JavaScript) |
| 📅 Rappels et notifications | Notifications par email ou dans le navigateur pour les échéances de tâches. | ⭐⭐ | Moyenne | PHP (PHPMailer), JavaScript |
| 👥 Collaboration | Partager des tâches avec d’autres utilisateurs (pour les projets d’équipe). | ⭐ | Avancée | PHP, MySQL |
| 📤 Export/Import | Exporter les tâches au format CSV, JSON ou Excel et les importer depuis ces formats. | ⭐⭐ | Facile | PHP, JavaScript |
| 🌓 Mode sombre | Thème sombre pour une utilisation de nuit. | ⭐ | Facile | CSS3 |
| 🔍 Recherche | Barre de recherche pour filtrer les tâches par mot-clé. | ⭐⭐ | Facile | JavaScript |

👤 **Auteur**
📧 Email : mathis.mpouamze@example.com
🌐 GitHub : @MathisDev-mp
💼 Portfolio : mathisdev-mp.github.io

📄 **Licence**
Ce projet est sous licence MIT.

✅ Vous êtes libre de :

Utiliser ce projet pour un usage personnel ou commercial.
Modifier le code source.
Distribuer des copies du projet.
⚠️ Sous réserve de :

Conserver la notice de copyright (ce README et la licence).
Ne pas tenir l’auteur responsable de tout dommage ou problème lié à l’utilisation de ce projet.

💬 Contribuer
Les contributions sont les bienvenues !
Ouvrez une Pull Request ou signalez un bug via les Issues GitHub.

⭐ Merci d’utiliser SlowRush ! 🚀
Gérez vos tâches avec sérénité. 🌿
