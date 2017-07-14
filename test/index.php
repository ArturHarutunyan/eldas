<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include './incs/config.php';
include './incs/fns_general.php';

global $pdo;
$pdo = db_connect();

?>
<html>
<head>
	<title>Test</title>
	<link rel="stylesheet" type="text/css" href="./style/main.css">
	<script src="./js/jquery-3.1.1.min.js"></script>



</head>
<body>
<?php


if (isset($_POST['name'])) {
			$sql = "INSERT INTO `result`(`pupil_name`) VALUES (:name)";
				$res = $pdo->prepare($sql);
					$res->bindParam(":name",$_POST['name'],PDO::PARAM_STR);
				if ($res->execute()) {
					$id = $pdo->lastInsertId();
					if (intval($id)>0) {
						$_SESSION['session_id'] = $id;
					}
				}
		}
if (isset($_SESSION['session_id'])) {
	include './classes/test.class.php';
	$test  = new Test();
	$test->show();
}else{
	include './classes/Register.class.php';
	$register = new Register();
	$register->show();
}
?>
</body>
</html>
