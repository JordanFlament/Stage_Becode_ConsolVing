<?php

function classe($classe){
    include $classe.'.php';
}

spl_autoload_register('classe');

session_start();

if(isset($_GET['deco'])){
    session_destroy();
    header('Location ./');
    exit();
}

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}

$html = new View;
$cont = new Controller;
$user = new User();

$html->head();
$html->bodyasd();
echo "<p>Nombre d'utilisateurs existants : ",$cont->count(),".<hr/>";
echo "Liste des utilisateurs existant ; ";
$user->getList();
echo "<hr/>";
$html->formulaireco();
    if(isset($_POST['formmail']) && isset($_POST['formpass']) && isset($_POST['formsub'])){
        $cont->verifMail($_POST['formmail']);
        $cont->verifPass($_POST['formpass']);
        $user->addUser($user);  
    }else{
        Controller::ERROR_INS; 
    }
$html->bodysaf();
$html->footer();

?>