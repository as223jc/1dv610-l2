<?php

namespace startup\controller;

use Request;
use startup\model\User;
use startup\view\RegisterView;

class RegisterController {
    private $oUser;
    private $oRegisterView;

    public function __construct(User $oUser, RegisterView $oRegisterView){
        $this->oUser = $oUser;
        $this->oRegisterView = $oRegisterView;
    }

    /* Route GET /register */
    public function index(RegisterView $oRegisterView) {
        return $oRegisterView->render();
    }

    /* Route POST /register */
    public function register(Request $oRequest) {
        $tUsername = $oRequest->{RegisterView::getNameId()};
        $tPassword = $oRequest->{RegisterView::getNewPasswordId()};
        $tPasswordRepeat = $oRequest->{RegisterView::getNewPasswordRepeatId()};

        if (!$this->validateRegistration($tUsername, $tPassword, $tPasswordRepeat)) {
            redirect('register');
        }

        if ($this->createUser($tUsername, $tPassword)) {
            flash(RegisterView::getRegisterMessageId(), 'Registered new user.');
            setcookie( 'LoginView::CookieName', $tUsername);

            redirect('login');
        } else {
            flash(RegisterView::getUsernameMessageId(), 'User exists, pick another username.');
            redirect('register');
        }
    }

    private function createUser($tUsername, $tPassword) {
        $tPassword = password_hash($tPassword, PASSWORD_BCRYPT);
        return $this->oUser->createUser($tUsername, $tPassword);
    }

    private function validateRegistration($tUsername, $Password, $tPasswordRepeat) {
        $bValid = true;

        if (empty(trim($tUsername)) || strlen($tUsername) < 3) {
            flash(RegisterView::getUsernameMessageId(), 'Username has too few characters, at least 3 characters.');
            $bValid = false;
        } else if (!preg_match('/^[a-zA-Z0-9]+$/', $tUsername)) {
            flash(RegisterView::getUsernameMessageId(), 'Username contains invalid characters.');
            $bValid = false;
        }

        if (empty(trim($Password)) && empty(trim($tPasswordRepeat)) || strlen($Password) < 6) {
            flash(RegisterView::getPasswordMessageId(), 'Password has too few characters, at least 6 characters.');
            $bValid = false;
        } else if (!($Password === $tPasswordRepeat)) {
            flash(RegisterView::getPasswordMessageId(), 'Passwords do not match.');
            $bValid = false;
        }

        return $bValid;
    }
}
