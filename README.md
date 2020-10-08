# Provider Paypal & LinkedIn

## Paypal

### Info sur le provider
L'accès à au provider fournis par paypal ce fait avec leur sandbox.

Leur mode bac à sable propose de tester sont applications avant de la déployer. 
Les requêtes sont exactement les même.

Pour se créer un compte sandbox, il faut aller sur l'url : 

https://developer.paypal.com/developer/accounts

Depuis ce compte il est possible de créer une app pour récuperer sont 
client_id et son client_secret. 

On peut également parametrer les infos que 
l'on souhaite recevoir avec le scope depuis l'url : 

https://developer.paypal.com/docs/connect-with-paypal/reference/#scope-attributes

Il faut également parametrer l'url de callback ainsi que l'url de redirection.

Pour tester en local, il est impératif de créer un bind sur l'adresse localhost

 Exemple :
```127.0.0.1       monAdresseDeCallBack.fr``` 

dans le fichiers /etc/hosts sur macos.

Voici un guide complet qui retrace toutes les étapes de l'intégration du providers : https://developer.paypal.com/docs/connect-with-paypal/integrate/#

### Utilisation du code

Commet préciser plus haut, pour utiliser le code tel quel, il faut bind le port 127.0.0.1 sur l'adresse ```monsite.fr```

L'url de callback est également sur le port 7071, donc dans le cas de ce
projet le lien retourné sera ```http://monsite.fr:7071/callback/?.....``` 

Mon application sandbox n'autorise la récupération que des infos de profil (scope : email et profil).

Voici un compte sandbox qui permettra de vérifier l'authent.

```
login : sb-vcyjm2384031@personal.example.com
mot de passe : 7BF=Sp>i
```

## LinkedIn

Cliquer sur le lien. S'authentifier sur Linkedin. Les informations s'affichent dans un tableau.