# ClickClack

Nous sommes en 3e année au CFPT Informatique en développement d’applications et dans le cadre du module M306 nous devons faire un projet en utilisant ce que nous avons appris en cours. Nous avons décidé de créer une application inspirée de Instagram et de Reddit. C’est un réseau social où les utilisateurs pourraient poster des photos avec légende ou non, les liker et discuter entre utilisateurs.

## Fonctionnalité
Voici une liste de toute les fonctionnalités qui seront dans la version final de notre application:
- Inscription/Connection
- Créer des discussions
- Envoyé des messages
- Modifier son profils
- Publications Photos

## Technologie
Voici la liste des technologies:
- Visual studio → **HTML - CSS - PHP**
- PhpMyAdmin → **Base de données**
- Google Docs → **Documentation**
- Google Sheets → **Planification**
- UmLetino → **Diagrammes**
- Github → **Fichiers partagés**


***

## Installation

### 1. Prérequis

- Apache2 installé (WSL / Linux)
- PHP en ligne de commande
- MySQL / MariaDB + phpMyAdmin
- Composer installé (commande `composer` disponible)
- Git installé

***

### 2. Récupérer le projet depuis GitHub

Dans votre WSL, placez-vous dans le dossier web puis clonez le dépôt :

```bash
cd /var/www/html
git clone https://github.com/2Raphael5/ClickClack.git ClickClack
cd ClickClack
```


***

### 3. Configurer le VirtualHost Apache

#### 3.1 Créer le fichier du vhost

Créer le fichier `ClickClack.cfpt.conf` dans `/etc/apache2/sites-available/` :

Ajouter :
```bash
<VirtualHost *:80>
    ServerName ClickClack.cfpt.loc
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/ClickClack/public

    <Directory /var/www/html/ClickClack/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/ClickClack.cfpt.loc-error.log
    CustomLog ${APACHE_LOG_DIR}/ClickClack.cfpt.loc-access.log combined
</VirtualHost>
```


#### 3.2 Activer le module rewrite

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

#### 3.3 Activer le vhost et recharger Apache

```bash
sudo apache2ctl -t # Vérifie la syntaxe ("Syntax OK")
sudo a2ensite ClickClack.cfpt.conf
sudo service apache2 reload
```

#### 3.4 Modifier le fichier *hosts* (Windows)

Éditer en administrateur :

```bash
C:\Windows\System32\drivers\etc
```
Ouvrez le fichier nommer `hosts`.

Ajouter à la fin :
```text
127.0.0.1   ClickClack.cfpt.loc
::1         ClickClack.cfpt.loc
```

Vous pourrez y accéder via :
```text
http://ClickClack.cfpt.loc
```

***

### 4. Installer les dépendances Composer

Dans le dossier du projet :

```bash
cd /var/www/html/ClickClack
composer install
```

Composer va lire le `composer.json` :

```json
{
    "name": "clickclack/clickclack",
    "description": "\"Un projet fait par Alan, Julien et Raphaël\"",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "ClickClack\\ClickClack\\": "src/"
        }
    },
    "authors": [
        {
            "name": "Your Name",
            "email": "you@example.com"
        }
    ],
    "minimum-stability": "stable",
    "require": {
        "slim/slim": "^4.0",
        "slim/psr7": "^1.8",
        "nyholm/psr7": "^1.8",
        "nyholm/psr7-server": "^1.1",
        "guzzlehttp/psr7": "^2",
        "laminas/laminas-diactoros": "^3.8",
        "slim/php-view": "^3.4"
    }
}
```

***

### 5. Générer l’autoload

Après l’installation des dépendances, regénérez l’autoload :

```bash
composer dump-autoload
```

***
## Configurer la base de données 

1. Importez le fichier `init.sql` fourni dans phpMyAdmin.
2. Copier le fichier `dataSample.php`, renommer le en `data.php` pour y modifier les valeurs suivante :
    - hôte (`DB_HOST`)
    - nom de base (`DB_NAME`)
    - utilisateur (`DB_USER`)
    - mot de passe (`DB_PASSWORD`)

