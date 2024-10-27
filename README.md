## Fonctionnalités
- **Prestataires** :
  - `GET /providers` : Récupérer la liste des prestataires.
  - `POST /providers` : Ajouter un nouveau prestataire.
  - `PUT /providers/{id}` : Modifier un prestataire.
  - `DELETE /providers/{id}` : Supprimer un prestataire.
  
- **Services** :
  - `GET /services` : Récupérer la liste des services proposés.
  - `POST /services` : Ajouter un nouveau service.
  - `PUT /services/{id}` : Modifier un service.
  - `DELETE /services/{id}` : Supprimer un service.

## Installation

### Pré-requis
- PHP 8.3+
- Composer
- Docker
- Git

12-Factor App : 
Base de Code Unique (One Codebase) :

Un seul dépôt Git est utilisé pour gérer l'intégralité de l'application.
J'ai créé un dépôt GitHub pour ton projet Symfony et je gère tout depuis ce dépôt.
Dépendances Explicites (Dependencies) :

Toutes les dépendances de l'application doivent être clairement définies dans un fichier comme composer.json.
J'ai utilisé Composer pour gérer toutes les dépendances de mon projet Symfony (comme Twig, Doctrine, etc.), et elles sont isolées dans le dossier vendor/.

Configuration via Environnement (Config) :

Toutes les configurations spécifiques à l'environnement (comme la base de données ou les services externes) doivent être gérées via des variables d'environnement (fichier .env).
J'ai configuré ta base de données MySQL, Redis, et le service de messagerie Mailtrap dans un fichier .env.local, en évitant d'exposer des informations sensibles dans le code source.

Services de Soutien (Backing Services) :

Les services comme les bases de données ou les services de messagerie doivent être considérés comme des ressources externes.
J'ai configuré MySQL, Redis, et un service de messagerie (Mailtrap) comme des services de soutien dans Docker et via les variables d'environnement.

Build, Release, Run :

Le processus de déploiement doit être divisé en trois étapes distinctes : build (compilation), release (publication), et run (exécution).
Grâce à Docker et à Composer, J'ai préparé le projet pour la production en installant les dépendances, configuré les conteneurs Docker pour MySQL et Redis, et lancé ton application Symfony.

Processus Stateless (Processes) :

L'application doit être composée de processus stateless, ce qui signifie que chaque instance doit être autonome et indépendante.
 Symfony est indépendante des autres services comme MySQL et Redis, qui sont des services de soutien externes. Les données sont stockées dans la base de données ou mises en cache dans Redis, pas dans l'application elle-même.

Liaison des Ports (Port Binding) :

L'application doit s'exécuter sur son propre port et être accessible via des requêtes HTTP.
Avec Docker, j'ai mappé le port 8000 pour que Symfony soit accessible via http://localhost:8000.

Concurrence (Concurrency) :

L'application doit pouvoir gérer plusieurs processus en parallèle pour être scalable.
Grâce à Symfony et à Docker, l'application est prête à gérer plusieurs requêtes et processus en parallèle via les serveurs web et les connexions à la base de données.

Disposabilité (Disposability) :

Les processus doivent être facilement démarrés ou arrêtés pour permettre un déploiement rapide.
Avec Docker, je peux facilement redémarrer tes services (MySQL, Redis, Symfony) sans affecter l'état de l'application. J'ai également utilisé des commandes Symfony pour gérer les migrations et le cache.

Parité Dév/Prod (Dev/Prod Parity) :

L'environnement de développement doit être aussi proche que possible de l'environnement de production.
Grâce à Docker, J'ai créé un environnement de développement qui reflète parfaitement l'environnement de production (mêmes services, mêmes configurations), assurant ainsi que ce qui fonctionne en développement fonctionnera en production.

Logs (Logs) :
Les logs doivent être considérés comme des flux d'événements, envoyés à stdout pour être centralisés et gérés.
J'ai configuré Monolog pour envoyer les logs vers stdout, permettant à Docker de centraliser ces logs et de les gérer facilement.

Tâches Administratives (Admin Processes) :
Les tâches administratives, comme les migrations de base de données ou le nettoyage du cache, doivent être effectuées avec des commandes distinctes.
J'ai créé des commandes Symfony pour gérer des tâches comme les migrations ou le nettoyage du cache, séparant ainsi les tâches administratives du flux principal de l'application.
