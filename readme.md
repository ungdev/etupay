# EtuPay

EtuPay est la plateforme de paiement associative de l'UTT. Développé en 2016 pour les besoins d'inscription au WEI automatisé avec le site de l'intégration, il s'agit plus globallement  d'une palteforme monétique (style paypal ...) permettant aux associations/club ... de proposer aux utilisateurs un système de paiment sécurisé pour leurs sites internet tout en laissant la main à la trésorerie BDE.

Permet la gestion des transactions direct ainsi que des cautions bancaire (dépend des providers).

## Utilisation

Un site s'ajoute via la cli et permet d'obtenir le service_id et la clé api nécessaire à la communication avec l'API. Chaque site doit être affilié à une fondation qui reçoit l'argent.

### Ajout d'une fondation
```
php artisan fundations:create
```
Il vous sera demandé un nom de fondation et une adresse email.


### Ajout d'un site
Une fois la fondation créée, ou si elle existe déjà, vous pouvez créer un nouveau site :
```
php artisan services:create
```
Il vous sera demandé l'ID de la fondation (montré à la demande), l'adresse du serveur, l'URL de retour et l'URL de callback.

### Lister les services et récupérer les clés d'API
```
php artisan services:list
```
Vous pouvez utiliser `--key` pour montrer les clés d'API

### Site en mode dev

Le mode dev permet de tester l'intégration d'un site avec etupay. Pour l'instant, le seul moyen de passer un service en mode dev est de passer par la base de données directement.

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
