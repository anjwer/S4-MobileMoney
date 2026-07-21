# Version 1

## initalisation ci
- [x] mettre le squelette dans le projet (jo)
- [x] arranger les configs (jo)

## base (anjara)
- [x] conception base 
- [x] initialisation sqlite 
    - [x] creation des migrations 
    - [x] creation des seeders

## model (anjara)
- [x] creation des models 

## template 

## cote operateur (jo)
 ### Configuration 
- [x] Gestion des Préfixes :
    - [x] ajouter/supprimer/lister préfixes autorisés (033, 034, 037, etc.).
- [x] Gestion des Barèmes de frais :
    - [x] page liste des frais(frais.php)

###  Dashboard opérateur
- [x] Situation des gains :
    - [x] Calcul total frais récoltés
    - [x] Afficher résumé par type d'opération 

- [x] Situation des comptes clients :
    - [x] Afficher liste numéros avec solde.
    - [x] filtre par numéro de téléphone.

### Logique métier (Controller CI4)
- [x] Middleware/Filter (Optionnel) :
    - [x] Vérification admin 



### view
- [x] operator/dashboard.php
- [x] operator/frais.php
- [x] operator/prefixes.php
- [x] admin/login.php

### controler 
- [x] Dashboard.php
- [x] Frais.php
- [x] Prefixe.php
- [x] AdminAuth.php

## cote client - operations (anjara)
### - [x] voir le solde
VUE : 
    - [x] affichage du solde actuel

FONCTIONS :
    - [x] recuperer la vue d'affichage de solde

### - [x] faire un depot 
VUE : 
    - [x] formulaire de depot 

FONCTIONS : 
    - [x] fonction qui insere dans transaction "DEBIT"

### - [x] faire un transfert 
VUE : 
    - [x] formulaire de transfert 

FONCTIONS :
    - [x] fonction de transaction
    - [x] inserer "DEBIT"
    - [x] inserer "CREDIT"


### - [x] historique 
VUE : 
    - [x] tableau qui liste tous les historiques

FONCTIONS :
    - [x] recup par id client


# Version 2
## cote client (anjara)
VUE
- [x] formulaire de transfert 
    - [x] ajouter option frais de retrait

FONCTION
    - [x] on ajoute les frais : calcul du montant  
    - [x] fonction extraire suffixe 
    - [x] fonction pour reconnaitre si c'est un numero d'un autre operateur


- [x] envoi multiple 
    - [x] divison du montant pour le numero
    - [x] ajouter une liste de numero a envoyer 
    

FONCTION :
    - [x] verifier si tous les numeros sont meme operateur
    - [x] insertion multiple du transfert vers les different comptes

-[x] ajouter une view pour simplifier l'affichage des histo de transctions
- [x] creation de model pour la view
- [x] adapter les fonctions et les affichage



## cote operateur (jo)
- [x] préfixes pour autres opérateurs
- [x] commission
- [en cours ] Situation opérateur et autres

VUE 
- [x] operator/prefixe.php
    - [x] ajouter précision pour notre préfixe
- [x] operator/dashboard.php
    - [x] ajout situation autres
    - [ ] montant chaque operateur
    
BASE
- [x] ajout table booléan dans tab préfixe
- [x] ajout table commission