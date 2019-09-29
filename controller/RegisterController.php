<?php

namespace startup\controller;

use Request;
use startup\model\User;
use startup\view\DateTimeView;
use startup\view\LayoutView;
use startup\view\LoginView;
use startup\view\RegisterView;

class RegisterController {
    private $oUser;
    private $oRegisterView;
    private $tMessage;

    public function __construct(User $oUser, RegisterView $oRegisterView){
        $this->oUser = $oUser;
        $this->oRegisterView = $oRegisterView;
    }

    public function index(LayoutView $oLayoutView, LoginView $oLoginView, RegisterView $oRegisterView, DateTimeView $oDateTimeView) {
        return $oLayoutView->render(false, $oRegisterView, $oDateTimeView, '');

        dd('register');
    }

    public function register(Request $oRequest) {
//        $tUsername = $_POST['RegisterView::UserName'] ?? '';
//        $tPassword1 = $_POST['RegisterView::Password'] ?? '';
//        $tPassword2 = $_POST['RegisterView::PasswordRepeat'] ?? '';
        dd('register');

        if (empty(trim($tUsername)) || strlen($tUsername) < 3) {
            $this->tMessage = 'Username has too few characters, at least 3 characters.<br>';
        } else if (!preg_match('/^[a-zA-Z0-9]+$/', $tUsername)) {
            $this->tMessage = 'Username contains invalid characters.<br>';
        }

        if (empty(trim($tPassword1)) && empty(trim($tPassword2)) || strlen($tPassword1) < 6) {
            $this->tMessage .= 'Password has too few characters, at least 6 characters.<br>';
        } else if (!($tPassword1 === $tPassword2)) {
            $this->tMessage .= 'Passwords do not match.<br>';
        }

        if (!empty($this->tMessage)) {
            return false;
        }

        if ($this->createUser($tUsername, $tPassword1)) {
            $this->tMessage = 'Registered new user.';
            $_POST['LoginView::UserName'] = $tUsername;
            return true;
        } else {
            $this->tMessage = 'User exists, pick another username.';
            return false;
        }
    }

    public function createUser($tUsername, $tPassword) {
        $tPassword = password_hash($tPassword, PASSWORD_BCRYPT);
        return $this->oUser->createUser($tUsername, $tPassword);
    }

    public function getMessage() {
        return $this->tMessage;
    }

    private function renderView() {

    }
}
