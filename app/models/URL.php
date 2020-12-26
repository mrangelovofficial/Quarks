<?php

class URLModel Extends Model
{
    public function Exist($urlID)
    {
        //search token
        $params = array(":urlID" => $urlID);
        $queryResponse = $this->query("SELECT `urlID` FROM `urls` WHERE `urlID` = :urlID", $params);
        if(!empty($queryResponse[0]->userID)){
            return true;
        }else{
            return $urlID;
        }
    }


    public function BuildShortURL($urlParams)
    {
        $params = array(
            ":urlID"    =>  $urlParams['urlID'],
            ':userID'   =>  $urlParams['userID'],
            ':urlPointing'   =>  $urlParams['PointingURL']
        );
        $queryResponse = $this->query("INSERT INTO `urls`(`urlID`, `userID`, `urlPointing`) VALUES (:urlID, :userID, :urlPointing)", $params);

    }

    public function deleteURL($urlParams)
    {
        $params = array(
            ":urlID"    =>  $urlParams['urlID'],
            ':userID'   =>  $urlParams['userID'],
        );
        $queryResponse = $this->query("DELETE FROM `urls` WHERE `urlID` = :urlID AND `userID` = :userID", $params);
        //TO DO: Check if user is correct and show message if not
    }

    public function checkOwner($urlParams)
    {
        $params = array(
            ":urlID"    =>  $urlParams['urlID'],
        );
        $queryResponse = $this->query("SELECT `userID` FROM `urls` WHERE `urlID` = :urlID", $params);

        return $queryResponse;
    }

    public function getAll($urlParams)
    {
        $params = array(
            ':userID'   =>  $urlParams['userID'],
        );

        $queryResponse = $this->query("SELECT `urlID`, `urlPointing`, `clicks` FROM `urls` WHERE `userID` = :userID", $params);

        return $queryResponse; 
    }
}