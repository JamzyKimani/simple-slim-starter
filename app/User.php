<?php

namespace App;

use Exception;
use Medoo\Medoo;

class User
{
    public function __construct()
    {
        
    }
    
    /**
     * fetch a single user row on the users_tb using a unique field
     *
     * @param string $field ['username' | 'user_id'] name of unique field you want to reference, 
     * @param array $value unique value of the field that identifies the relevant member 
     * @return mixed
     */
    public static function fetchByUniqueField ($field, $value)
    {
        $db = container(Medoo::class);
        $uniqueFields = [ 'username', 'user_id' ]; 

        if( !in_array($field, $uniqueFields) ) 
        {
            throw new Exception ( "The first parameter of the fetchByUniqueField method only accepts: ". implode (',', $uniqueFields) );
        }

        $user = $db->get("users_tb", '*', [
			$field => $value,
		]);

        if(empty($db->error))
        {
            return $user;
        } else {
            throw new Exception ( $db->error );
        }
        
    }

    /**
     * Update user details
     *
     * @param array $data array of data you need to update on the users_tb, 
     * @param array $where array of where parameters (reference Medoo documentation)
     * @return bool
     */
    public static function update ($data, $where)
    {
        $db = container(Medoo::class);
        $db->update("users_tb", $data, $where);

        if(empty($db->error))
        {
            return true;
        } else {
            throw new Exception ( $db->error );
        }
        
    }

}