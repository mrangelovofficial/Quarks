<?php
include "Model.php";
class App extends Model
{
    private $controller         =   'HomeController';
    private $controllerClass    =   null;
    private $method             =   'index';
    private $params             =   [];
    private $controllerExt      =   'Controller';

    public function __construct()
    {
        //Get URL
        $url    =   $this->parseUrl();
        
        //Check if controller exist and set it 
        $controllerURL  =   '../app/controllers/'.$url[0].$this->controllerExt.'.php';
        if( file_exists($controllerURL) )
        {
            $this->controller   =   $url[0].$this->controllerExt;
            unset($url[0]);
        }else if($this->checkURLIsQuark($url[0]))
        {
            $redirect = $this->checkURLIsQuark($url[0]);
            
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: ".$redirect); 
            exit();
        }



        //Require and Set the Controller
        $controllerDefaultURL   =   '../app/controllers/'.$this->controller.'.php';
        require_once $controllerDefaultURL;
        
        if(class_exists($this->controller)){
            $this->controllerClass  =    new $this->controller;
        }else{
            http_response_code(401);
            die();
        }

        if(isset($url[1]))
        {
            if(method_exists( $this->controllerClass, $url[1] ))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controllerClass, $this->method], $this->params); 
    }


    private function parseUrl()
    {
        if( isset( $_GET['url'] ) )
        {
            $trim = rtrim($_GET['url'], '/');
            $sanitize = filter_var($trim, FILTER_SANITIZE_URL);
            return $url = explode('/',$sanitize);
        }
        
        //fallback
        return [$this->controller];
    }

    private function checkURLIsQuark($url)
    {
        $params = array(
            ':urlID'   =>  $url,
        );

        $queryResponse = $this->query("SELECT `urlPointing` FROM `urls` WHERE `urlID` = :urlID", $params);

        if(!empty($queryResponse)){
            $urlReturn = $queryResponse[0]->urlPointing;
            return $urlReturn;
        }
        return false;
    }
}