<?php

namespace App\controllers;

class ErrorController
{
    /**
     * Error 404 Page
     * 
     * @return void
     */

    public static function notFound($message = "Page Not Found!!")
    {
        http_response_code(404);
            loadView('error', [
            'status' => 404,
            'message' => $message
        ]);
    }

    /**
     * Error 403 Page
     * 
     * @return void
     */

     public static function notAuth($message = "You are not authorized to this page")
     {
         http_response_code(403);
             loadView('error', [
             'status' => 403,
             'message' => $message
         ]);
     }
}


