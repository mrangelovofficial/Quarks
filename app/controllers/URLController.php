<?php

class URLHandler extends Controller
{

    private $userID = null;
    private $freeURL = null;

    public function __construct($user)
    {
        $this->userID = $user;
    }

    public function postRequest()
    {
        //Get data and validate it
        $jsonRAW        =   file_get_contents('php://input');
        $json           =   $this->isJSON($jsonRAW);
        $this->validateJSON($json, "POST");
        $userID         =   $this->userID;
        $PointingURL    =   $json->PointingURL;

        
        //Validate pointing URL
        $this->isValidURL($PointingURL);

        $URLModel   =   $this->model("URL");

        $this->incrementalHash();
        $URL_ID = $this->freeURL;
        $urlParams = array(
            'urlID'         =>  $URL_ID,
            'userID'        =>  $userID,
            'PointingURL'   =>  $PointingURL
        );
        
        $URLModel->BuildShortURL($urlParams);
        $domainReturn = 'https://quarks.ga/'.$URL_ID;
        $this->jsonResponse([],"You create your url successfully",array("QuarksURL"       => $domainReturn));
              
    }

    public function getRequest()
    {
        $URLModel       =   $this->model("URL");

        $urlParams = array(
            'userID'    =>  $this->userID
        );

        $listOfPages    =   $URLModel->getAll($urlParams);
        if( !empty($listOfPages) ){
            $this->jsonResponse([],"",array("url"   =>  $listOfPages));
        }

    }

    public function deleteRequest()
    {
        //Get JSON and verify it
        $jsonRAW        =   file_get_contents('php://input');
        $json           =   $this->isJSON($jsonRAW);
        $urlParams      =   $this->validateJSON($json, "DELETE");
        $userID         =   $this->userID;
        
        $URLModel       =   $this->model("URL");

        //Check is URL exist
        $urlParamsOwner =   array('urlID'         =>  $json->QuarksURL);

        if( empty($URLModel->checkOwner($urlParamsOwner)) )
        {
            $msg    =   $json->QuarksURL . ' url don\'t exist.';
            $this->jsonResponse(array($msg), "", "", "400");
        }

        //Check is user is correct
        $feedbackUser   =   $URLModel->checkOwner($urlParamsOwner)[0]->userID;
        if( $feedbackUser   !=  $userID)
        {
            $msg    =  'You have no rights over the URL.';
            $this->jsonResponse(array($msg), "", "", "400");
        }
        
        //Delete URL and responde successfully
        $urlParams = array(
            'urlID'         =>  $json->QuarksURL,
            'userID'        =>  $userID
        );
        $URLModel->deleteURL($urlParams);
        
        $this->jsonResponse([], 'Your URL was successfully deleted');
    }

    private function validateJSON($json, $request)
    {
        switch($request)
        {
            case 'DELETE':
                $acceptable =   ['QuarksURL'];
                foreach($json as $objectName => $objectValue)
                {
                    if(!in_array($objectName, $acceptable))
                    {
                        $this->jsonResponse(array("DELETE request accept only QuarksURL param"), "", "", "400");
                    }
                }
                break;

            case 'POST':
                $acceptable =   ['PointingURL'];
                foreach($json as $objectName => $objectValue)
                {
                    if(!in_array($objectName, $acceptable))
                    {
                        $this->jsonResponse(array("POST request accept only PointingURL param"), "", "", "400");
                    }
                }
                break;
        }
    }

    private function isJSON($jsonRAW)
    {
        $json = json_decode($jsonRAW);

        if(json_last_error() == JSON_ERROR_NONE)
        {
            if(!empty((array)$json))
            {
                return $json;
            }
        }

        http_response_code(400);
        exit();
    }

    private function incrementalHash()
    {
        $URLModel   =   $this->model("URL");

        $charset    =   "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $base       =   strlen($charset);
        $result     =   '';
      
        $now = explode(' ', microtime())[1];
        while ($now >= $base)
        {
          $i        =   $now % $base;
          $result   =   $charset[$i] . $result;
          $now      /=  $base;
        }

        $FinalValue =   substr($result, -5);

        if($URLModel->Exist($FinalValue) === true)
        {
            $this->incrementalHash();
        }else{
            $this->freeURL  =   $URLModel->Exist($FinalValue);
        }
    }

    private function jsonResponse($error = array(),$success = "",$addictional = "",$status = "200")
    {

        $data   =   [];
        if(!empty($success)){$data['success']   =   $success;}
        if(!empty($error)){$data['error']       =   $error;}
        if(!empty($addictional)){$data[]        =   $addictional;}

    
        header('Content-Type: application/json');
        echo json_encode($data);  
        http_response_code($status);
        die();
    }

    private function isValidURL($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            $msg    =   'URL address is not valid';
            $this->jsonResponse( array($msg), "", "", "400");
        }else{
            return true;
        }
    }
}
