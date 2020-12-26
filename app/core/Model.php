<?php
require_once "Database.php";

class Model extends Database
{
    //Sanitize(Remove html,whitespace) if ON
    //Set it false in *Model class if you to turn if OFF
    protected $protect = True;

    final protected function query($SQL, $Fields = [])
    {
        $DB = $this->connect();

        //Check for fields and do sanitaze
        if( !empty($Fields) )
        {
            $Fields = $this->sanitizeFields($Fields);
            
            //Check for errors
            if($Fields === False){
                echo 'Bind params are not set correctly';
                die();
            }
        }

        try {
            $query = $DB->prepare($SQL);
            $query->execute($Fields);

            if( $this->isReadable($SQL) )
            {
                return $result = $query->fetchAll(PDO::FETCH_OBJ);
            }
        } catch (Exception $e) {
            die("Query can't be execute correctly");
        }

        return True;
        
    }


    private function sanitizeFields($fields)
    {
        $errors = False;
        $sanitizeFields = [];
        foreach($fields as $bind => $value)
        {
            //Check is bind element
            if(substr($bind, 0, 1) != ':')
            {
                $errors =  True;
                continue;
            }

            //Clean value 
            if($this->protect)
            {
                $value = htmlentities ( trim ( $value ) , ENT_NOQUOTES );
            }

            //Set Up field
            $sanitizeFields[$bind] = $value;
        }

        // Check for errors and return
        return $errors ? false : $sanitizeFields;
    }

    
    private function isReadable($SQL)
    {
        //Split SQL by words
        $SQL_Split = strtolower(explode(' ',$SQL)[0]);
        
        if( $SQL_Split == "select" )
        {
            return true;
        }

        return false;
    }

}