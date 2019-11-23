<?php
/*$con=mysql_connect("localhost","simpeg", "Madangkara2017");
if (!$con){ die('Could not connect: ' . mysql_error()); }
mysql_select_db("simpeg", $con);*/

class DatabaseGaji {
    private $_connection;
    private static $_instance; //The single instance
    private $_host = "10.10.8.119"; //119
    private $_username = "admin";
    private $_password = "admin";
    private $_database = "dbgajido";
    private $_port = "3000";
    private $conStatus = false;
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {
        if(!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    private function __construct() {
        error_reporting(0);
        $this->_connection = new mysqli($this->_host, $this->_username,
            $this->_password, $this->_database, $this->_port);

        // Error handling
        error_reporting(1);
        if($this->_connection->connect_errno) {
            //trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(), E_USER_ERROR);
            //die('Connect Error: ' . $this->_connection->connect_error);
            $this->conStatus = false;
        }else{
            $this->conStatus = true;
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }

    // Get mysqli connection
    public function getConnection() {
        return $this->_connection;
    }

    public function getConnGajiStatus(){
        return $this->conStatus;
    }

    public function getIsServerAlive(){
        if($this->_connection->ping()) {
            return true;
        }else{
            return false;
        }
    }

    public function closeConnGaji(){
        return $this->_connection->close();
    }
}

?>