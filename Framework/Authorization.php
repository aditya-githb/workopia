<?php

namespace Framework;

use Framework\Session;
class Authorization{
    /**
     * check if the user owns a resourse
     * 
     * @param object $id
     * @return void
     */

    static function isOwner($resourceID){
        $sessionUser = Session::get('user');

        if($sessionUser != null && isset($sessionUser['id'])){
            $sessionUserID = (int)$sessionUser['id'];
            return $sessionUserID === $resourceID;
        }
        return false;
    }
}
?>