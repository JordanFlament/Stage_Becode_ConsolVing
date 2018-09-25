<?php

class View{

    public function head(){
        echo "<html>";
        echo "<head>";
        echo "<meta charset=UTF-8>";
        echo "<title>Change Pass</title>";
        echo "</head>";
        echo "<body>";
    }

    public function bodyasd(){
        echo "<arcticle>";
        echo "<section>";
    }
    
    public function formulaireco(){
        echo "<form action='' method='POST' autocomplete='off' name='formulaire'>";
        echo "<input type='text' name='formmail' placeholder='ID' value='' maxlenght='15' utocomplete='off'>";
        echo "<input type='password' name='formpass' placeholder='Password' value='' maxlength='20' utocomplete='off'>";
        echo "<input type='submit' name='formsub' value='Create'>";
        echo "<input type='submit' name='formuse' value='Use'>";
        echo "</form>";
    }

    public function formrm(){
        echo "<form action='' method='POST'>";
        echo "<input type='password' name='passdel' value='' placeholder='Your pass'>";
        echo "<inoput type='submit' name='passdelsub' value='Delete'>";
        echo "</form>";
    }

    public function chmp(){
        echo "<form action ='' method='POST' autocomplet='off'>";
        echo "<input type='password' name='oldpass' placeholder='Ancien mot de passe' value='' maxlength='20' autocomplete='off'>";
        echo "<input type='password' name='newpass' placeholder='Nouveau mot de passe' value='' maxlength='20' autocomplete='off'>";
        echo "<input type='password' name='confnewpass' placeholder='Confirmation' value='' maxlength='20' autocomplete='off'>";
        echo "<input type='submit' name='conf' value='Valider'>";
        echo "</form>";
    }

    public function rm(){
        echo "<form action='' method='POST'>";
        echo "<input type='submit' name='rmc' value='Delete compte'>";
        echo "</form>";
    }

    public function formch(){
        echo "<form action='' method='POST'>";
        echo "<input type='submit' name='changemp' value='Changer mot de passe'>";
        echo "</form>";
    }

    public function bodysaf(){
        echo "</section>";
        echo "</article>";
    }

    public function footer(){
        echo "</body>";
        echo "</html>";
    }
    
}

?>