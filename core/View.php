<?php

class View{
    protected $_head, $_body, $_siteTitle = SITE_TITLE, $_ouputBuffer, $_layout = DEFAULT_LAYOUT;
    public $_viewName = null, $_actionName = null;

    public function __construct(){

    }
    public function render($viewName,$data = []){
        //print_r($data);
        $viewArray = explode('/',$viewName);
        $viewString = implode(DS, $viewArray);
        extract($data);
        if(file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')){
            $this->setViewName((explode("/",$viewString)[0]));
            $this->setActionName((explode("/",$viewString)[1]));
            include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
            include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' .DS . $this->_layout . '.php');
            
        }else {
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
        //extract(get_object_vars(new View()), EXTR_OVERWRITE);
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
    public function setViewName($viewName){
        $this->_viewName = $viewName;
    }
    public function ViewName(){
        return strtolower($this->_viewName);
    }
    public function ActionName(){
        return strtolower($this->_actionName);
    }
    public function setActionName($actionName){
        $this->_actionName = $actionName;
    }
}