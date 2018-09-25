<?php

include_once 'DBconnexion.php';
include_once 'Controller.php';
include_once 'View.php';

class User{
    
    private $_id;
    private $_mail;
    private $_pass;
    
    public function load($id_user){
        $req = 'SELECT email, pass FROM test WHERE id ='.$_id;
        $result = hydrate($req);
        print_r($result);
    }
    
    public function getId(){
        $this->_id;
    }
    
    public function setId($id){
        return $this->_id=$id;
    }
    
    public function getMail(){
        $this->_mail = $_POST['formmail'];
    }
    
    public function setMail($mail){
        $this->_mail = $mail;
    }
    
    public function getPass(){
        $this->_pass = $_POST['formpass'];
    }
    
    public function setPass($pass){
        $this->_pass = $pass;
    }
    
    public function getList(){
        $req  = 'SELECT email FROM tests';
        $instance = DBconnexion::getInstance();
        if($instance != null){
            $instance->setQuery($req);
            $instance->execQuery();
            $results = $instance->getResultsL();
            print_r($results);
        }else{
            echo "0 users";
        }
    }
    
    public function addUser($user){
        $req = "INSERT INTO tests(email, pass) VALUES (:formmail,:formpass)"; //requête d'insertion
        DBconnexion::getInstance()->setQuery($req); // demande à la BDD 
        DBconnexion::getInstance()->bindVal(':formmail', $user->getMail(), PDO::PARAM_STR); //trouver la valeur mail à envoyer 
        DBconnexion::getInstance()->bindVal(':formpass', $user->getPass(), PDO::PARAM_STR); // trouver la valeur pass à envoyer
        var_dump($user->getMail());
        //$res = DBconnexion::getInstance()->execQuery(); // executer la requête
        
    }
    
    public function updateUser($user){
        if(isset($_POST['oldpass'])){
            Controller::verifpass();
            if(isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['confnewpass']) && $_POST['newpass'] == $_POST['confnewpass'] && isset($_POST['conf'])){
                $req = 'UPDATE tests SET pass = :formpass WHERE email='.$user->getMail();
                $req->bindVal(":pass", $user->setPass(), PDO::PARAM_STR);
                $req->bindVal(":id", $user->setId(), PDO::PARAM_STR);
                DBconnexion::getInstance()->execQuery($req);
            }
        }else{
            Controller::ERROR_PASS;
        }
    }
    
    public function removeUser($user){
        $req = 'DELETE FROM tests WHERE email ='.$user->getMail();
        DBconnexion::getInstance()->execQuery($req);
    }
    
//    public function hydrate(array $data){
//        foreach($data as $key => $values){
//            $method = 'set'.ucfirst($key);
//            if(method_exists($this, $method)){
//                $this->$method($value);
//            }
//        }
//    }
//    
//    public function __construct(array $data){
//        $this->hydrate($data);
//    }

}

?>