<?php
$oRouter = new Router();

$oRouter->get('', 'startup\\controller\\HomeController@index');

$oRouter->get('login', 'startup\\controller\\LoginController@index');
$oRouter->post('login', 'startup\\controller\\LoginController@login');
$oRouter->post('logout', 'startup\\controller\\LoginController@logout');

$oRouter->get('register', 'startup\\controller\\RegisterController@index');
$oRouter->post('register', 'startup\\controller\\RegisterController@register');
