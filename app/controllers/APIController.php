<?php 
require_once "urlController.php";

class APIController extends Controller
{

    private $requestMethod  =   null;
    private $URLHandler     =   null;
    private $userID         =   null;

    public function __construct()
    {
        $this->auth();
        $this->URLHandler = new URLHandler($this->userID); 

        $this->requestMethod();
    }

    public function index()
    {
     //Menus   
    }

    public function url()
    {
        switch ($this->requestMethod) {
            case 'POST':
                
                $this->URLHandler->postRequest();
                break;
            case 'DELETE':
            
                $this->URLHandler->deleteRequest();
                break;
            case 'GET':
        
                $this->URLHandler->getRequest();
                break;
            
            default:
                http_response_code(503);
                break;
        }
    }

    private function requestMethod()
    {
        $this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    private function auth()
    {
        $headers = getallheaders();
        
        if(isset($headers['X-Auth']) && !empty($headers['X-Auth'])){
            $authToken = $headers['X-Auth'];
            if($this->isValidToken($authToken))
            {
                return true;
            }
        }
        http_response_code(401);
        exit();
    }

    private function isValidToken($authToken)
    {
        $APIModel = $this->model("API");
        $userID = $APIModel->tokenCheck($authToken);

        if($userID != false){
            $this->userID = $userID;
            return true;
        }else{
            return false;
        }
        
    }

}