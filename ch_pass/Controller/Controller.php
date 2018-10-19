<?php

include_once "Controller/DBconnexion.php"; // Inclusion du fichier de DBconnexion.php pour se servir de ses variables et fonctions.
include_once "Model/User.php";    // Inclusion du fichier de User.php pour se servir de ses variables et fonctions.
include_once "../index.php";   // Inclusion du fichier de index.php pour se servir de ses variables et fonctions.

class Controller {

    // Définition des constantes renvoyants les messages adapté au erreurs.
    const ERROR_ID = "Error id";
    const ERROR_MAIL = "L'email utilisé n'est pas conforme ou est déjà utilisé.";
    const ERROR_PASS = "Error password";
    const ERROR_CO = "Error d\'inscription ou de connexion quelque part. Oups";
    const ERROR_INE = "La valeur entré ne correspond en rien à ce que contient la DB";
    const OK_ADD = "Votre compte va être ajouté, veuillez entré vos informations pour pouvoir vous connecté.";
    const ERROR_DB = "Erreur de connexion à la DB.";
    const NO_DIF = "Les valeurs entré sont incorrect car vous ne respectez pas les conditions.";

    public function verifId($id){   // à voir l'utilité.
        if(!is_int($id)){
            trigger_error(self::ERROR_ID, E_USER_WARNING);
        }
    }

    public function verifMail($mail){   // Fonction vérifiant la conformité des entrées.
        if(!is_string($mail)){  // Si ce n'est pas une chaine de charactère ...
            trigger_error(self::ERROR_MAIL, E_USER_WARNING);    // Erreur.
        }elseif(strlen($mail > 50)){  // Si la chaine de charactère fait plus de 50 charactère ...
            trigger_error(self::ERROR_MAIL, E_USER_WARNING);    // Erreur.
        }
    }

    public function verifPass($pass){   // Fonction vérifiant la conformité des entrées.
        if(!is_string($pass)){  // Si ce n'est pas une chaine de charactère ...
            trigger_error(self::ERROR_PASS, E_USER_WARNING);    // Erreur.
        }elseif(strlen($pass > 20)){  // Si la chaine de charactère fait plus de 20 charactère ...
            trigger_error(self::ERROR_PASS, E_USER_WARNING);     // Erreur.
        }
    }

    public function existNewUser($user){    // Fonction vérifiant la possibilité d'ajouté un nouvel utilisateur.
        $req = "SELECT * FROM user WHERE email = ?";    // Requête.
        $instance = DBconnexion::getInstance(); // Vérifie que la connexion à la DB est réalisable.
        if($instance != null){  // Si oui ...
            $instance->setQuery($req);  // Prépare la requête.
            $instance->execQuery(array($user->getMail()));  // Exécute la requête.
            $results = $instance->rCount(); // Compté le nombre de résultat et le mettre dans une variable.
            if($results == 0){  // Si le résultat est égal à zéro ...
                echo self::OK_ADD;  // Message d'acceptation pour le nouvel utilisateur.
                $user->addUser($user->getMail(), $user->getPass()); // Appel de la fonction d'ajout d'utilisateur.
            }else{  // Sinon ...
                echo self::ERROR_MAIL;  // Retourne erreur.
            }
        }else{  // Sinon ...
            echo self::ERROR_DB;  // Retourne erreur.
        }
    }

    public function existUser($user){   // Fonction vérifiant la possibilité de se connecté à l'espace utilisateur.
        $req = "SELECT * FROM user WHERE email = ? AND pass = ?";   // Requête.
        $instance = DBconnexion::getInstance(); // Vérifie que la connexion à la DB est réalisable.
        if($instance != null){   // Si oui ...
            $instance->setQuery($req);  // Prépare la requête.
            $instance->execQuery(array($user->getMail(), $user->getPass()));    // Exécute la requête.
            $results = $instance->rCount(); // Compté le nombre de résultat et le mettre dans une variable.
            if($results == 1){  // Si le résultat est égal à un ...
                $infouser = $instance->load();  // Chargé les données relative à l'utilisateur sélectionné grâce à la requête.
                $_SESSION["id"] = $infouser["id"];  // Définir la session à ouvrir sous l'id renvoyé par le chargement des info de l'utilisateur séléctionné.
                header("Location: index.php?id=" . $_SESSION["id"]);  // Redirection au point de départs qui affichera un menu différent étant donné la session commencé.
            }else{  // Sinon ...
                echo self::ERROR_INE; // Retourne erreur.
            }
        }else{  // Sinon ...
            echo self::ERROR_DB;  // Retourne erreur.
        }
    }

    public function count(){    // Fonction renvoyant le nombre d'utilisateur dans la DB.
        $req = "SELECT COUNT(email) FROM user"; // Requête.
        $instance = DBconnexion::getInstance(); // Vérifie que la connexion à la DB est réalisable.
        if($instance != null){  // Si oui ...
            $instance->setQuery($req);  // Prépare la requête.
            $instance->exec();  // Exécute la requête.
            $results = $instance->getResultsN();    // Mettre le résultat du SELECT COUNT dans une variable.
            echo $results;  // Affiche le résultat.
        }else{  //Sinon ...
            echo self::ERROR_DB;  // Retourne l'erreur.
        }
    }

    public function getList(){  // Fonction renvoyant une liste des utilisateurs.
        $req = "SELECT * FROM user";   // Requête.
        $instance = DBconnexion::getInstance(); // Vérifie que la connexion à la DB est réalisable.
        if($instance != null){   // Si oui ...
            $instance->setQuery($req);  // Prépare la requête.
            $instance->exec();  // Exécute la requête.
            $results = $instance->getResultsL();    // Mettre le résultat du SELECT dans une variable.
            if($results <= 1){   // S'il y a au moins un résultat ...
                while($results){    // Tant qu'il y à des utilisateurs ...
                    echo "<li>".$results."</li>";   // Afficher le résultat entre deux balises.
                    $results = $instance->getResultsL();    // Mettre le résultat du SELECT dans une variable.
                }
            }else{  // Sinon ...
                echo "Vous êtes seul dans ce monde!";   // Afficher un message.
            }
        }else{  // Sinon ...
            echo self::ERROR_DB;  // Retourne erreur.
        }
    }

    public function underForm($user){   // Fonction vérifiant les actions dans l'espaces utilisateur.
        if(isset($_POST["oldpass"]) && !empty($_POST["oldpass"]) && isset($_POST["newpass"]) && !empty($_POST["newpass"]) && isset($_POST["confnewpass"]) && !empty($_POST["confnewpass"]) && $_POST["newpass"] == $_POST["confnewpass"] && isset($_POST["conf"])){
            // Si toutes les conditions sont respecté ...
            $user->updateUser($user->getNewPass()); // Mettre à jour le mot de pass de l'utilisateur.
        }elseif(isset($_POST["oldpass"]) && !empty($_POST["oldpass"]) && isset($_POST["newpass"]) && !empty($_POST["newpass"]) && isset($_POST["confnewpass"]) && !empty($_POST["confnewpass"]) && $_POST["newpass"] != $_POST["confnewpass"] && isset($_POST["conf"])){
            // Sinon si les conditions sont mal respecté ....
            echo "Les mots de passes ne sont pas identique";    // Retourne message d'erreur spécifique.
        }elseif(isset($_POST["passdelete"]) && !empty($_POST["passdelete"]) && isset($_POST["confdel"])) {   // Et sinon si, l'utilisateur remplis le formulaire de suppression de compte ...
            if($user['pass'] == $_POST['passdelete']){
                $user->removeUser($user->getMail());    // Appeller la fonction qui se chargera de supprimer l'utilisateur de la DB.
                $this->redirectionSpace();
            }elseif($user['pass'] != $_POST['passdelete']){
                echo Controller::ERROR_PASS;
            }else{
                echo Controller::NO_DIF;
            }
        }
    }

    public function redirectionSpace(){ // Fonction appelé lors de la suppression du compte utilisateur.
        session_start();    // Ouverture de la session pour l'écraser après et évité de laissé une session fantôme.
        $_SESSION = array();    // Spécifie que la session sera désormais vide.
        session_destroy();  // Destruction de la session.
        header('Location: .');  // Redirection à la page d'acceuille.
    }

}

?>