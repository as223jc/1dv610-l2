<?php

/* Pretty var_dump variable and stop (die) execution */
function dd() {
    echo "<pre>";
    var_dump(...func_get_args());
    echo "</pre>";
    die();
}

/* Helper function to create a new class with the container */
function createClass($tClass) {
    $oContainer = new Container();
    return $oContainer->resolve($tClass);
}

/* Redirect to a new url */
function redirect($to) {
    if (empty($to)) {
//        $to = $_SERVER['HTTP_REFERER'];
    }

    header("location: $to");
    exit();
}
/* Get or Set a flash message to display after reload */
function flash($key, $value = '') {
    if (!empty($value)) {
        if (empty($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        return $_SESSION['flash'][$key] = $value;
    }

    $aFlashMessages = $_SESSION['flash'] ?? [];

    if (!$key) {
        $_SESSION['flash'] = [];

        return implode('<br>', $aFlashMessages);
    } else if (!isset($aFlashMessages[$key])) {
        return '';
    }

    unset($_SESSION['flash'][$key]);
    return $aFlashMessages[$key];
}
