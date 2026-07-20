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
- [ ] voir le solde
    - [ ] recuperer les debit et credits du compte 
    - [ ] calculer la difference

- [ ] faire un depot 
    - [ ] formulaire de depot 
    - [ ] fonction qui decremente le compte au depot 

- [ ] faire un transfert 
    - [ ] formulaire de transfert 
    - [ ] fonction de transaction

- [ ] historique 
    - [ ] lioster les historiques 