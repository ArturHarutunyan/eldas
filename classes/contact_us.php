<?php

class addClass{
	public $title = 'Add Class';
	protected $PDO;
	protected $pageCode = 0;
	public function __construct(){
		global $pdo;
		$this->PDO = $pdo;
		if(!$this->prepare()){
			echo "SXAL!";
		}
	}

	protected function prepare(){
		if (isset($_POST['addbtn'])) {
			$message = $_SESSION['user_id']." ".$_SESSION['user_name']."\n\r".$_POST['mail']."\n\r".$_POST['message'];
			mail("artur.harutunyan1999@gmail.com", $_POST['description'], $message);
			$this->pageCode = 1;
		}

		return true;
	}

	public function show(){
			if ($this->pageCode==1) {
				?>
					<h1>Հաջողությամբ ուղարկվեց։ Մենք կպատասխանեքն Ձեզ։</h1>
				<?php
			}
		?>
		<form method="POST" style="    display: block;" class="addClass">
				<div style="    display: block;">
					<p  style="color:#eee">e-mail</p>
					<input type="text" name="mail" value="">
					<br>
					<p  style="color:#eee">Վերնագիր</p>
					<input type="text" name="description" value="">
					<br>
					<p  style="color:#eee">Հաղորդագրություն</p>
					<textarea type="text" name="message" value=""></textarea>
				</div>
				<input type="submit" value="Ուղարկել" class="addbtn button" name="addbtn">
			</form>
		<?php
	}
}

$obj = new addClass();

?>