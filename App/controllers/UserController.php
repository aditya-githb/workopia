<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Validation;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }


    /**
     * Show  the login page
     * 
     * @return void
     */

    function login()
    {
        return loadView('users/login');
    }

    /**
     * Show  the login page
     * 
     * @return void
     */

    function register()
    {
        return loadView('users/register');
    }

    /**
     * Store user in database
     * 
     * @return void
     */

    function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        $error = [];

        if (!Validation::email($email)) $error['email'] = ' Please enter a valid email address';
        if (!Validation::string($name, 2, 50)) $error['name'] = 'Name must be between 2 and 50 characters';
        if (!Validation::string($city, 2, 50)) $error['city'] = 'City must be required';
        if (!Validation::string($state, 2, 50)) $error['state'] = 'State must be required';
        if (!Validation::string($password, 8, 50)) $error['password'] = 'Password length should be 8 or more';
        if (!Validation::match($password, $password_confirmation)) $error['password_conformation'] = 'Password do not match';

        if (!empty($error)) {
            loadView(
                'users/register',
                [
                    'error' => $error,
                    'user' =>
                    [
                        'name' => $name,
                        'email' => $email,
                        'city' => $city,
                        'state' => $state,
                    ]
                ]
            );
        } else {
            $params = [
                'email' => $email,
            ];
            $user = $this->db->query("SELECT * FROM users WHERE email = :email", $params)->fetch();
            if ($user) {
                $error['email'] = 'Email already exists';
                loadView(
                    'users/register',
                    [
                        'error' => $error,
                        'user' =>
                        [
                            'name' => $name,
                            'email' => $email,
                            'city' => $city,
                            'state' => $state,
                        ]
                    ]
                );
                exit;
            }
            $params =[
                'name' => $name,
                'email' => $email,
                'city' => $city ?? null,
                'state' => $state ?? null,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ];

            $this->db->query("INSERT INTO users (name, email, city, state, password) VALUES (:name, :email, :city, :state, :password)", $params);

            // Get new user ID
            $user = $this->db->conn->lastInsertId();

            Session::set('user',[
                'id' => $user,
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'state' => $state,
            ]);

            redirect('/auth/login');

        }
    }

    /**
     * Logout user
     * 
     * @return void
     */

    function logout(){
        Session::destroy('user');
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/');

    }
}
