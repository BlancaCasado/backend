<?php

class Database
{
    private static $instancia;
    private $db;


    private function __construct()
    {
        //$this->db = rand(1000,2000);
        try{
            $this->db = new PDO(DB_DSN,DB_USER,DB_PASS);
            $this->db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND , 'SET NAMES  \'utf8\'' );
            $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOExceptio $e){
            echo $e->getMessage();
            exit();
        }
    }
    //devueve la connexión.
    public function getDB()
    {
        if (self::$instancia != null) {
          return $this->db;
        }
        return null;
    }
    
    //Crea o devuelve la conexión de base de datos elegida.
    public static function shareConnection()
    {

        if (self::$instancia == null) {

            self::$instancia = new Database();
        }
        return self::$instancia;
    }
}