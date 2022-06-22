<?php
require_once('../autoload.php');

class Connect {

    private $Conn;

    private function __construct() {}

    /**
     * Retorna a conexão PDO
     * @return PDO
     */
    public static function getInstance() {
        if (!isset(self::$Conn)) {
            self::setConnection();
        }
        return self::$Conn;
    }

    /**
     * Define a conexão PDO
     */
    private static function setConnection() {
        try {  
            $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', 
                            PDO::ATTR_PERSISTENT         => TRUE,
                            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION);
  
            self::$Conn = new PDO(DRIVER.
                                 ":host=" . HOST . 
                                 "; dbname=" . DBNAME . 
                                 "; charset=" . CHARSET . 
                                 ";", USER, PASSWORD, 
                                 $opcoes);  
  
          } catch (PDOException $e) {  
            print "DB Error: " . $e->getMessage();  
          }
    }

}