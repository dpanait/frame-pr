<?php

class DB{
    private static $_instance = null;
    private $_pdo, $_query, $_error = false, $_result, $_count = 0, $_lastInsertID = null;
    
    public function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    public function query($sql, $params = []){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()){
                $this->_result = $this->_query->fetchALL(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_lastInsertID = $this->_pdo->lastInsertId();
            }
            else{
                $this->_error = true;
            }
        }
        return $this;
    }

    protected function _read($table, $params = []){
        $conditionString = ''; 
        $bind = '';
        $order = '';
        $limit = '';

        //condition
        if(isset($params['conditions'])){
            if(is_array($params['conditions'])){
                foreach($params['conditions'] as $condition){
                    $conditionString .= ' ' .$condition . ' AND';
                }
                $conditionString = trim($conditionString);
                $conditionString = rtrim($conditionString, 'AND');
            }
            else{
                $conditionString = $params['conditions'];
            }
            if($conditionString != ''){
                $conditionString = " WHERE " . $conditionString;
            }
        }
        //echo $conditionString;
        // bind
        if(array_key_exists('bind', $params)){
            $bind = $params['bind'];
        }
        // order
        if(array_key_exists('order',$params)){
            $order = ' ORDER BY ' . $params['order'];
        }
        // limit
        if(array_key_exists('limit',$params)){
            $limit = ' LIMIT ' . $params['limit'];
        }
        $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
        if($this->query($sql,$bind)){
            if(!count($this->_result)) return false;
            return true;
        }
        return false;
    }
    /*
     $data = $db->find('contact',[
            'conditions'=> "name" => "?","address" =>"Carmen Conde"],
            'bind'     =>["Dani"],
            'order'    =>"name,address",
            'limit'    =>5
        ]);
     */

    public function find($table, $params = []){
        if($this->_read($table, $params)){
            return $this->results();
        }
        return false;
    }

    public function findFirst($table, $params = []){
        if($this->_read($table, $params)){
            return $this->first();
        }
        return false;
    }
    /*
    example fields to insert 
    $fields= [
        'name'=>'Jose',
        'phone'=>'7777777',
        'email'=>'jose@gmail.com',
        'address'=>'Guadalajara'
    ];
    */
    public function insert($table, $fields = []){
        $fieldsString = '';
        $valueString = '';
        $values = [];
        foreach($fields AS $field => $value){
            $fieldsString .= '`'. $field . '`,';
            $valueString .='?,';
            $values[]= $value;

        }
        $fieldsString = rtrim($fieldsString, ',');
        $valueString = rtrim($valueString, ',');
        $sql = "INSERT INTO {$table} ({$fieldsString}) VALUES({$valueString})";
        
        if(!$this->query($sql, $values)->error()){
            return true;
        }
        //print_r($value);
        //dnd($sql);
        return false;
    }
    /*
    example fields to update 
    $idField ='idcontact';
    $id = 1;
    $fields= [
        'name'=>'Jose',
        'phone'=>'7777777',
        'email'=>'jose@gmail.com',
        'address'=>'Guadalajara'
    ];
    
    */
    public function update($table, $id, $fields =[]){
        $fieldString = '';
        $values = [];
        foreach($fields as $field => $value){
            $fieldString .= ' ' . $field . '= ?,';
            $values[] = $value;
        }
        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString,',');
        $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
        if(!$this->query($sql, $values)->error()){
            return true;
        }
        return false;
    }
   /*   example fields to update 
        $idField ='idcontact';
        $id = 1;
    */
    public function delete($table, $id){
        $sql = "DELETE FROM {$table} WHERE id = {$id}";
        if(!$this->query($sql)->error()){
            return true;
        }
        return false;
    }

    public function results(){
        return $this->_result;
    }

    public function first(){
        return (!empty($this->_result)) ? $this->_result[0] : []; 
    }

    public function count(){
        return $this->_count;
    }

    public function lastID(){
        return $this->_lastInsertID;
    }

    public function get_columns($table){
        return $this->query("SHOW COLUMNS FROM {$table}")->results();
    }

    public function error(){
        return $this->_error;
    }
}