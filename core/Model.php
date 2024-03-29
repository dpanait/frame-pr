<?php

class Model{
    protected $_db, $_table, $_modelName, $_softDelete = false, $_columnName = [];
    public $id;

    public function __construct($table){
        $this->_db = DB::getInstance();
        $this->_table = $table;
        $this->_setTableColumns();
        $this->_modelName = str_replace(' ','',ucwords(str_replace('_',' ',$this->_table)));
    }

    protected function _setTableColumns(){
        $columns = $this->get_columns();
        foreach($columns as $column){
            $columnName = $column->Field;
            $this->_columnName[] = $column->Field;
            $this->{$columnName} = null;
        }
    }

    public function get_columns(){
        return $this->_db->get_columns($this->_table);
    }

    /*public function find($params = []){
        $results = [];
        $resultsQuery = $this->_db->find($this->_table, $params);
        foreach($resultsQuery as $result){
            $obj = new $this->_modelName($this->_table);
            $obj->populateObjData($resultsQuery);
            $results[] = $obj;
        } 
        return $results;
    }*/
    public function find($params = []){
        $results = [];
        $resultQuery = $this->_db->find($this->_table);
        foreach($resultsQuery as $result){
            $obj = new $this->_modelName($this->_table);
            $obj->populateObjData($resultsQuery);
            $results[] = $obj;
        } 
        return $results;
    }

    public function findFirst($params = []){
        $resultsQuery = $this->_db->findFirst($this->_table, $params);
        
        $result = new $this->_modelName($this->_table);
        
        if($resultsQuery){
            $result->populateObjData($resultsQuery);
            return $result;
        }
        return false;       
    }
    /*public function findFirst($params = []){
        $resultsQuery = $this->_db->findFirst($this->_table, $params);
        //print_r($resultsQuery);die("resultQuery");
        $data = [];

        $result = new $this->_modelName($this->_table);
        //var_dump($result);die("result");
        if($resultsQuery){
            //var_dump($result);die("result");
            $data = $result->populateObjData($resultsQuery);

        }
        /*print_r($result->username);
        echo "<pre>";
        print_r($result);
        echo "</pre>";*
        //var_dump($data);
        //die("find");
        
        return $data;
    }*/

    public function findById($id){
        return $this->findFirst(['condition' =>"id = ?",'bind'=>[$id]]);
    }

    public function save(){
        $fields = [];
        foreach($this->_columnName as $column){
            $fields[$column] = $this->$column; 
        }
        //determine if insert or update
        if(property_exists($this, 'id') && $this->id != ''){
            return $this->update($this->id, $fields);
        }
        else{
            return $this->insert($fields);
        }
    }

    public function data(){
        $data = new stdClass();
        foreach($this->_columnName as $column){
            $data->column = $this->column;
        }
        return $data;
    }

    public function assign($params){
        if(!empty($params)){
            foreach($params as $key => $val){
                if(in_array($key, $this->_columnName)){
                    $this->$key = sanitize($val);
                }
            }
            return true;
        }
        return false;
    }

    public function insert($fields){
        if(empty($fields)) return false; 
        return $this->_db->insert($this->_table, $fields);
    }
    
    public function update($id, $fields){
        if(empty($fields) || $id == '') return false;
        return $this->_db->update($this->_table, $id, $fields);
    }

    public function delete($id = ''){
        if($id == '' && $this->id == '') return false;
        $id = ($id == '')? $this->id : $id;
        if($this->_softDelete){
            return $this->update($id, ['deleted' => 1]);
        }
        return $this->_db->delete($this->_table, $id);
    }

    public function query($sql, $bind = []){
        return $this->_db->query($sql, $bind);
    }
    public function populateObjData($result){
        var_dump($result);
        //die("populate");
        foreach($result as $key => $val){
            $this->$key = $val;
            
        }
    }
/*
    public function populateObjData($result){
        var_dump($result);
        die("populate");
        $data = new stdClass();
        foreach($result as $key => $val){
            //print_r($val);
            //echo PHP_EOL;
            $this->$key = $val;
            $data->$key = $val;
        }
        var_dump($data);
        die("populate");
       
        return $data;
    }*/
}