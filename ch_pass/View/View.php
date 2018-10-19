<?php

include_once "../Model/User.php";    // Inclusion du fichier User.php pour pouvoir se servir de ses varaibles et fonction, plus tard.

class View{

    public function head(){ // Tête html.
        echo "<html>";
        echo "<head>";
        echo "<meta charset=UTF-8>";
        echo "<title>Change Pass</title>";
        echo "</head>";
        echo "<body>";
    }

    public function bodyasd(){  // Partie du body qui servira à mettre un peu d'emphase.
        echo "<arcticle>";
        echo "<section>";
    }
    
    public function formulaireco(){ // Formulaire de connexion et inscription.
        echo "<table>";
        echo "<form action='' method='POST' autocomplete='off' name='formulaire'>";
        echo "<tr></tr><td><input type='text' name='formmail' placeholder='ID' value='' maxlenght='15' utocomplete='off'></td>";
        echo "<tr></tr><td><input type='password' name='formpass' placeholder='Password' value='' maxlength='20' utocomplete='off'></td>";
        echo "<tr></tr><td><input type='submit' name='formsub' value='Create'></td>";
        echo "<tr></tr><td><input type='submit' name='formuse' value='Use'></td>";
        echo "</form>";
        echo "</table>";
    }

    public function spaceUser($user){   // Espace utilisateur.
        echo "<fieldset><legend>My info :</legend>";
        echo "<p><a href='?deco=1'>Déconnexion</a></p>";
        echo "<p>Utilisateur n° : ".$_SESSION["id"]." = ".$user->showUser()."<p><br/>";
        echo "<p>Pour supprimer votre compte, confirmez votre identité en mettant votre password et cliquez ensuite sur le bouton confirmer.";
        echo "<form action='' method='POST'>";
        echo "<p><input type='password' name='passdelete' placeholder='Password' value=''><input type='submit' name='confdel' value='confirmer'></p>";
        echo "</form>";
        echo "</fieldset>";
    }

    public function chmp(){ // Formulaire de changement de mot de passe.
        echo "<fieldset><legend>Change my password :</legend>";
        echo "<form action ='' method='POST' autocomplet='off'>";
        echo "<table>";
        echo "<tr></tr><td><input type='password' name='oldpass' placeholder='Ancien mot de passe' value='' maxlength='20' autocomplete='off'></td>";
        echo "<tr></tr><td><input type='password' name='newpass' placeholder='Nouveau mot de passe' value='' maxlength='20' autocomplete='off'></td>";
        echo "<tr></tr><td><input type='password' name='confnewpass' placeholder='Confirmation' value='' maxlength='20' autocomplete='off'></td>";
        echo "<tr></tr><td><input type='submit' name='conf' value='Valider'></td>";
        echo "</table>";
        echo "</form>";
        echo "</fieldset>";
    }
    
        
    public function getListp1(){    // Partie 1 de la section de list des utilisateurs.
        echo "<fieldset><legend>Nombre d'utilisateurs existants : ";
    }
    
    public function getListp2(){    // Partie 2 de la section de list des utilisateurs.
        echo ".</legend>";
        echo "<p>Liste des utilisateurs existant ; </p>";
        echo "<ul>";    
    }
    
    public function getListp3(){    // Partie 3 de la section de list des utilisateurs.
        echo "</ul>";
        echo "</fieldset>";
    }

    public function bodysaf(){  // Fin de la partie d'emphase du body.
        echo "</section>";
        echo "</article>";
    }

    public function footer(){   // Pied de la page html.
        echo "</body>";
        echo "</html>";
    }
    
}

?>