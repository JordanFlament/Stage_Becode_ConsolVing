Plan d'un code pour un espace utilisateur.
=========================================

Mise en place de la DB.
----------------------

**La DB doit contenir ;**

 *  variable et constante
 *  un constructeur
 *  l'instantiation
 *  fonction query
 *  fonction execute
 *  fonction bindvalue

Mise en place du model.
-----------------------

**Le model doit contenir toute la gestion get set et load des données ;**

 *  variable
 *  function load
 *  getmail & setMail
 *  getpass & setPass
 *  new user
 *  update user
 *  rm user 
 *  list

Mise en place du controller.
---------------------------

**Contient les vérificateur ;**

 *  filtre de sanitization
 *  function verif si l'adresse existe ou non et si l'adresse est conforme
 *  function verif si le mot de passe appartient bien à l'adresse et verifie si le mp est conforme
 *  verifie si les champs sont compatibles entre eux et avec la BD
 *  compte les usilisateur enregistré. 

Mise en place de la vue.
------------------------

* Contient tout l'html

Mise en place de l'index.
-------------------------

**contient de déroulement du script ;**

 *  auto load
 *  session
 *  appelle des class
 *  appel des method pour html
 *  count compte exist
 *  verifie des champs
 *  if session{
 *      espace utilisateur
 *      formulaire de suppression
 *      formulaire de changement de password
 *  }
 *  if create {
 *      verif new user
 *      appelle de la method add
 *  }
 *  if use {
 *      verif user
 *  }