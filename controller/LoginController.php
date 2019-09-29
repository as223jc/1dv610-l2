<?php

namespace startup\controller;

use Request;
use startup\model\User;
use startup\service\Auth;
use startup\view\DateTimeView;
use startup\view\LayoutView;
use startup\view\LoginView;

class LoginController {
    private $oUser;
    private $oLoginView;
    private $tMessage;

    public function __construct(User $oUser, LoginView $oLoginView){
        $this->oUser = $oUser;
        $this->oLoginView = $oLoginView;
    }

    public function index(LoginView $oLoginView) {
        $tMessage = $_SESSION['message'] ?? '';

        return $oLoginView->render('axaxax');
    }

    public function login(Request $oRequest, Auth $oAuth) {
        $tUsername = $oRequest->post('LoginView::UserName');
        $tPassword = $oRequest->post('LoginView::Password');
        $bRememberMe = $oRequest->post('LoginView::RememberMe');

        if (!$this->validateHandle($tUsername, $tPassword)) {
            redirect('login');
        }
//
//        if (empty(trim($tUsername))) {
//            $this->tMessage = 'Username is missing';
//            return;
//        } else if (empty(trim($tPassword))) {
//            $this->tMessage = 'Password is missing';
//            return;
//        }

        if (!$oAuth->authenticate($tUsername, $tPassword, $bRememberMe)) {
            redirect('login');
        }
dd($_SERVER);
        redirect('');

//        dd($tUsername, $tPassword);
//
//        if ($this->userAuthenticated($tUsername, $tPassword)) {
//            $_SESSION['loggedIn'] = true;
//            $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
//
//            $this->tMessage = "Welcome";
//
//            if ($bRememberMe) {
//                $this->tMessage = "Welcome and you will be remembered";
//                $tPasswordToken = md5($tUsername . time());
//                $this->oUser->saveRememberToken($tUsername, $tPasswordToken);
//                setcookie( 'LoginView::CookieName', $tUsername);
//                setcookie( 'LoginView::CookiePassword', $tPasswordToken);
//            }
//
//        } else {
//            $this->tMessage = 'Wrong name or password<br>';
//        }
    }

    public function logout() {
        session_destroy();
        setcookie( 'LoginView::CookieName', '');
        setcookie( 'LoginView::CookiePassword', '');
        session_start();
        flash('logout', 'Bye bye!');
        echo "Hej";
        redirect('');
        echo "Då";
//        $this->tMessage = 'Bye bye!';
    }

    private function userAuthenticated($tUsername, $tPassword){
        $oUser = $this->oUser->getByUsername($tUsername);

        return $oUser && password_verify($tPassword, $oUser['password']);
    }

    public function authWithToken($tUsername, $tToken) {
        if (!$this->oUser->checkRememberToken($tUsername, $tToken)) {
            setcookie( 'LoginView::CookieName', '');
            setcookie( 'LoginView::CookiePassword', '');
            $this->tMessage = 'Wrong information in cookies';
        } else {
            $_SESSION['loggedIn'] = true;
            $this->tMessage = "Welcome back with cookie";
        }
    }

    public function getMessage() {
        return $this->tMessage;
    }

    private function renderView() {

    }

    /* Validate login handle */
    private function validateHandle($tUsername, $tPassword) {
        if (empty(trim($tUsername))) {
            flash('username', 'Username is missing');
        }

        if (empty(trim($tPassword))) {
            flash('password', 'Password is missing');
        }

        return !empty(trim($tUsername)) && !empty(trim($tPassword));
    }
}
