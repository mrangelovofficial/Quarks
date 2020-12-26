<?php

class Controller {

    private $modelExt = 'Model';

    final protected function model($model){
        //Formatting
        $model      =   $model;
        $modelExt   =   $model.$this->modelExt;
        $modelURL   =   "../app/models/".$model.".php";

        //File Check and Validation
        if( !file_exists($modelURL) )
        {
            die("Model ".$model." don't exist");
        }

        //Setting
        require_once $modelURL;
        return new $modelExt;
    }

    final protected function view($view, $data = []){
        //Formatting
        $view       =   strtolower($view);
        $viewUrl    =   "../app/views/".$view.".php";

        //File Check and Validation
        if( !file_exists($viewUrl) )
        {
            die("View ".$view." don't exist");
        }

        //Setting
        if( !empty($data) )
        {
            extract($data, EXTR_OVERWRITE);
        }
        require_once $viewUrl;
        die();
    }
    
}