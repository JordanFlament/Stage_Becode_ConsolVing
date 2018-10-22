<?php
namespace Model;

use Controller\DBconnexion; // Inclusion du fichier DBconnexion.php afin de profité de ses variables et fonctions.
use Controller\Controller;  // Inclusion du fichier Controller.php afin de profité de ses variables et fonctions.
use View\View;    // Inclusion du fichier View.php afin de profité de ses fonctions.
use PDO;

class User{

    private $_mail; // Initialisation de la variable mail.
    private $_pass; // Initialisation de la variable pass.
    private $_newpass;  // Initialisation de la variable newpass.
    
    public function getMail(){  // Fonction renvoyant la valeur de l'input mail d'entré dans la variable de mail.
        return $this->_mail = $_POST["formmail"];
    }
    
    public function setMail($mail){ // Fonction renvoyant la valeur de la variable initiale mail dans une variable fictive de mail.
        $this->_mail = $mail;
    }
    
    public function getPass(){  // Fonction renvoyant la valeur de l'input pass d'entré dans la variable de pass.
        return $this->_pass = $_POST["formpass"];
    }
        
    public function setPass($pass){ // Fonction renvoyant la valeur de la variable initiale pass dans une variable fictive de pass.
        $this->_pass = $pass;
    }
    
    public function getNewPass(){   // Fonction renvoyant la valeur de l'input newpass dans l'espace de changement de pass dans la variable newpass.
        return $this->_newpass = $_POST["newpass"];
    }
    
    public function setNewPass($newpass){   // Fonction renvoyant la valeur de la variable initiale newpass dans une variable fictive de newpass.
        $this->_newpass = $newpass;  
    }
    
    public function addUser($mail, $pass){  // Fonction d'ajout de nouvel utilisateur
        $req = "INSERT INTO user(email, pass) VALUES (?,?)"; // Requête d'insertion
        $instance = DBconnexion::getInstance(); // Connexion à la DB.
        if($instance != null){ // Si connexion possible ...
            $instance->setQuery($req); // Préparer la requête.
            $instance->bindVal(":email", $mail, PDO::PARAM_STR); // Trouver la colonne à inséré ainsi que la valeur mail à envoyer. 
            $instance->bindVal(":pass", $pass, PDO::PARAM_STR); // trouver la colonne à inséré ainsi que la valeur pass à envoyer, 
            $instance->execQuery(array($mail, $pass)); // executer la requête
        }else{  // Sinon ...
            echo Controller::ERROR_DB;    // Retourne erreur.
        } 
    }
    
    public function updateUser($newpass){   // Fonction servant à mettre à jour le mot de pass de l'utilisateur.
        $req = "SELECT * FROM user WHERE id = ?";   // Requête.
        $instance = DBconnexion::getInstance(); // Connexion à la DB.
        if($instance != null){  // Si connexion possible...
            $instance->setQuery($req);  // Préparation de la requête.
            $instance->execQuery(array($_SESSION["id"]));   // Exécution de la requête.
            $uti = $instance->rCount(); // Compté le résultat renvoyé par la requête et le mettre dans une variable. 
            if($uti == 1){  // Si le résutat contenu dans la variable est égal à un...
                $info = $instance->load();  // Mettre les données relative du résultat dans une variable.
                $password = $info["pass"];  // Récupéré le pass renvoyé par la DB.
                $newpass = $_POST["newpass"];   // Mettre le résultat de new pass dans une variable.
                if($password == $_POST['oldpass']){
                    if($newpass != $password){  // Comparer les deux mots de passe. S'il sont différents, alors ....
                        $req2 = "UPDATE user SET pass = ? WHERE email = ?"; // Création de la deuxiemme requête pour mettre à jour le pass.
                        $instance->setQuery($req2); // Préparation de la deuxièmme requête.
                        $instance->bindVal(":pass", $newpass, PDO::PARAM_STR);  // Trouver la colonne à inséré, ainsi que la valeur à ajouté.
                        $instance->execQuery(array($newpass, $info["email"]));  // Exécuté la requête.
                        echo "Votre mot de passe à bien été changé!";   // Afficher un message de confirmation.
                    }else{  // Sinon ...
                        echo "Vous ne pouvez pas mettre le même mot de passe. La sécurité avant tout !";    // Afficher message d'erreur.
                    }
                }else{  // Sinon ...
                    echo Controller::ERROR_PASS;    // Retourne erreur.
                }
            }else{  // Sinon ....
                echo Controller::ERROR_INE;   // Retourne erreur.
            }
        }else{  // Sinon ...
            echo Controller::ERROR_INE;  // Retourne erreur.
        }
    }

    public function showUser(){ // Fonction servant à afficher le mail de l'utilisateur dans son espace d'information.
        $req = "SELECT * FROM user WHERE id = ?";   // Requête de sélection.
        $instance = DBconnexion::getInstance(); // Connexion à la DB.
        if($instance != null){  // Si connexion possible ...
            $instance->setQuery($req);  // Prépare la requête.
            $instance->execQuery(array($_SESSION["id"]));   // Exécute la requête.
            $results = $instance->rCount(); // Compté le nombre de résultats renvoyé et les mettre dans une variable.
            if($results == 1){  // Si le résultat est égal à un ...
                $infouser = $instance->load();  // Mettre les informations relative à l'utilisateur sélectionné lors de la requête dans une variable.
                return $infouser["email"];  // Afficher l'email récupéré dans la variable précédement initialisé.
            }else{  // Sinon ...
                echo Controller::ERROR_INE;   // Retourne erreur. 
            }
        }else{  // Sinon ...
            echo Controller::ERROR_DB;    // Retourne erreur.
        }
    }
    
    public function removeUser(){   // Fonction de suppression d'utilisateur.
        $req = "DELETE FROM user WHERE id = ?";   // Requête.
        $instance = DBconnexion::getInstance(); // Connexion à la DB.
        if($instance != null){  // Si connexion possible ....
            $instance->setQuery($req);  // Préparation de la requête.
            $instance->execQuery(array($_GET["id"]));   // Exécution de la requête.
        }elseif($instance == null){  // Sinon ...
            echo Controller::ERROR_DB;    // Retourne erreur.
        }
    }
    
}

?>