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
			$sql = "INSERT INTO `classes` (`name`,`created_by_id`) VALUES (:name,:created)";
			$res = $this->PDO->prepare($sql);
				$res->bindParam(":name",$_POST['classname'],PDO::PARAM_STR);
				$res->bindParam(":created",$_SESSION['user_id'],PDO::PARAM_INT);
			if(!$res->execute()){
				print_r($this->PDO->errorInfo());
				return false;
			}
			$this->pageCode = 1;
		}

		return true;
	}

	public function show(){
			if ($this->pageCode==1) {
				?>
					<h1>Հաջողությամբ ավելացվեց</h1>
				<?php
			}
		?>
			<form method="POST" style="    display: block;" class="addClass">
				<div style="   display: block;">
					<p >class name</p>
					<input type="text" name="classname" value="">
				</div>
				<input type="submit" value="Ավելացնել" class="addbtn button" name="addbtn">
			</form>
		<?php
	}
}

$obj = new addClass();

?>