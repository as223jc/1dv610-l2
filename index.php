<?php

require_once('autoload.php');
require_once('bootstrap.php');
require_once('global_functions.php');
require_once('routes/routes.php');

//$oContainer = new Container();

//if (isset($_SESSION['agent']) && $_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT'])) {
//   $_SESSION['loggedIn'] = false;
//}

//$oLoginController = $oContainer->get('LoginController');

$oRequest = new Request();
/* Initiate router and routes */
try {
    $response = $oRouter->matchRoute($oRequest);
    echo $response;
} catch (\Exception $ex) {
    die($ex->getMessage());
}

//die();
////CREATE OBJECTS OF THE VIEWS
//$oLoginView = new LoginView();
//$oRegisterView = new RegisterView();
//$oDateTimeView = new DateTimeView();
//$oLayoutView = new LayoutView();

//$oRegisterController = new RegisterController($oUser, $oRegisterView);
//$oLoginController = new LoginController($oUser, $oLoginView);


//if ((empty($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false) && isset($_COOKIE['LoginView::CookieName']) && isset($_COOKIE['LoginView::CookiePassword'])) {
//    $oLoginController->authWithToken($_COOKIE['LoginView::CookieName'], $_COOKIE['LoginView::CookiePassword']);
//} else if (isset($_POST['LoginView::Logout'])) {
//    $oLoginController->logout();
//} else if (isset($_POST['LoginView::Login'])) {
//    $oLoginController->login(isset($_POST['LoginView::KeepMeLoggedIn']));
//} else if (isset($_POST['RegisterView::Register'])) {
//    $bNewRegistration = $oRegisterController->register();
//}

//$bIsLoggedIn = !empty($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true;
//$bRegister = isset($_GET['register']) ||isset($_POST['RegisterView::Register']) || isset($_POST['LoginView::RegisterButton']);
//
//$tMessage = !empty($oLoginController->getMessage()) ? $oLoginController->getMessage() : $oRegisterController->getMessage();
//$oLayoutView->render($bIsLoggedIn, $oLoginView, $oDateTimeView, $oRegisterView, $tMessage, isset($bNewRegistration) ? !$bNewRegistration : $bRegister);


