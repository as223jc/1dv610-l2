<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('model/User.php');
require_once('controller/LoginController.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

if (!isset($_ENV['environment']) || $_ENV['environment'] != 'production') {
    $_ENV['db_host'] = "127.0.0.1";
    $_ENV['db_database'] = "1dv610-l2";
    $_ENV['db_user'] = "root";
    $_ENV['db_password'] = "roooooot";
}

$DB_HOST = $_ENV['db_host'];
$DB_DATABASE = $_ENV['db_database'];
$DB_USER = $_ENV['db_user'];
$DB_PASSWORD = $_ENV['db_password'];

$DB_CONNECTION = new PDO("mysql:host=$DB_HOST;dbname=$DB_DATABASE", $DB_USER, $DB_PASSWORD);

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

