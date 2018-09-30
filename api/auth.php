<?php
$realm = 'Restricted area';

// U & P
$user = "api";
$password = "e74f9ee37efd495d835d1bdbb71fa4a484033109";

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Text to send if user hits Cancel button';
    exit;
} 

if($_SERVER['PHP_AUTH_USER'] != $user or $_SERVER['PHP_AUTH_PW'] != $password)
{
    header('HTTP/1.0 401 Unauthorized');
    echo "wrong credentials";
    exit;
}