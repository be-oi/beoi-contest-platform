
# Unofficial doc -- just collecting info about the platform usage

"Le champ “status” (futur, en cours, caché, ...) dans quel cas est-il utilisé ? (<> visibilité)"
il est obsolète, il va être supprimé
il est remplacé par des flags plus précis

visibilité = 
les coordinateurs le voient dans la liste quand ils créent un groupe
donc peuvent créer un groupe

“s’entrainer à la maison. consulter les annales” ?
il faut créer un groupe public rattaché au concours
les annales sont en fait la liste des groupes publics
structurés par année + niveau des concours associés

“fermé au groupes officiels” & officiel
officiel ça veut dire qui compte dans les classements qu'on publie
donc en général y'a que le prochain concours qui est ouvert aux groupes officiels
les profs peuvent créer des groupes hors concours pour tester l'épreuve, se faire des compétions entre eux etc.
parfois certains se trompent par contre et croient que ça permet de faire un entraînement même si c'est expliqué à côté dans l'interface de création de groupe
donc pour l'année prochaine on ajoutera une popup de confirmation ou qqc pour clarifier et éviter ces qq erreurs

heure de fin, c’est la fin pour démarrer ou pour avoir terminé le concours?
pour démarrer -- ça contraint uniquement l'heure que tu peux mettre aux groupes
en pratique le concours je le ferme à la main

Pourrais-tu me faire une rapide courte explication des options pour concours (ou me dire où elle est si c’est expliqué qqpart): genre (oui/non), id Etud (oui/non), classe (oui/non), code postal (oui/non), email (oui/non), taille ss ensemble, question suivante auto (oui/non), score bonus, status (versus ouvert et visibilité), fermé aux groupes officiels (oui/non) ?
la plupart c'est juste pour dire si on demande l'info ou pas aux élèves (genre, id, classe, code postal,email)
taille sous-ensemble c'est si on veut prendre au hasard un sous-ensemble de sujets parmi ceux qui ont le même champ "ordre"
si tu en mets 10 avec ordre=0 et que tu mets taille sous-ensemble à 4, il en prendra 4 au hasard parmi les 10
score bonus, c'est si tu veux donner des points gratuits à tout le monde
statut c'est deprecated, on l'a laissé le temps de finir la transition
question suivante => ça passe automatiquement à la question suivante une fois que tu as répondu à la précédente, mais c'est surtout pour l'ancienne interface, où on avait une liste de sujets sur la gauche, et pas de full-feedback
fermé aux groupes officiels => quand tu clôtures le concours tu ne veux plus que des gens créent des groupes officiels, mais ils peuvent toujours s'entraîner

Avant/Après un concours officiel, le concours doit être fermé, sinon ils peuvent rentrer dans le concours !
Donc un concours en préparation doit être fermé mais visible pour permettre la création des groupes.

Si changement dans les modules des tâches, tout le concours doit être regénéré.
