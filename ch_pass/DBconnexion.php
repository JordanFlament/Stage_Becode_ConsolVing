<?php

class DBconnexion{ // Définition de la classe qui intérragira avec la DB.
    
	private static $DBConnexionClassInstance = null;	//Instance (singleton) de la classe DBConnexion
    
	private $_dbConnexion = null; //Variable de connexion à la DB
	private $_statement = null; //Variable permettant de gérer les requêtes PDO (prÃ©paration, bindings, exécution)
	private $_query = null;	//la requête que l'utilistaeur souhaite exécuter
    
    const DEFAULT_SQL_DBHOST = 'localhost'; // Hébergement.
    const DEFAULT_SQL_DBNAME = 'test';  // Nom de la DB.
    const DEFAULT_SQL_DBUSER = 'root';  // Nom de l'utilisateur de la DB.
    const DEFAULt_SQL_DBPASS = '';  // Mot de pass de l'utilisateur de la DB.
    
    private function __construct() { // Définition de la fonction de construction qui initialite la connection à la DB avec, en paramètre, les constantes défini au dessus.
        $this->_dbConnexion = new PDO('mysql:host='.self::DEFAULT_SQL_DBHOST.';dbname='.self::DEFAULT_SQL_DBNAME,self::DEFAULT_SQL_DBUSER,self::DEFAULt_SQL_DBPASS);
        $this->_dbConnexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING); //Définition d'une attibution d'erreur en cas d'imprévu.
    }
    
    public static function getInstance(){ // Définition de la nouvelle instantiation de la DB dans une fonction static afin de n'appelé qu'une fois la même à travers les différents fichiers..
        if(is_null(self::$DBConnexionClassInstance)){    // Si l'instantiation DB est null ;
            self::$DBConnexionClassInstance = new DBconnexion(); // Création de la nouvelle connection.
        }
        return self::$DBConnexionClassInstance;  // Retourne la connection dans la variable d'instance.
    }
    
	
    public function setQuery($query){
            $this->_query = $query;
            $this->_statement=$this->_dbConnexion->prepare($query);
    }

    public function getQuery(){
            return $this->_query;
    }
    
    public function execQuery(){    // DÃ©finition de l'execution de la requÃªte.
        $this->_statement->execute();    // Retourne l'execution dans la variable d'instance.
    }
    
    public function bindVal($input, $variable, $pdoType){ // Définition de la fonctin qui trouvera les valeurs de ces paramètre.
        $this->_statement->bindValue($input, $variable, $pdoType); // Envoie dans l'instance les paramètre trouvé.
    }
	
	/*Retourne un nombre de resultat*/
    public function getResultsN(){
        return $this->_statement->fetchColumn();
    }
    
        /*Retourne un array des resultats*/
    public function getResultsL(){
        return $this->_statement->fetchAll();
    }
}

?>