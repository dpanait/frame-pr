<?php

class View{
    protected $_head, $_body, $_siteTitle = SITE_TITLE, $_ouputBuffer, $_layout = DEFAULT_LAYOUT;

    public function __construct(){

    }
    public function render($viewName,$data = []){
        //print_r($data);
        $viewArray = explode('/',$viewName);
        $viewString = implode(DS, $viewArray);
        if(file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')){
            include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
            include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' .DS . $this->_layout . '.php');
            
        } 
        else
        {
            die('The view \"'. $viewName .'\" does not exist');
        } 
    }
    public function content($type){
        if($type == 'head'){
            return $this->_head;
        } elseif($type == 'body'){
            return $this->_body;
        }
        return false;
    }
    public function start($type){
        $this->_ouputBuffer = $type;
        ob_start();
    }
    public function end(){
        if($this->_ouputBuffer == 'head'){
            $this->_head = ob_get_clean();
        } elseif ($this->_ouputBuffer == 'body'){
            $this->_body = ob_get_clean();
        } else {
            die('You must first run start method.');
        }

    }
    public function siteTitle(){
        return $this->_siteTitle;
    }
    public function setSiteTitle($title){
        $this->_siteTitle = $title;
    }
    public function setLayout($path){
        $this->_layout = $path;
    }
}