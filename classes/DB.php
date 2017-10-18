<?php  

class DB
{

	private static $_instance = null;
	private $_pdo; 
    private $_query; 
    private $_error = false; 
    private $_results; 
    private $_count = 0;

    /*=====================
       Create connection
    =====================*/
    private function __construct()
    {
    	try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        } catch(PDOException $e) {
        	die($e->getMessage());
        }
    }

    /*=====================
        To instantiate DB using static function
    =====================*/
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }

        return self::$_instance;
    }

    //To be used by other class
    public function getConnection()
    {
        return $this->_pdo;
    }

    /*=====================
        Query function
    =====================*/


}

?>