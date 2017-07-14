<?php

class Content{
	protected $page;
	protected $_pages = array('login','home','addClass','addUser','contact_us');
	protected $defoultPage = 'home';
	protected $_PDO;
	protected $error;

	public function __construct(){
		global $pdo;
		$this->_PDO = $pdo;
		if (isset($_GET['logout'])) {
			unset($_SESSION['user_id']);
			unset($_SESSION['user_name']);
			header('Location: /');
		}
				$this->checkLogIn();

		if(!isset($_SESSION['user_id'])){
			$this->page = 'login';
		}else{
			$page = isset($_GET['page']) ? $_GET['page'] : $this->defoultPage;
			if (in_array($page, $this->_pages)) {
				$this->page = $page;
			}else{
				$this->page = $this->defoultPage;
			}
		}

		if (!file_exists("./classes/".$this->page.".php")) {
			$this->page = 'error';
		}
		$this->prepare();
	}

	private function prepare(){


		require './classes/'.$this->page.".php";

		if(!isset($obj)){
			$this->error = 'PAGE NOT FOUNT';
		}else{
			$this->obj = $obj;
		}
	}

	protected function checkLogIn(){
		if (isset($_POST['log_in'])) {
			$_POST['password'] = password_encrypt($_POST['password']);
			$sql = "SELECT `id` FROM `users` WHERE `login`=:login AND `password`=:password";
				$row = $this->_PDO->prepare($sql);
				$row->bindParam(":login",$_POST['login'],PDO::PARAM_STR);
				$row->bindParam(":password",$_POST['password'],PDO::PARAM_STR);
			$row->execute();
			if ($row->rowCount()>0) {

				$user = $row->fetch();
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['user_name'] = $_POST['login'];

			}
		}
	}

	public function show(){
		?>
		<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title><?php if(empty($this->error)) echo $this->obj->title; else echo 'error'?></title>
</head>

<body>
				<?=$this->error?>
				<div class="content">

					
					<?php
						if (isset($_SESSION['user_id'])) {
							?>
							 <div class="inner_layout">
								<nav>
						            <ul class="shadow clearfix">
						                <li>
						                    <a class="ellogo" href="?page=home" ><img class="middle_icon" src="images/logo-small_03.png"></a>
						                </li>
						                <li>
						                    <a href="?page=home" ><img class="middle_icon" src="images/home.svg"></a>
						                </li>
						                <li>
						                    <a href="?page=addClass" ><img class="middle_icon" src="images/user.svg">
						                        <img class="small_plus" src="images/plus-c.svg">
						                    </a>
						                </li>
						                <li class="add_ic">
						                    <a href="?page=addUser" ><img class="middle_icon" src="images/plus-c 2.svg"></a>
						                </li>
						            </ul>
						            <ul class="logout_place clearfix">
						                <li>
						                    <a href="?logout=1" ><img class="middle_icon" src="images/sign-out.svg"></a>
						                </li>
						            </ul>
						        </nav>
						        <div class="lesson_grid">
						            <div class="container">
						                <div class="row">
											<?php
											
												$this->obj->show();
											?>
										</div>
									</div>
							    </div>
							    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
							</body>

							</html>
								
							<?php
						}else{
							$this->obj->show();
						}
					?>
				</div>
			</body>
			</html>
		<?php
	}
};

?>