<?php
class Register{
	protected $pdo = null;

	public function __construct(){
		global $pdo;
		$this->pdo = $pdo;

		if (!$this->prepare()) {
			return false;
		}
	}

	private function prepare(){
		
	}

	public function show(){
		?>
			<form method="POST" class="register content">
				<p >Ձեր անունը</p>
				<input type="text" name="name"><br>
				<input type="submit" style="    margin-left: 0px;" value="շարունակել"  id="go">
			</form>
		<?php
	}
}


?>