# Installation 

Pour installer le projet il vous suffit de le cloner dans votre projet initial et de configurer git avec le projet. (Pour PhpStorm File -> Settings -> Version Control)

>\* Avant d'utiliser l'API veillez à inclure le fichier boot.php dans votre index 

### Configuration :

Un fichier ``conf.inc.php`` est livré à la racine du projet. Vous **devez**  configurer les options suivantes :
- ``PORTFOLIO_ID`` Doit être configuré avec votre identifiant SEYNA
- ``SEYNA_URL`` Doit correspondre à l'URL SEYNA sur laquelle vous pouvez faire vos appels
- ``IS_DEV`` Doit être mis à ``false`` en production et ``true`` en développement  

_La constance ``SDK_ROOT`` peut elle aussi être modifiée en fonction de votre installation_
   
# Utilisation

### Avant propos : 
Les classes du dossier helpers sont la pour simplifier l'utilisation du SDK mais ne remplacent pas toutes les fonctionnalitées
disponibles dans les objets. Des fonctions statiques seront ajoutées au fur et à mesure dans les manager.   

### Logs :
Un système de logs est disponible pour le projet. Il est accessible via la classe Dbg et propose différents niveaux d'importance
pour chaque message. Les logs sont écrites dans le dossier ``/data/logs/<année>/<mois>/<jour>.txt``
>\* Les droits d'écriture pour l'utilisateur *www-data* doivent être appliqués sur le dossier **/data**.

### Liste des objets :
Les objets fournis dans le SDK sont les suivants:
`Claim`, `Contract`, `Entity`, `Guarantee`, `Receipt`, `Request`, `Settlement`, `Splitting`. Les autres objets du projet ne sont que des utilitaires
pour le bon fonctionnement de ceux si. 

### Manipulation des objets : 
Pour créer un objet deux options sont possibles, la première utiliser les classes manager et leur fonctions `createObject`, la seconde est 
d'instancier un objet avec une array associative contenant toutes ses variables puis d'appeler sa méthode `putObject`. Exemple d'instanciation d'un objet Claim: 
```php
<?php
ClaimManager::createClaim(
    "contract-test",
    $contract,
    "occurence",
    "location",
    "notification",
    "revaluation_reason",
    $guarantees
);
```
Et avec la deuxième méthode: 
```php
<?php
$claim = new Claim([
    'id' => $id,
    'contract' => $contract->id,
    'occurence' => $occurence,
    'location' => $location,
    'notification' => $notification,
    'revaluation_reason' => $reason,
    'guarantees' => $guarantees
]);
$claim->putClaim();
```

>\* Attention, procéder de cette manière est déconseillée car certains champs ont une syntaxe spéciale lors de l'envoi (notamment les champs contracts qui varient selon les objets)