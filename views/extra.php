<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../src/users.php';
$u = new Users();
$u->deleteAccount(1);
?>