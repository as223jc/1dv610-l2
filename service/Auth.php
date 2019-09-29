<?php

namespace startup\service;

use startup\model\User;

class Auth {
    private $oUser;

    public function __construct(User $oUser) {
        $this->oUser = $oUser;
    }

    public function isAuthenticated() {
        return isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;
    }

    public function authenticate($tUsername, $tPassword, $bRememberMe) {
        $oUser = $this->oUser->getByUsername($tUsername);

        if (!$oUser || !password_verify($tPassword, $oUser['password'])) {
            flash('username', 'Wrong name or password');
            return false;
        }

        $_SESSION['loggedIn'] = true;
        $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

//        $this->tMessage = "Welcome";

        if ($bRememberMe) {
//            $this->tMessage = "Welcome and you will be remembered";
            $tPasswordToken = md5($tUsername . time());
            $this->oUser->saveRememberToken($tUsername, $tPasswordToken);
            setcookie( 'LoginView::CookieName', $tUsername);
            setcookie( 'LoginView::CookiePassword', $tPasswordToken);
        }

        return true;
    }

    public function logOut() {
        setcookie( 'LoginView::CookieName', '', -1);
        setcookie( 'LoginView::CookiePassword', '', -1);
        unset($_SESSION['loggedIn'], $_SESSION['agent']);

        redirect('home');
    }

    public function username() {
        return $this->isAuthenticated() ? $_SESSION['username'] : false;
    }
}
