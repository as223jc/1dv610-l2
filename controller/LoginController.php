<?php

namespace startup\controller;

use Request;
use startup\model\User;
use startup\service\Auth;
use startup\view\LoginView;

class LoginController {
    private $oUser;
    private $oLoginView;
    private $tMessage;

    public function __construct(User $oUser, LoginView $oLoginView){
        $this->oUser = $oUser;
        $this->oLoginView = $oLoginView;
    }

    /* Route GET /login */
    public function index(Auth $oAuth, LoginView $oLoginView) {
        if ($oAuth->isAuthenticated()) {
            redirect('/');
        }

        return $oLoginView->render();
    }

    /* Route POST /login */
    public function login(Request $oRequest, Auth $oAuth, LoginView $oLoginView) {
        $tUsername = $oRequest->{$oLoginView->getNameId()};
        $tPassword = $oRequest->{$oLoginView->getPasswordId()};
        $bRememberMe = $oRequest->{$oLoginView->getRememberMeId()};

        if (!$this->validateCredentials($tUsername, $tPassword) ||
            !$oAuth->authenticate($tUsername, $tPassword, $bRememberMe)) {
            redirect('login');
        }

        /* Successful login - redirect back home */
        redirect('/');
    }

    /* Route GET /logout */
    public function logout(Auth $oAuth) {
        $oAuth->logOut();
    }

    /* Validate login handle */
    private function validateCredentials($tUsername, $tPassword) {
        if (empty(trim($tUsername))) {
            flash('username', 'Username is missing');
        }

        if (empty(trim($tPassword))) {
            flash('password', 'Password is missing');
        }

        return !empty(trim($tUsername)) && !empty(trim($tPassword));
    }
}
