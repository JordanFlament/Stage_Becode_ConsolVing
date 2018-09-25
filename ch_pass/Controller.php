<?php

include_once 'DBconnexion.php';
include_once 'User.php';

class Controller{
    
    //private $_data;
    
    const ERROR_ID = 'Error id';
    const ERROR_MAIL = 'Error email';
    const ERROR_PASS = 'Error password';
    const ERROR_INS = 'Error d\'inscription quelque part. Oups';
    
    //public function getData(){
      //  $this->_data;
    //}
    
    //public function setData($data){
      //  return $this->_data = $data;
    //}
    
  //  public function __construct(){
    //    $this->setData($data);
    //}
    
    public function count(){
        $req = 'SELECT COUNT(*) FROM tests';
        $instance = DBconnexion::getInstance();
        if($instance != null){
            $instance->setQuery($req);
            $instance->execQuery();
            $results = $instance->getResultsN();
            echo $results;
        }else{
            echo "La sélection est vide.";
        }
    }
    
    public function verifId($id){
        if(!is_int($id)){
            trigger_error(self::ERROR_ID, E_USER_WARNING);
        }
    }
    
    public function verifMail($mail){
        if(!is_string($mail)){
            trigger_error(self::ERROR_MAIL, E_USER_WARNING);        
        }elseif(strlen($mail>50)){
            trigger_error(self::ERROR_MAIL, E_USER_WARNING);
        }else{
            return filter_var($mail, FILTER_SANITIZE_EMAIL);
        }
    }
    
    public function verifPass($pass){
        if(!is_string($pass)){
            trigger_error(self::ERROR_PASS, E_USER_WARNING);
        }elseif(strlen($pass>20)){
            trigger_error(self::ERROR_PASS, E_USER_WARNING);
        }else{
            return filter_var($pass, FILTER_SANITIZE_STRING);
        }
    }
}

?>