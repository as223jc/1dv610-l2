<?php

require_once('autoload.php');
require_once('bootstrap.php');
require_once('global_functions.php');
require_once('routes/routes.php');

$oRequest = new Request();

try {
    /* Attempt to resolve the requested route */
    $response = $oRouter->resolveRoute($oRequest);
    echo $response;
} catch (\Exception $ex) {
    die($ex->getMessage());
}
