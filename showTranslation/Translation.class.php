<?php

class Translation{
	private $pdo;
	private $id;
	private $info = array();
	private $teacher = false;

	public function __construct($id){
		$this->id = intval($id);

		global $pdo;
		$this->pdo = $pdo;
		$this->prepare();
	}

	protected function prepare(){
		$sql = "SELECT * FROM `classes` WHERE `id`=:id";
		$row = $this->pdo->prepare($sql);
			$row->bindParam(":id",$this->id,PDO::PARAM_INT);
		if (!$row->execute()) {
			return false;
		}

		$this->info = $row->fetch();

		if ($this->info['created_by_id']==$_SESSION['user_id']) {
			$this->teacher = true;
		}
	}

	public function show(){
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset="utf-8">
				<title>livebord</title>

				<script>
					var room = "room-<?=$_GET['id']?>";
					var info = {};
					info.id = <?=$_SESSION['user_id']?>;
					info.name = "<?=$_SESSION['user_name']?>";
					<?php
						if($this->teacher){
							?>
								var teacher = true;
							<?php
						}else{
							?>
								var teacher = false;
							<?php
						}
					?>
				</script>

				<script src="./js/stream.js"></script>
				<script src="./js/atrament.min.js"></script>
				<script src="./js/html2canvas.js"></script>

				<script src="./js/socket.io.js"></script>
				<script src="./js/jquery-3.1.1.min.js"></script>
				<script src="./js/ckeditor/ckeditor.js"></script>

				


				<link rel="stylesheet" type="text/css" href="css/main.css">
			</head>
		<body>
			<div class="left">
				<div style="height: 35px;">
						<button class="button"  id="show_notepad">Տետր</button>
						<button class="button" id="show_browser">Բրաուզեր</button>
						<button class="button" style="background:green;" id="show_livebord">Գրատախտակ</button>
						<?php
							if(!$this->teacher){
								?>
									<button class="button" onclick = "haveQuestion()">Հարց տալ</button>
								<?php
							}else{
								?>
									<button class="button" onclick = "connectOllMic()">Միացնել բոլորին</button>
								<?php
							}
						?>
					</div>
				<div id="notepad_block">
					<textarea id="notepad" class="notepad blocks"></textarea>
				</div>

				<div id="bord" class="bord blocks">
					
					<form id="gorciq">
						<button style="border-radius: 0px;" id="clear" onclick="stream.clear();event.preventDefault(); atrament.clear();">Մաքրել</button><br>
						<label>Հաստություն</label><br>
						<input type="range" min="1" max="40" oninput="stream.setWeight(parseFloat(event.target.value));" value="2" step="0.1" autocomplete="off"/><br>

						<label>Գործիք</label>
						<div>
							<img src="./img/draw.png" class='modes' onclick="stream.setmode('draw');" style="cursor:pointer;background:red;width: 20px;">
							<img src="./img/erase.png" class='modes' onclick="stream.setmode('erase');" style="cursor:pointer;background:red;width: 20px;">
							<!--<img src="./img/fill.png" class='modes' onclick="stream.setmode('fill');" style="cursor:pointer;background:red;width: 20px;">-->
						</div>

						<label>Գույն</label>
						<input type="color" onchange="stream.setCollor(event.target.value);" value="#000000" autocomplete="off"><br>
						<!--<label>Թափանցիկություն</label><br>
						<input type="range" min="0" max="1" onchange="setOpacity(parseFloat(event.target.value));" value="1" step="0.05" autocomplete="off">
						-->
					</form>

					<canvas style="margin-top:36px;" id="sketcher"></canvas>
					<img src="./img/enlarge.png" class="enlarge" id="enlarge" onclick="FuulScreenBord()">
					<img src="./img/smoller.png" class="enlarge" id="smoller" style="right:0;display: none;" onclick="SmollScreenBord()">
				</div>

				<?php if($this->teacher){?>
				<div id="pup_bord" class="bord blocks pupil_block">
					
					<form id="gorciq">
						<button style="border-radius: 0px;" id="clear" onclick="stream.clear();event.preventDefault(); pupil_atrament.clear();">Մաքրել</button><br>
						<label>Հաստություն</label><br>
						<input type="range" min="1" max="40" oninput="stream.setWeight(parseFloat(event.target.value));" value="2" step="0.1" autocomplete="off"/><br>

						<label>Գործիք</label>
						<div>
							<img src="./img/draw.png" class='modes' onclick="stream.setmode('draw');" style="cursor:pointer;background:red;width: 20px;">
							<img src="./img/erase.png" class='modes' onclick="stream.setmode('erase');" style="cursor:pointer;background:red;width: 20px;">
							<!--<img src="./img/fill.png" class='modes' onclick="stream.setmode('fill');" style="cursor:pointer;background:red;width: 20px;">-->
						</div>

						<label>Գույն</label>
						<input type="color" onchange="stream.setCollor(event.target.value);" value="#000000" autocomplete="off"><br>
						<!--<label>Թափանցիկություն</label><br>
						<input type="range" min="0" max="1" onchange="setOpacity(parseFloat(event.target.value));" value="1" step="0.05" autocomplete="off">-->
					</form>
					<canvas style="margin-top: 36px;" id="pupil_sketcher"></canvas>
				</div>
				<?php } ?>

				<div id="browser" class="blocks">
					<div class="addresLine">
						<input type="text" id="addres" value="http://www.imDproc.am">
						<button id="oppenButton" class="button"  style="border-radius: 0px;">Մուտք</button>
					</div>
					<div class="opendBlocks">
						<div id="address">
							<span id="addres-1" onclick="setFrame(1)">http://www.imDproc.am <p id="close-1" onclick="closeFrame(1)">X</p></span>

						</div>
						<button id="addFrame" class="button"  style="border-radius: 0px;">+</button>
					</div>
					<div class="iframeBlock" id="iframeBlock">
						<iframe id="iframe-1" src="http://www.imDproc.am">
						</iframe>
					</div>
				</div>

				<div id="message">
					<div id="messages">
					</div>
					<span style="display: block;">
						<input type="text" style="height: 26px;" id="chat" name="chat" value="">
						<button id="send" class="button" style="border-radius: 0px;">Ուղարկել</button>
					</span>
				</div>
			</div>

			<div class="right">
				<div>
				<a href="http://<?=$_SERVER['SERVER_NAME'];?>" style="position: absolute;right: 0;top: -9px;">
					<img src="./img/home.png" style="height:47px;"></img>
				</a>
				</div>
				<div style="float: right;    margin-right: 60px;">
					<button onclick="oppenApp('http://imdproc.am')">ԻմԴպրոց</button>
					<button onclick="oppenApp('http://www.desmos.com/calculator')">Մաթ․</button>
					<button onclick="oppenApp('http://books.dshh.am/bookcase/hsma')">Գրքեր</button>
				</div>
				<iframe src="http://imdproc.am" id="iframe"></iframe>
				<div id="pupils">
				</div>
			</div>
			
				<script src="./js/tools.js"></script>
				<script src="./js/bord.js"></script>
				<script src="./js/brawser.js"></script>
				<script src="./js/socketconnect.js"></script>
				<?php
					if($this->teacher){
						?>
							<script src="./js/teacher.js"></script>
						<?php
					}else{
						?>
							<script src="./js/pupil.js"></script>
						<?php
					}
				?>
		</body>
		<?php

	}
};

?>
