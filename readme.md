# EtuPay

EtuPay est la plateforme de paiement associative de l'UTT. Développé en 2016 pour les besoins d'inscription au WEI automatisé avec le site de l'intégration, il s'agit plus globallement  d'une palteforme monétique (style paypal ...) permettant aux associations/club ... de proposer aux utilisateurs un système de paiment sécurisé pour leurs sites internet tout en laissant la main à la trésorerie BDE.

Permet la gestion des transactions direct ainsi que des cautions bancaire (dépend des providers).

## Ajout d'un site

Un site s'ajoute via la cli et permet d'obtenir le service_id et la clé api nécessaire à la communication avec l'API.
1 - Création d'une fondation (ex: association)
2 - Création d'un service 

## Déploiement d'Etupay

Afin de déployer Etupay, il est nécessaire de lancer deux conteneur Etupay :
- le premier conteneur sera celui utilisé pour recevoir les requêtes des clients (site web souhaitant renvoyer leur utilisateur vers Etupay afin de procéder à une transaction), il devra bénéficier d'un accès à la base de donnée d'Etupay, et le serveur Apache devra y être lancé
- le second conteneur sera celui chargé de renvoyer une réponse aux clients, ainsi, il devra avoir accès à la base de données de Etupay, et la commande suivante `./artisan queue:work --tries=30 --delay=30` devra être exécuté au lancement du conteneur. Cette commande permet au conteneur d'exécuter les scripts `App/Job` renseignés dans la base de données d'Etupay.

## Provider bancaire implémenté
- Atos (LCL etc ...)
- Payline
- Paypal
- Dev (mode test, permettant aux devs de vérifier le bon fonctionnement)

## Lib client
- NodeJS: https://github.com/ungdev/node-etupay

## Techno
 - PHP Framework: Laravel 5.8

 ## Crédits / Contact
 - Christian d'Autume (christian@dautume.fr)

 ## Licence
GNU General Public License v3.0
