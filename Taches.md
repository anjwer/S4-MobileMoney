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
 ### Configuration des paramètres
- [ ] Gestion des Préfixes :
    - [] Créer une page permettant d'ajouter/supprimer/lister les préfixes autorisés (033, 034, 037, etc.).
    - [] Logique : Un simple CRUD (Create, Read, Update, Delete).
- [ ] Gestion des Barèmes de frais :
    - [] Créer une interface pour définir les tranches de montant (min/max) et les frais associés par type d'opération (Dépôt/Retrait/Transfert).
    Exemple : Si Montant >= 100 ET <= 1000, Frais = 50.

### Monitoring (Dashboard)
- [ ] Situation des gains :
    - [] Calculer le total des frais récoltés (somme de la colonne fee_amount dans transactions).
    - [] Afficher un résumé par type d'opération (ex: "Total gains Retrait", "Total gains Transfert").

- [ ] Situation des comptes clients :
    - [] Afficher une liste (ou tableau) de tous les numéros de téléphone existants avec leur solde actuel.
    - [] Optionnel mais conseillé : Ajouter un filtre par numéro de téléphone.

### Logique métier (Controller CI4)
- [ ] Middleware/Filter (Optionnel) :
    - [] Vérifier que seul l'opérateur (ou l'admin) peut accéder à ces pages (si tu prévois une authentification).

- [ ] Calculateur de frais :
    - [] Développer une fonction réutilisable (dans un Model ou un Helper) qui prend un montant en entrée et retourne les frais correspondants en interrogeant la table fee_brackets.



### view
- [ ] 

### controler 


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