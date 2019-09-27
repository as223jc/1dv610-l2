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

//die(var_dump($_ENV));

$DB_CONNECTION = new PDO("mysql:host=$DB_HOST;dbname=$DB_DATABASE", $DB_USER, $DB_PASSWORD);

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$rv = new RegisterView();
$dtv = new DateTimeView();
$lv = new LayoutView();
$bIsLoggedIn = !empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;

$oUserController = new UserController($DB_CONNECTION);

if (!empty($_POST['LoginView::Logout'])) {
    $oUserController->logout();
} else if (!empty($_POST['LoginView::Login'])) {
    $oUserController->login(isset($_POST['LoginView::KeepMeLoggedIn']));
} else if (!empty($_POST['RegisterView::Register'])) {
    $oUserController->register();
}

$bRegister = isset($_POST['RegisterView::Register']) || isset($_POST['LoginView::RegisterButton']);

$lv->render($bIsLoggedIn, $v, $dtv, $rv,$_SESSION['error'] ?? $_SESSION['success'] ?? '', $bRegister);

$_SESSION['error'] = '';
$_SESSION['success'] = '';

