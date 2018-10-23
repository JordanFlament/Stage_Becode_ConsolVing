<?php

class Autoloader{
    
    static function register(){ // Apelle de la fonction d'appel de classes.
        spl_autoload_register(array(__CLASS__, "autoload"));
    }
    
    static function autoload($class){ // Initialisation de la fonction permettant d'appeller les autres classes.
        $class = str_replace("\\", "/", $class);
        require $class.".php";
    }
} 

Autoloader::register(); // Appel de la fonction d'appel de classes.

session_start();    // Ouverture de la session qui nous servira plus tard en fonction des respects de conditions.

$html = new View\View;   // Appelle de la classe View.php.
$cont = new Controller\Controller; // Appelle de la classe Controller.php.
$user = new Model\User();  // Appelle de la classe User.php.

if(isset($_GET["deco"])){   // Si une fois connecté, l'utilisateur clique sur le lien de déconnexion ...
    session_start();    // Ouverture de la session utilisé.
    $_SESSION = array();    // Définition de la session sur rien d'autre que du vide.
    session_destroy();  // Destruction de la session en cour.
    header("Location: .");  // Redirection à la page d'acceuille.
}

$html->head();  // Mise en place de la tête html.
    $html->bodyasd();   // Mise en place l'emphase html.
    if(isset($_SESSION["id"])){ // S'il y a déjà un session en cour, alors affichage de la page de l'utilisateur.
        $html->getListp1(); // Affichage de la partie 1 de la liste.
        $cont->count(); // Fonction qui compte et affiche le nombre d'utilisateur existant.
        $html->getListp2(); // Affichage de la partie 2 de la liste.
        $cont->getType();   // Fonction qui va vérifié le type d'utilisateur avant d'afficher la liste des utilisateur.
        $html->getListp3(); // Affichage de la partie 3 de la liste.
        $html->spaceUser($user); // Affichage de l'espace utilisateur.
        $cont->underDelete($user); // Fonction qui vérifie si l'utilisateur supprime son compte.
        $html->chmp();  // Affichage du formulaire de changement de password.
        $cont->underPass($user); // Fonction qui vérifie si l'utilisateur à changer de password.
    }else{ // S'il n'y a pas de session en cour ....
        $html->formulaireco(); // Affichage du formulaire d'inscription / connexion.
        if(!empty($_POST["formmail"]) && !empty($_POST["formpass"])){   // Si les champs sont remplis...
            $cont->verifMail($user->getMail()); // Vérifie la conformité de la valeur.
            $cont->verifPass($user->getPass()); // vérifie la conformité de la valeur.
            if(isset($_POST["formsub"])){   // Si l'utilisateur veut créer un nouveau compte ...
                $cont->existNewUser($user); // Vérifie si l'utilisateur n'existe pas encore. Si il éxiste déjà, il renvéra une erreur. Sinon, il l'ajoutera.
            }
            if(isset($_POST["emaildeleting"]) && !empty($_POST["emaildeleting"]) && isset($_POST["confdeleting"])){    //  Si les champs sont remplis.
                $user->rmOtherUser();   // Supprime un autre utiisateur.
            }
            if(isset($_POST["formuse"])){ // Si l'utilisateur veut utiliser un compte ...
                $cont->existUser($user);    // Vérifie que l'utilisateur exite bien et que le mot de passe est correct. Si c'est le cas, une redirection vers la page d'acceuille est faite et, puisque vous entré dans la premiere condition, vous accederez au l'espace utilisateur. Dans le cas contraire, une erreur sera renvoyer.
            }
        }
    }
    $html->bodysaf();   // Fin de l'emphase html.
$html->footer();    // Fin du fichier html.

?>