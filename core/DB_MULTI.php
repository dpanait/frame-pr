<?php
class DB_MULTI{
    private static $_instance = null;
    public $_db_bullcard,$_db_buygest;
    public function __construct(){
        try{
            $this->_db_bullcard = new PDO('mysql:host='.DB_HOST_BULLCARD.';dbname='.DB_NAME_BULLCARD,DB_USER_BULLCARD,DB_PASSWORD_BULLCARD);
            $this->_db_buygest = new PDO('mysql:host='.DB_HOST_BUYGEST.';dbname='.DB_NAME_BUYGEST,DB_USER_BUYGEST,DB_PASSWORD_BUYGEST);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB_MULTI();
        }
        return self::$_instance;
    }
   
}