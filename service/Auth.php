<?php

namespace startup\service;

use startup\model\User;
use startup\view\LoginView;

class Auth {
    private $oUser;

    public function __construct(User $oUser) {
        $this->oUser = $oUser;
    }

    public function isAuthenticated() {
        return isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true ||
            $this->authWithCookies();
    }

    public function authenticate($tUsername, $tPassword, $bRememberMe) {
        $oUser = $this->oUser->getByUsername($tUsername);

        if (!$oUser || !password_verify($tPassword, $oUser['password'])) {
            flash('username', 'Wrong name or password');
            return false;
        }

        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $tUsername;
        $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
        flash(LoginView::getWelcomeMessageId(), 'Welcome');

        if ($bRememberMe) {
            $tPasswordToken = md5($tUsername . time());
            $this->oUser->saveRememberToken($tUsername, $tPasswordToken);
            setcookie( LoginView::getCookieNameId(), $tUsername);
            setcookie( LoginView::getCookiePasswordId(), $tPasswordToken);
            flash(LoginView::getWelcomeMessageId(), 'Welcome and you will be remembered');
        }

        return true;
    }

    public function logOut() {
        session_destroy();
        session_start();
        setcookie( LoginView::getCookieNameId(), '', -1);
        setcookie( LoginView::getCookiePasswordId(), '', -1);

        flash(LoginView::getLogoutMessageId(), 'Bye bye!');
        redirect('/');
    }

    public function username() {
        return $this->isAuthenticated() ? $_SESSION['username'] : false;
    }

    public function getAuthenticatedUser() {
        if (!$this->isAuthenticated()) {
            return false;
        }

        $aUsers = $this->oUser->findWhere([[
            'username', '=', $this->username()
        ]]);

        return !empty($aUsers) ? $aUsers[0] : false;
    }

    private function authWithCookies() {
        if (empty($tCookieName = $_COOKIE[LoginView::getCookieNameId()] ?? null) ||
            empty($tCookiePassword = $_COOKIE[LoginView::getCookiePasswordId()] ?? null)) {
            return false;
        }

        return $this->authWithToken($tCookieName, $tCookiePassword);
    }

    private function authWithToken($tUsername, $tToken) {
        if (!$this->oUser->checkRememberToken($tUsername, $tToken)) {
            setcookie( LoginView::getCookieNameId(), '');
            setcookie( LoginView::getCookiePasswordId(), '');
            flash(LoginView::getLoginErrorMessageId(), 'Wrong information in cookies');

            return false;
        } else {
            $_SESSION['loggedIn'] = true;
            flash(LoginView::getWelcomeMessageId(), 'Welcome back with cookie');

            return true;
        }
    }
}
