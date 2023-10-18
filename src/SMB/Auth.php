<?php
/**
 * Created by PhpStorm.
 * User: Dauda Ibrahim
 * Date: 12/10/2023
 * Time: 10:59 PM
 */

namespace App\SMB;


use App\Controller\Users\Users;
use App\DB\Command;
use App\Handlers\DataHandlers;
use App\Handlers\Responses;

class Auth extends Command
{
    protected $auth_cookie = 'SMBAuth';
    protected $session_expiry;

    protected $username;
    protected $password;
    protected $success;

    public $user;
    protected $logger;

    public function __construct()
    {
        $current_time = time();
        $current_date = date("Y-m-d H:i:s", $current_time);
        $this->session_expiry = $current_time + (30 * 24 * 60 * 60);
        parent::__construct();
    }

    public function Auth($params = "")
    {

        $smb = new SMB();
        if (empty($params)) {
            $response = Responses::getResponse('400');
            Responses::displayResponse($response);
        } else {

            extract($params);

            $this->username = DataHandlers::verify_input($username);
            $this->password = DataHandlers::verify_input($password);

            if (empty($this->username)) die('<div class="alert alert-danger py-2 px-3 small">* Enter your username</div>');
            if (empty($this->password)) die('<div class="alert alert-danger py-2 px-3 small">* Enter your password</div>');

            $check_username = Users::User(['username' => $username]);
            if (empty($check_username)) {
                die('<div class="alert alert-danger py-2 px-3 small">* Invalid username, try again!</div>');
            }

            if (!password_verify($this->password, $check_username[0]['password'])) {
                Client::logger([
                    'user' => $username,
                    'full_name' => Users::UserName($username),
                    'class_name' => Client::ClassName($this),
                    'function_name' => Client::ModelName($this),
                    'action' => 'Login',
                    'description' => 'Failed login invalid password'
                ]);
                die('<div class="alert alert-danger py-2 px-3 small">* Invalid password, try again!</div>');
            }

            // @todo: Is create option for remember user login session;)

            $session_token = DataHandlers::generate_random_string(12);

            $login_session = [
                ''
            ];

            $update_params = [
                'tbl_scheme' => $this->users,
                'pkField' => 'username',
                'pk' => $username,
                'login_status' => 1,
                'last_login' => $smb->CurrentTimeStamp()
            ];


            $update_user = $this->updateRecord($update_params);
            if ($update_user['response'] === '200') {

                $session = $this->SetAuth($this->username);

                if (empty($session)) die('<div class="alert alert-danger py-2 px-3 small">* Error: could not login account, try again!</div>');
                Client::logger([
                    'user' => $username,
                    'full_name' => Users::UserName($username),
                    'class_name' => Client::ClassName($this),
                    'function_name' => Client::ModelName($this),
                    'action' => 'Login',
                    'description' => 'Successful login'
                ]);
                die('<script>location.replace("' . DASHBOARD . '")</script>');

            }
            //$response = "";

        }

        //return $response;
    }

    public function AuthUser()
    {
        if (isset($_COOKIE[$this->auth_cookie])) {
            $this->username = $_COOKIE[$this->auth_cookie];
            $user = Users::User(['username' => $this->username]);
            if (!empty($user)) {
                return DataHandlers::convertObj($user[0]);
            }
        }
    }

    public function AuthName()
    {
        $Auth = $this->AuthUser();
        return trim($Auth->first_name . ' ' . $Auth->last_name);
    }

    public function SetAuth($params = "")
    {
        $response = 0;
        if (!empty($params)) {
            $resp = setcookie($this->auth_cookie, $params, $this->session_expiry);
            if ($resp) {
                $response = 1;
            }
        }
        return $response;
    }

    public function ExitAuth()
    {
        if (isset($_COOKIE[$this->auth_cookie])) {
            $smb = new SMB();
            $username = $_COOKIE[$this->auth_cookie];
            $update_params = [
                'tbl_scheme' => $this->users,
                'pkField' => 'username',
                'pk' => $username,
                'login_status' => 0,
                'last_seen' => $smb->CurrentTimeStamp()
            ];
            $update_user = $this->updateRecord($update_params);
            if ($update_user['response'] === '200') {
                Client::logger([
                    'user' => $username,
                    'full_name' => Users::UserName($username),
                    'class_name' => Client::ClassName($this),
                    'function_name' => Client::ModelName($this),
                    'action' => 'Logout',
                    'description' => 'Successful Logout'
                ]);
                $_COOKIE[$this->auth_cookie] = "";
                setcookie($this->auth_cookie, '', time() - 3600);
            }
            die('<script>location.replace("' . ADMIN_LOGIN . '")</script>');
        }
    }

    public function CheckAuth()
    {
        if (!isset($_COOKIE[$this->auth_cookie]) || empty($this->AuthUser())) {
            die('<script>location.replace("' . ADMIN_LOGIN . '")</script>');
        }
    }

    public function ReturnDashboard()
    {
        if (isset($_COOKIE[$this->auth_cookie])) {
            die('<script>location.replace("' . DASHBOARD . '")</script>');
        }
    }

}