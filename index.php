<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);

header('Content-type: text/html; charset=utf-8');

require './incs/config.php';

require './incs/fns_general.php';


require './classes/Content.class.php';

global $pdo;
$pdo = db_connect();

$content = new Content();

$content->show();
?>