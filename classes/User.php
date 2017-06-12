<?php

/**
 * Created by PhpStorm.
 * User: developer1
 * Date: 6/12/17
 * Time: 4:29 PM
 */
class User
{
    private $db;
    private $mf;

    public function __construct()
    {
        $this->db = new DB();
        $this->mf = new Masterfile();
    }

    /**
     * Create User account
     */
    public function store(){
        $email = $_POST['email'];
        $pass1 = $_POST['password'];
        $pass2 = $_POST['password2'];

        if($pass1 === $pass2){
            $pass_hash = sha1($pass1);

            // create masterfile
            $mf_id = $this->mf->store();
            if($mf_id){
                // create user login account
                $saved = $this->db->query('INSERT INTO users(email, password, masterfile_id)
                    VALUES(:email, :pass, :mf)', array(
                        'email' => $email,
                        'pass' => $pass_hash,
                        'mf' => $mf_id
                    ));

                if($saved){
                    $_SESSION['success'] = 'You have been registered successfully. You may now login.';
                }
            }
        } else {
            $_SESSION['error'] = 'Passwords do not match!';
        }
    }

    /**
     * Authenticates and logs in a user
     */
    public function userLogin($email, $password){
        // check if the user exists in db
        $user = $this->db->query('SELECT * FROM users WHERE email = :email AND password = :password', array(
            'email' => $email,
            'password' => sha1($password)
        ));

        if(count($user)){
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user[0]['id'];
        } else {
            $_SESSION['error'] = 'Wrong credentials! Try again!';
        }
    }

    public function isLoggedIn(){
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
            return true;
        else
            return false;
    }

    public function logout(){
        session_destroy();
        header('Location: index.php');
    }
}