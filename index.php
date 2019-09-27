<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('model/User.php');
require_once('controller/LoginController.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

die(var_dump($_ENV));
$DB_HOST = "mysql:host=127.0.0.1;dbname=1dv610-l2";
$DB_USER = "root";
$DB_PASSWORD = "roooooot";
$DB_CONNECTION = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();
$bIsLoggedIn = !empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;

$oLoginController = new LoginController($DB_CONNECTION);

if (!empty($_POST['LoginView::Logout'])) {
    $oLoginController->logout();
} else if (!empty($_POST['LoginView::Login'])) {
    $oLoginController->login(isset($_POST['LoginView::KeepMeLoggedIn']));
} else if (!empty($_POST['LoginView::Register'])) {
    $oLoginController->register();
}

$bRegister = isset($_POST['LoginView::RegisterButton']) || isset($_POST['LoginView::Register']);
echo ($_SESSION['success'] ?? '');
$lv->render($bIsLoggedIn, $v, $dtv, $_SESSION['error'] ?? '', $bRegister);

$_SESSION['error'] = '';
$_SESSION['success'] = '';

