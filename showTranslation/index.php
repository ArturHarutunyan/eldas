<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);
$id = intval($_GET['id']);
if (!isset($_SESSION['user_id']) || !isset($id) || empty($id) || $id<1) {
	header("Location: /");
}

header('Content-type: text/html; charset=utf-8');

require '../incs/config.php';

require '../incs/fns_general.php';

require './Translation.class.php';
global $pdo;
$pdo = db_connect();

$content = new Translation($id);

$content->show();
?>