<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('model/User.php');
require_once('controller/UserController.php');
require_once('view/RegisterView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

if (!isset($_ENV['ENVIRONMENT']) || $_ENV['ENVIRONMENT'] != 'production') {
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
$rv = new RegisterView();
$dtv = new DateTimeView();
$lv = new LayoutView();

$oUserController = new UserController($DB_CONNECTION);

if (isset($_POST['LoginView::Logout'])) {
    $oUserController->logout();
    header('location: index.php');
    exit;
} else if (isset($_POST['LoginView::Login'])) {
    $oUserController->login(isset($_POST['LoginView::KeepMeLoggedIn']));
    header('location: index.php');
    exit;
} else if (isset($_POST['RegisterView::Register'])) {
    $oUserController->register();
}

$bIsLoggedIn = !empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;
$bRegister = isset($_POST['RegisterView::Register']) || isset($_POST['LoginView::RegisterButton']);

$tMessage = !empty($_SESSION['error']) ? $_SESSION['error'] :
    (!empty($_SESSION['success']) ? $_SESSION['success'] : '');

$lv->render($bIsLoggedIn, $v, $dtv, $rv, $tMessage, $bRegister);

unset($_SESSION['error']);
unset($_SESSION['success']);

