# P8-ToDoAndCo

Amélioration et documentation d'un projet existant ToDo & Co.

## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu:
```
    git clone https://github.com/sam-johnny/ToDo-Co.git
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier `.env.local` qui devra être crée à la racine du projet en réalisant une copie du fichier `.env` ainsi que la connexion à la base de données de test dans le fichier `env.test`.

3. Téléchargez et installez les dépendances du projet avec [Composer](https://getcomposer.org/download/):
```
    composer install
```
4. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet:
```
    php bin/console doctrine:database:create
```
5. Créez les différentes tables de la base de données en appliquant les migrations:
```
    php bin/console doctrine:migrations:migrate
```
6. (Optionnel) Installez les fixtures pour avoir une démo de données fictives en développement:
```
    php bin/console doctrine:fixtures:load --env=dev
```
7. Décommentez la partie du code suivant:
```
     // config/services.yaml
    App\EventListener\UserListener:
        tags:
            - { name: doctrine.event_listener, event: prePersist }
```
8. Identifiants pour tester l'application
```
    >Role_Admin
    username: user11
    password: password
    
    >Role_User
    username: user1
    password: password
```
8. Félicitations le projet est installé correctement, vous pouvez désormais commencer à l'utiliser à votre guise!

