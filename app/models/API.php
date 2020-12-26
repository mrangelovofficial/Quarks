<?php

class APIModel Extends Model
{
    public function tokenCheck($token)
    {
        //search token
        $params = array(":token" => $token);
        $queryResponse = $this->query("SELECT `userID` FROM `apiaccess` WHERE `token` = :token", $params);
        if(!empty($queryResponse[0]->userID)){
            return $queryResponse[0]->userID;
        }else{
            return false;
        }
    }
}