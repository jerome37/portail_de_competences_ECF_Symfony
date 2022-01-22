# portail_de_competences_ECF_Symfony
Ce projet a été réalisé dans le cadre de l'exercice de validation d'un module de formation PHP-Symfony (CEFIM - DWWM2021-3).

# ECF Symfony
L'application web 'Portalents' est un outil de gestion des collaborateurs d'une entreprise et des candidats qui y postulent.
Elle est destinée en premier lieu aux équipes RH pour saisir les profils des candidats et des collaborateurs, et pour l'administration globale de l'application. 
Elle sert également aux commerciaux pour explorer le vivier des collaborateurs disponibles et trouver le bon talent pour la bonne mission.
Enfin, elle est utilisée par les collaborateurs eux-mêmes pour gérer leur profil par l'ajout de nouvelles compétences, de nouvelles expériences et/ou de nouveaux documents, ou pour modifier/actualiser leurs informations personnelles.

⚠️ L'application n'est disponible actuellement qu'en mode développement.
    
    
# L'installation
L'installation se fait en plusieurs étapes basiques :

1. Ouvrir un dossier pour y accueillir les fichiers du projet.
2. Depuis le terminal de commandes ou depuis le terminal de l'IDE, clôner le projet via le lien récupérer sur le GITLAB grâce à la commande suivante:
> git clone 'lien du projet'
3. Ensuite, il est nécessaire d'installer les composants du projet.
> composer install
4. Une fois le projet initialisé, il faut préparer la base de données, à commencer par la mise en relation avec MySql pour y héberge la base. Pour cela, dans le fichier '.env', modifier comme suit:
> DATABASE_URL="mysql://**iddeconnexionàmysql**:**motdepassedeconnexionàmysql**@127.0.0.1:8889/**Portalents**?serverVersion=5.7"
5. Ceci fait, il est utile de vérifier si la connexon entre le projet et MySQL est bien établie :

> symfony serve -d

Puis, ouvrir une page web avec l'adresse du port mentionné par le terminal.

6. il est désormais possible de créer la base de données grâce à la commande suivante :
> symfony console doctrine:database:create
7. La base étant désormais créée, il faut y importer les tables :

> symfony console make:migration

> symfony console doctrine:migrations:migrate
8. Il ne manque plus qu'à lui verser des données factices. Pour cela :
> symfony console doctrine:fixtures:load

L'application est désormais opérationnelle ! 


# Le fonctionnement

**Globalités**

L'application Portalents est en premier lieu un outil destiné aux équipes RH.

Par conséquent, ce sont elles qui assurent la saisie des premières informations relatives aux candidats qui souhaitent postuler dans l'entreprise et qui gère le recrutement des collaborateurs depuis le vivier de candidats.

Lorsque les équipes RH ont sélectionné parmis les CV et les lettres de motivation envoyés par les postulants des candidats potentiels, elles saisissent les ifnormations dans l'application en tant que 'candidat'. 

_A minima_, elles peuvent saisir les informations personnelles telles que l'identité, l'adresse et les contacts pour créer le ou les profils à la volée.

Pour le compléter immédiatement ou plus tard, les équipes ont accès en tant qu'administrateurs, depuis le menu de navigation 'Les talents', à la liste de tous les candidats. 

Elles peuvent également consulter, depuis la page d'accueil, le tableau des derniers candidats saisis pour rappeler un profil 'candidat' et y ajouter des compétences, des expériences et/ou des docuemnts (comme le CV et la lettre de motivation).

Enfin, elles disposent d'une interface de recherche qui permet de rappeler un profil candidat précis.

Une fois créé, le profil du ou des candidats est visible par les commerciaux et est ouvert au recrutement si les besoins correspondent aux coméptences et aux expérinecs qu'offre le candidat.


Lorsqu'un candidat est recruté, les administrateurs lui créent un profil utilisateur dans lequel ils lui définissent un identifiant, une adresse mail interne et un mot de passe.

Désormais, le candidat a le statut de 'collaborateur' et il peut se connecter à l'application pour avoir un plein accès à son profile.

Dans le cas d'un départ ou d'un renvoi d'un collaborateur, les administrateurs peuvent rappeler son profil pour le modifier en lui attribuant le statut de 'a quitté l'entreprise'.



**La connexion**

L'application s'ouvre sur une interface de connexion.

Seuls les collaborateurs recrutés, les commerciaux et les administrateurs, c'est-à-dire les membres de l'équipe RH - _a minima_ - peuvent se connecter en saisissant leur identifiant et leur mot de passe transmis lors de la créaton de leur compte utilisateur (je n'ai pas installé de Mailer qui aurait transmis ces renseignements au destinataire du compte à l'issue de sa création).

Selon le rôle qui leur a été attribué ('ROLE_COLLABORATEUR', 'ROLE_COMMERCIAL' ou 'ROLE_ADMINISTRATEUR'), l'utilisateur est ensuite redirigé vers une page d'accueil spécifique : le profil du collaborateur ou le dashboard pour les commerciaux et les administrateurs (pour ces derniers, aucune page n'ayant été précisée, j'ai pensé que le dashboard convenait).



**La navigation**

    Le ou la collaborateur.rice :

La navigation du ou de la collaborateur.rice se cantonne uniquement à la consultation et à la modification des informations de son profil.

Il peut donc modifier ses informations personnelles et ajouter des compétences, des expériences et/ou des documents.

En ce qui concerne la modification du profil, en plus d'avoir accès à ses informations personnelles, le ou la collaborateur.rice peut préciser dès le début du formulaire sa disponibilité. En revanche, il ne lui est pas permis de modifier son statut. De même, il n'a aucun accès à son profil utilisateur qui reste l'exclusivité des administarteurs, c'est-à-dire des RH.

A propos des compétences, outre l'ajout d'une ou plusieurs nouvelles compétences, il dispose de la possibilité d'en modifier le niveau d'expertise et de préciser s'il s'agit, ou non, d'une compétence qu'il apprécie. S'il le souhaite, il peut bien évidemment supprimer la compétence en cas d'erreur, de redondance ou autres raisons.

Il en est de même pour les expériences ainsi que pour les documents. Concernant ces derniers, ils peuvent être affichés dans une fenêtre du navigateur et, de là, être téléchargés.

Enfin, il peut se déconnecter via le bouton situé en haut à gauche de la barre de navigation.


    Le ou la commercial.e :

Tout d'abord, le ou la commercial.e a accès depuis la page d'accueil à trois tableaux:
- les derniers candidats saisis, qui liste dans l'ordre décroissant de leur entrée en saisie les 10 derniers candidats mis à disposition des         commerciaux et des RH.
- les derniers collaborateurs recrutés, qui liste dans l'ordre décroissant de leur recrutement, les 10 derniers collaborateurs qui ont rejoint l'entreprise.
- les derniers profils modifiés, qui liste dans l'ordre décroissant de leur date de modification les 10 derniers profils qui ont été modifiés et/ou complétés pour suivre l'actualisation des profils aussi bien candidats que collaborateurs.

Outre ces tableaux, depuis l'onglet 'Les talents' le ou la commercial.e consulter tous les profils 'candidats' ou 'collaborateurs' ainsi que leur disponibilité. Depuis cette interface, il ou elle peut consulter un profil particulier.

Sur ce profil, il ne lui est offert que la possibilité de modifier la disponibilité, de consulter et/ou de modifier une expérience, et de voir et d'ajouter un document.

Si un élément du profil est modifié, le ou la commercial.e est automatiquement renvoyée sur le dashboard pour vérifier depuis l'onglet 'derniers profils modifiés' si les changements ont bien été effectués.

Depuis la barre de navigation, le ou la commercial.e peut aussi utiliser une interface de recherche des profils.

Cette interface offre plusieurs possibilités :
- la recherche nominale, dans le prénom ou le nom d'un ou d'une candidat.e/collaborateur.rice, qu'il soit complet ou incomplet.
Par exemple :
> recherche par 'Jérôme' / 'Salmon' / 'jer' ou 'mon' -> profils ayant pour prénom 'Jérôme' / pour nom 'Salmon' / contenant la suite de caractères 'jer' ou 'mon' dans le prénom comme dans le nom

- la recherche par compétences.
L'interface propose alors de rechercher selon une compétnce spécifique et/ou selon un niveau précis et/ou en fonction de l'appréciation que lui a donné le ou la collaborateur.rice.

En cas de résultats, chaque ligne correspondant à la recherche précise un profil avec posiibilité de le consulter et de le modifier.

Enfin, le ou la commercial.e peut se déconnecter via le bouton situé en haut à gauche de la barre de navigation.


    Le ou la administrateur.rice :

Un ou une administrateur.rice a un accès complet à tous les éléments de l'application.

Il ou elle peut donc consulter un profil avec toutes les options de consultation, de modification ou de suppression.

Il ou elle peut également consulter les profils, qu'ils soient 'candidat' ou 'collaborateur' par les mêmes biais que pour le ou la commercial.e : 
- le dashboard sur la page d'accueil
- l'onglet 'Les talents' dans la barre de navigation
- l'interface de recherche dans les profils disponibles

Le plus, au regard des droits donnés aux commerciaux, concerne la possibilité de supprimer un profil 'candidat' ou 'collaborateur', de pouvoir recruter un profil 'candidat' et de faire passer un profil 'collaborateur' comme ayant quitté l'entreprise.

Un ou une administrateur.rice peut consulter tous les utilisateurs, c'est-à-dire tous les profils disposant d'un compte avec la possibilité de les modifer si besoin est via l'onglet 'Les comptes'.

C'est grâce à cette interface qu'un ou une administarteur.rice peut créer un compte utilisateur sans que ce dernier ne fasse partie du vivier des talents administrés, c'est-à-dire sans qu'il ne dispose d'un profil préalablement saisi dans l'application. 

Ce peut notamment être le cas d'un nouveau membre de l'équipe RH ou d'un ou d'une nouveau.elle commercial.e recruté par l'entreprise _ex nihilo_. Bien sûr, un profil peut évoluer pour se voir attribuer des droits de commercial ou d'administration.

En bref, sur la gestion et la création des comptes utilisateurs, un ou une candidat.e n'ont pas de compte utilisateur, un ou une collaborateur.rice dispose obligatoirement d'un compte utilisateur et d'un profil; tandis que les commerciaux et les administrateurs ont systématiquement un compte utilisateur sans avoir de profil.

Enfin, les administrateurs ont accès à la gestion complète de la nomenclature.

Ils peuvent ajouter/modifier/supprimer des compétences, des catégories de compétences, des entreprises clientes ou des options telles que les professions, les statuts des profils et autres via l'onglet 'La nomenclature' de la barre de navigation. De cette manière, les administrateurs disposent d'une vision et d'une gestion à 360° de l'application, des éléments qui la compose et de personnes qui l'utilisent.
