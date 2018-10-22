<?php
namespace Controller;
use PDO;

class DBconnexion {
    
    private static $DBConnexionClassInstance = null;	//Instance (singleton) de la classe DBConnexion

    private $_dbConnexion = null; //Variable de connexion à la DB
    private $_statement = null; //Variable permettant de gérer les requêtes PDO (prÃ©paration, bindings, exécution)
    private $_query = null;	//la requête que l'utilistaeur souhaite exécuter
    
    const DEFAULT_SQL_DBHOST = "localhost"; // Hébergement.
    const DEFAULT_SQL_DBNAME = "test";  // Nom de la DB.
    const DEFAULT_SQL_DBUSER = "root";  // Nom de l'utilisateur de la DB.
    const DEFAULt_SQL_DBPASS = "";  // Mot de pass de l'utilisateur de la DB. 
    
    private function __construct() { // Définition de la fonction de construction qui initialite la connection à la DB avec, en paramètre, les constantes défini au dessus.
        $this->_dbConnexion = new PDO("mysql:host=".self::DEFAULT_SQL_DBHOST.";dbname=".self::DEFAULT_SQL_DBNAME,self::DEFAULT_SQL_DBUSER,self::DEFAULt_SQL_DBPASS);
        $this->_dbConnexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING); //Définition d'une attibution d'erreur en cas d'imprévu.
    }
    
    public static function getInstance(){ // Définition de la nouvelle instantiation de la DB dans une fonction static afin de n'appelé qu'une fois la même à travers les différents fichiers..
        if(is_null(self::$DBConnexionClassInstance)){    // Si l'instantiation DB est null ;
            self::$DBConnexionClassInstance = new DBconnexion(); // Création de la nouvelle connection.
        }
        return self::$DBConnexionClassInstance;  // Retourne la connection dans la variable d'instance.
    }
   
    public function setQuery($query){   // Cette fonction préparera la requête à envoyé à la DB.
        $this->_query = $query;
        $this->_statement=$this->_dbConnexion->prepare($query);
    }

    public function bindVal($input, $variable, $pdoType){ // Cette fonction sera chargé de trouvé les valeurs à intégré au bonnes colonnes et sous le bon format.
        $this->_statement->bindValue($input, $variable, $pdoType);
    }
    
    public function execQuery($param){  // Cette fonction exécutera la requête qui attend des paramètres.
        $this->_statement->execute($param);
    }
    
    public function exec(){    // Cette fonction exécutera la requête sans attendre de paramètre.
        $this->_statement->execute();
    }
    
    public function getResultsN(){  // Cette fonction retournera les éléments de toutes les colonnes.
        return $this->_statement->fetchColumn();
    }
    
    public function getResultsL(){  // Cette fonction retournera les éléments de la colonne n°1.
        return $this->_statement->fetchColumn(1);
    }
    
    public function load(){ // Cette fonction retounera les données relative à requête.
        return $this->_statement->fetch();
    }
    
    public function rCount(){ // Cette fonction retournera le nombre de ligne correspondant à la requête.
        return $this->_statement->rowCount();
    }
}

?>