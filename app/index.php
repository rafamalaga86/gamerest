<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

foreach (glob("library/*.php") as $filename){
    require $filename;
}


$server = $_SERVER;

require __DIR__ . '/config/database.php';  // It brings the database details

$db = new DatabaseConnection($host, $database, $user, $password);

$request = new Request($server);
$request->process($db);
