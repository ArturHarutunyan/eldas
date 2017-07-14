<?php

class addUser{
	public $title = 'Add User';
	protected $pdo;
	protected $pageCode = 0;
	protected $data;
	protected $errorCode;
	public function __construct(){
		global $pdo;
		$this->pdo = $pdo;
		if (!isset($_GET['act'])) {
			$_GET['act'] = 'edit';
		}
		if(!$this->prepare()){
			echo "SXAL!";
		}
	}

	protected function PrepareAddContent(){
		if (isset($_POST['addbtn'])) {
			$_POST['password'] = password_encrypt($_POST['password']);
			$sql = "INSERT INTO `users` (`login`,`password`,`passport`,`lname`,`fname`,`mail`,`phone`) VALUES (:login,:password,:passport,:lname,:fname,:mail,:phone)";
			$res = $this->pdo->prepare($sql);
				$res->bindParam(":login",$_POST['login'],PDO::PARAM_STR);
				$res->bindParam(":password",$_POST['password'],PDO::PARAM_STR);
				$res->bindParam(":passport",$_POST['passport'],PDO::PARAM_STR);

				$res->bindParam(":lname",$_POST['lname'],PDO::PARAM_STR);
				$res->bindParam(":fname",$_POST['fname'],PDO::PARAM_STR);
				$res->bindParam(":mail",$_POST['mail'],PDO::PARAM_STR);
				$res->bindParam(":phone",$_POST['phone'],PDO::PARAM_STR);
				

			if(!$res->execute()){
				return false;
			}
			$this->pageCode = 1;
		}
		return true;
	}

	protected function prepare(){
		if ($_GET['act']=='edit') {
			if (!$this->PrepareEditContent()) {
				return false;
			}
		}elseif($_GET['act'] == 'add'){
			if (!$this->PrepareAddContent()) {
				return false;
			}
		}elseif($_GET['act']=='edititem'){
			if (!$this->PrepareEditItemContent()) {
				return false;
			}
		}else{
			if (!$this->PrepareEditContent()) {
				return false;
			}
		}
		
		return true;
	}

	protected function PrepareEditItemContent(){
		if (isset($_POST['addbtn'])) {
			$_POST['password'] = password_encrypt($_POST['password']);
			$sql = "UPDATE `users` SET `login`=:login,`password`=:password,`passport`=:passport,`lname` = :lname,`fname` = :fname,`mail` = :mail,`phone` = :phone  WHERE `id`=:id";
			$res = $this->pdo->prepare($sql);
				$res->bindParam(":id",$_GET['id'],PDO::PARAM_STR);
				$res->bindParam(":login",$_POST['login'],PDO::PARAM_STR);
				$res->bindParam(":password",$_POST['password'],PDO::PARAM_STR);
				$res->bindParam(":passport",$_POST['passport'],PDO::PARAM_STR);
				$res->bindParam(":lname",$_POST['lname'],PDO::PARAM_STR);
				$res->bindParam(":fname",$_POST['fname'],PDO::PARAM_STR);
				$res->bindParam(":mail",$_POST['mail'],PDO::PARAM_STR);
				$res->bindParam(":phone",$_POST['phone'],PDO::PARAM_STR);
				

			if ($res->execute()) {
				$this->pageCode = 1;
			}else{
				return false;
			}
		}

		$id = intval($_GET['id']);
		$sql = "SELECT * FROM `users` WHERE `id`=:id";
		$res = $this->pdo->prepare($sql);
			$res->bindParam(":id",$id,PDO::PARAM_INT);
		$res->execute();
		$this->pageData = $res->fetch();

		return true;
	}

	protected function PrepareEditContent(){
		$sql = "SELECT * FROM `users`";
		$res = $this->pdo->query($sql);
		if (!$res) {
			$this->errorCode = 1;
		}
		while ($row = $res->fetch()) {
			$this->data[] = $row;
		}

		return true;
	}

	public function show(){
		if ($_GET['act']=='edit') {
			$this->ShowEditContent();
		}elseif($_GET['act'] == 'add'){
			$this->ShowAddContent();
		}elseif($_GET['act']=='edititem'){
			$this->ShowEditItemContent();
		}else{
			$this->ShowEditContent();
		}
			
	}

	protected function ShowEditItemContent(){
		if ($this->pageCode==1) {
				?>
				<div style="    display: flex;">
					<h1 style="float: left;">Հաջողությամբ փոփոխվեց</h1>
					<a style="float: left;margin:0px" class="addbtn button" href="?page=addUser">Վերադառնալ</a>
				</div>
				<?php
			}
		?>
			<form method="POST" style="    display: block;" class="addClass">
				<div style="    display: block;">
					<p  style="">Անուն </p>
					<input type="text" name="lname" value="<?=$this->pageData['lname']?>">
					<br>
					<p  style="">Ազգանուն </p>
					<input type="text" name="fname" value="<?=$this->pageData['fname']?>">
					<br>
					<p  style="">mail </p>
					<input type="text" name="mail" value="<?=$this->pageData['mail']?>">
					<br>
					<p  style="">Հեռախեսահամար </p>
					<input type="text" name="phone" value="<?=$this->pageData['phone']?>">
					<br>
					<p  style="">Մուտքանուն </p>
					<input type="text" name="login" value="<?=$this->pageData['login']?>">
					<br>
					
					<p  style="">Գաղտնաբառ </p>
					<input type="password" name="password" value="">
					<br>
					<p  style="">Անձնագիր </p>
					<input type="text" name="passport" value="<?=$this->pageData['passport']?>">
				</div>
				<input type="submit" value="Հիշել" class="addbtn button" name="addbtn">
			</form>
		<?php
	}

	protected function ShowEditContent(){
		?>
		<div class="write_block">
			<a class="addbtn button" href="?page=addUser&act=add">Ավելացնել</a>
			<table>
				<thead>
					<tr>
						<td>Մուտքանուն</td>
						<td>Անձնագիր</td>
						
						<td>Անուն</td>
						<td>Ազգանուն</td>
						<td>mail</td>
						<td>Հեռախեսահամար</td>

						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($this->data as $key => $value) {
							?>
								<tr>
									<td><?=$value['login']?></td>
									<td><?=$value['passport']?></td>

									<td><?=$value['lname']?></td>
									<td><?=$value['fname']?></td>
									<td><?=$value['mail']?></td>
									<td><?=$value['phone']?></td>

									<td>
										<a style="color: blue;text-decoration: none" href="?page=addUser&act=edititem&id=<?=$value['id']?>">Edit</a>
									</td>
								</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
		<?php
	}

	protected function ShowAddContent(){
		if ($this->pageCode==1) {
				?>
				<div style="display: flex;">
					<h1 style="float: left;">Հաջողությամբ ավելացվեց</h1>
					<a style="float: left;margin:0px" class="addbtn button" href="?page=addUser">Վերադառնալ</a>
				</div>
				<?php
			}
		?>
			<form method="POST" style="    display: block;" class="addClass">
				<div style="    display: block;">
					<p  style="">Անուն </p>
					<input type="text" name="lname" value="">
					<br>
					<p  style="">Ազգանուն </p>
					<input type="text" name="fname" value="">
					<br>
					<p  style="">mail </p>
					<input type="text" name="mail" value="">
					<br>
					<p  style="">Հեռախեսահամար </p>
					<input type="text" name="phone" value="">
					<br>
					<p  style="">Մուտքանուն </p>
					<input type="text" name="login" value="">
					<br>
					<p  style="">Գաղտնաբառ </p>
					<input type="password" name="password" value="">
					<br>
					<p  style="">Անձնագիր </p>
					<input type="text" name="passport" value="">
				</div>
				<input type="submit" value="Ավելացնել" class="addbtn button" name="addbtn">
			</form>
		<?php
	}
}

$obj = new addUser();

?>