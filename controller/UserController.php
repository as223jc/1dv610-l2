<?php

require_once('model/User.php');

class UserController {
    public $oUser;

    public function __construct(PDO $oDB){
        $this->oUser = new User($oDB);
    }

    public function login($bRememberMe) {
        $tUsername = $_POST['LoginView::UserName'] ?? '';
        $tPassword = $_POST['LoginView::Password'] ?? '';

        if (empty(trim($tUsername))) {
            $_SESSION['error'] = 'Username is missing';
            return;
        } else if (empty(trim($tPassword))) {
            $_SESSION['error'] = 'Password is missing';
            return;
        }

        if ($this->userAuthenticated($tUsername, $tPassword)) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['error'] = "Welcome";

            if ($bRememberMe) {
                setcookie( 'rememberMe', true, time() + 3600 * 24 * 30 );
            }
        } else {
            $_SESSION['error'] = 'Wrong name or password<br>';
        }
    }

    public function register() {
        $tUsername = $_POST['RegisterView::UserName'] ?? '';
        $tPassword1 = $_POST['RegisterView::Password'] ?? '';
        $tPassword2 = $_POST['RegisterView::PasswordRepeat'] ?? '';

        if (empty(trim($tUsername) || strlen($tUsername) < 3)) {
            $_SESSION['error'] = 'Username has too few characters, at least 3 characters.';
        } else if (!preg_match('/[^A-Za-z$]/', $tUsername)) {
            $_SESSION['error'] = 'Username contains invalid characters.';
        }  else if (empty(trim($tPassword1)) && empty(trim($tPassword2))) {
            $_SESSION['error'] = 'Password is missing.';
        } else if (strlen($tPassword1) < 6) {
            $_SESSION['error'] = 'Password has too few characters, at least 6 characters.';
        } else if (!($tPassword1 === $tPassword2)) {
            $_SESSION['error'] = 'Passwords do not match.';
        }

        if (!empty($_SESSION['error'])) {
            return;
        }

        if ($this->createUser($tUsername, $tPassword1)) {
            $_SESSION['success'] = 'User created successfully';
        } else {
            $_SESSION['error'] = 'Username already exists';
        }
    }

    public function logout() {
        session_destroy();
        session_start();
        $_SESSION['success'] = 'Bye bye!';
    }

    private function userAuthenticated($tUsername, $tPassword){
        $oUser = $this->oUser->getByUsername($tUsername);

        return $oUser && password_verify($tPassword, $oUser['password']);
    }

    public function createUser($tUsername, $tPassword) {
        $tPassword = password_hash($tPassword, PASSWORD_BCRYPT);
        return $this->oUser->createUser($tUsername, $tPassword);
    }
}
