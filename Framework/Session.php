<?php

namespace Framework;

class Session
{

    /**
     * Start the session
     * 
     * @return void
     */

    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * set a session key/value pair
     * 
     * @param  string $key
     * @param mixed $value
     * @return void
     */
    static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get a session variable value
     * @param string $key
     * @param mixed $default
     * @return mixed
     */

    static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * check a session key exists
     * @param string $key
     * @return bool
     */

    static function check($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * unset session key
     * @param string $key
     * @return void
     */

    static function clear($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * destroy the session
     * 
     * @return void
     */

    static function destroy()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
    }
}
