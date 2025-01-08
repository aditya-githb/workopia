<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize
{

    /**
     * check if the user is authorized
     * @return bool
     */
    function isAuthorized()
    {
        return Session::check('user');
    }


    /**
     * handle the user request
     * @param string $role
     * 
     * @return bool
     */

    function handle($role)
    {
        if ($role === "guest" && $this->isAuthorized()) {
            return redirect('/');
        }
        else{
            if($role === "auth" && !$this->isAuthorized()){
                return redirect('/auth/login');
            }
        }
    }
}
