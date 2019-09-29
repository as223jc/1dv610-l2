<?php

require_once('model/User.php');

class UserController {
    public $oUser;
    public $tMessage;

    public function __construct(PDO $oDB){
        $this->oUser = new User($oDB);
    }

    public function login($bRememberMe) {
        $tUsername = $_POST['LoginView::UserName'] ?? '';
        $tPassword = $_POST['LoginView::Password'] ?? '';

        if (empty(trim($tUsername))) {
            $this->tMessage = 'Username is missing';
            return;
        } else if (empty(trim($tPassword))) {
            $this->tMessage = 'Password is missing';
            return;
        }

        if ($this->userAuthenticated($tUsername, $tPassword)) {
            $_SESSION['loggedIn'] = true;
            $this->tMessage = "Welcome";

            if ($bRememberMe) {
                $this->tMessage = "Welcome and you will be remembered";
                $tPasswordToken = md5($tUsername . time());
                $this->oUser->saveRememberToken($tUsername, $tPasswordToken);
                setcookie( 'username', $tUsername);
                setcookie( 'password', $tPasswordToken);
            }

        } else {
            $this->tMessage = 'Wrong name or password<br>';
        }
    }

    public function register() {
        $tUsername = $_POST['RegisterView::UserName'] ?? '';
        $tPassword1 = $_POST['RegisterView::Password'] ?? '';
        $tPassword2 = $_POST['RegisterView::PasswordRepeat'] ?? '';

        if (empty(trim($tUsername)) || strlen($tUsername) < 3) {
            $this->tMessage = 'Username has too few characters, at least 3 characters.';
        } else if (!preg_match('/[A-Za-z]/', $tUsername)) {
            $this->tMessage = 'Username contains invalid characters.';
        }  else if (empty(trim($tPassword1)) && empty(trim($tPassword2)) || strlen($tPassword1) < 6) {
            $this->tMessage = 'Password has too few characters, at least 6 characters.';
        } else if (!($tPassword1 === $tPassword2)) {
            $this->tMessage = 'Passwords do not match.';
        }

        if (!empty($this->tMessage)) {
            return false;
        }

        if ($this->createUser($tUsername, $tPassword1)) {
            $this->tMessage = 'Registered new user';
            return true;
        } else {
            $this->tMessage = 'User exists, pick another username.';
            return false;
        }
    }

    public function logout() {
        session_destroy();
        setcookie( 'username', '');
        setcookie( 'password', '');
        session_start();
        $this->tMessage = 'Bye bye!';
    }

    private function userAuthenticated($tUsername, $tPassword){
        $oUser = $this->oUser->getByUsername($tUsername);

        return $oUser && password_verify($tPassword, $oUser['password']);
    }

    public function createUser($tUsername, $tPassword) {
        $tPassword = password_hash($tPassword, PASSWORD_BCRYPT);
        return $this->oUser->createUser($tUsername, $tPassword);
    }

    public function authWithToken($tUsername, $tToken) {
        if (!$this->oUser->checkRememberToken($tUsername, $tToken)) {
            $this->tMessage = 'Wrong information in cookies';
        } else {
            $_SESSION['loggedIn'] = true;
            $this->tMessage = "Welcome back with cookie";
        }
    }
}
