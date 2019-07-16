**Installation** 

- SQL :

```
CREATE TABLE `seyna_requests` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uri` varchar(255) NOT NULL,
    `method` varchar(255) NOT NULL,
    `httpStatus` varchar(255) NOT NULL,
    `response` text NOT NULL,
    `body` text NOT NULL,
    `error` varchar(255) NOT NULL,
    `stamp` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
```

>\* Les droits d'écriture pour l'utilisateur *www-data* doivent être appliqués sur le dossier **/data**.
   
**Utilisation**

- Avant propos : 
Les classes du dossier api sont la pour simplifier l'utilisation du SDK mais ne remplacent pas toutes les fonctionnalitées
disponibles dans les objets. Des fonctions statiques seront ajoutées au fur et à mesure dans les manager.   

- Liste des objets :
Les objets fournis dans le SDK sont les suivants:
`Claim`, `Contract`, `Entity`, `Guarantee`, `Receipt`, `Request`, `Settlement`, `Splitting`. Les autres objets du projet ne sont que des utilitaires
pour le bon fonctionnement de ceux si. 

- Manipulation des objets : 
Pour créer un objet deux options sont possibles, la première utiliser les classes manager et leur fonctions `createObject`, la seconde est 
d'instancier un objet avec une array associative contenant toutes ses variables puis d'appeler sa méthode `putObject`. Exemple d'instanciation d'un objet Claim: 
```php
<?php
ClaimManager::createClaim("contract-test", $contract, "occurence",
 "location", "notification", "revaluation_reason", $guarantees);
```
Et avec la deuxième méthode: 
```php
<?php
$claim = new Claim(['id' => $id, 'contract' => $contract-id, 'occurence' => $occurence,
 'location' => $location, 'notification' => $notification,
 'revaluation_reason' => $reason, 'guarantees' => $guarantees]);
$claim->putClaim();
```

Attention, procéder de cette manière est déconseillée car certains champs ont une syntaxe spéciale lors de l'envoi (notement les champs contracts qui varient selon les objets). 