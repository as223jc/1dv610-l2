<?php

require_once('model/User.php');

class UserController {
    public $oUser;

    public function __construct(PDO $oDB){
        $this->oUser = new User($oDB);
    }

    public function login($bRememberMe) {
        $_SESSION['error'] = '';
        $tUsername = $_POST['LoginView::UserName'] ?? '';
        $tPassword = $_POST['LoginView::Password'] ?? '';

        if (empty(trim($tUsername))) {
            $_SESSION['error'] .= 'Username is missing<br>';
        }

        if (empty(trim($tPassword))) {
            $_SESSION['error'] .= 'Password is missing<br>';
        }

        if (!empty($_SESSION['error'])) {
            return;
        }

        if ($this->userAuthenticated($tUsername, $tPassword)) {
            $_SESSION['loggedIn'] = true;

            if ($bRememberMe) {
                setcookie( 'rememberMe', true, time() + 3600 * 24 * 30 );
            }

            header("location: index.php");
        } else {
            $_SESSION['error'] .= 'Wrong name or password<br>';
        }
    }

    public function register() {
        $_SESSION['error'] = '';
        $tUsername = $_POST['RegisterView::UserName'] ?? '';
        $tPassword1 = $_POST['RegisterView::Password'] ?? '';
        $tPassword2 = $_POST['RegisterView::PasswordRepeat'] ?? '';

        if (empty(trim($tUsername))) {
            $_SESSION['error'] .= 'Username is missing<br>';
        }

        if (empty(trim($tPassword1)) && empty(trim($tPassword2))) {
            $_SESSION['error'] .= 'Password is missing<br>';
        }

        if (!($tPassword1 === $tPassword2)) {
            $_SESSION['error'] .= 'Passwords do not match<br>';
        }

        if (!empty($_SESSION['error'])) {
            return;
        }

        if ($this->createUser($tUsername, $tPassword1)) {
            $_SESSION['success'] = 'User created successfully';
            header("location: index.php");
        } else {
            $_SESSION['error'] = 'Username already exists';
        }
    }

    public function logout() {
        $_SESSION['success'] = 'You are now logged out';
        $_SESSION['loggedIn'] = false;
        header("location: index.php");
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
