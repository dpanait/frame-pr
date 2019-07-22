<?php

class Showterr extends Controller{
public $data = [];
public function __construct($controller, $action){
    parent::__construct($controller, $action);

}
public function indexAction(){
    //dnd($_SESSION);
    
    $dirname = ROOT. DS . "img" . DS . "teritorios" . DS;
    //$dirname = ROOT. DS . "img" . DS . "guada" . DS;
    //echo $dirname;
    //$dirname = "media/images/iconized/";
    //$imgs = array_diff(scandir($dirname), array('..', '.'));//scandir($dirname);
    $imgs = array_diff(scandir($dirname), array('..', '.', '.DS_Store'));
    /*$a_im = scandir($dirname);
    $cont = 4;
    $a_imgs = [];
    foreach($imgs as $img){
        //$img_new  = preg_replace("/[a-z A-Z -.]/","",$img);
        //$img_com = preg_replace("/[a-z A-Z -.]/","",$imgs[$cont]);
        //if($img_new < $img_com){
            $a_imgs[]= $img;
        //}
        $cont++;
    }
    echo "<pre>";
    print_r($imgs);
    echo "</pre>";
    echo "<pre>";
    print_r($a_im);
    echo "</pre>";
    //sort($a_imgs,SORT_NUMERIC);
    usort($imgs, 'strnatcmp');
    echo "<pre>";
    print_r($imgs);
    echo "</pre>";*/
    $data['img'] = $imgs;
    $this->view->render('showterr/index',$data);

}
}