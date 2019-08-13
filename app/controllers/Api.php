<?php
class Api extends Controller {
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->db_multi = DB_MULTI::getInstance();
        $this->api_request = new Apirequest($this->db_multi->_db_bullcard,$this->db_multi->_db_buygest);
    }
    public function indexAction(){
        include("includes/JSONsave.php");
    }

}