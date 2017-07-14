<?php
include "./classes/Result.class.php";
class Test{
	protected $pdo;
	protected $pagedata;

	public function __construct(){
		global $pdo;
		$this->pdo = $pdo;
		if (!$this->prepare()) {
			return false;
		}
	}

	private function prepare(){
		if (isset($_POST['submited'])) {
			$result = new Result();
			$result->show();
		}
		$sql = "SELECT * FROM `task`";
		$res = $this->pdo->query($sql);
		$n = 0;
		while($task = $res->fetch()){
			$this->pagedata[$n] = $task;
			$sql = "SELECT * FROM `questions` WHERE `task_id`=".$task['id'];
			$que = $this->pdo->query($sql);
			$q = 0;
			while ($question = $que->fetch()) {
				$this->pagedata[$n]['question'][$q] = $question;
				$sql = "SELECT * FROM `answers` WHERE `question_id`=".$question['id'];
				$ans = $this->pdo->query($sql);
					while ($answers = $ans->fetch()) {
						$this->pagedata[$n]['question'][$q]['answers'][] = $answers;
					}

				$q++;
			}

			$n++;
		}

		return true;
	}

	public function show(){
		?>

	<form method="post" class="content">
		<input type="hidden" name="clock" id="_clock" value="0">
		<div class="clock" id="clock" time="0">00:00</div>
		<div class="main">
		<?php
		foreach ($this->pagedata as $key => $value) {
			?>
				<div class="task">
					<span class="task_number"><?php echo $key+1?></span>
					<p class="task_context">
						<?php echo $value['task'] ?>
					</p>
				</div>
			<?php
				foreach ($value['question'] as $k => $question) {
					?>
						<div class="question_block">
						<span class="question_number"><?php echo $k+1 ?></span>
						<p class="question_context" id="question_context-<?php echo $k+1 ?>"><?php echo $question['question']?></p>
							<div class="answers" id="answers-<?php echo $k+1 ?>">
								<?php 
								if(intval($question['type'])==1){
									foreach($question['answers'] as $c => $answers){
								?>
								<div class="answer_block">
									<input type="radio" class="option_radio" name="answer-<?php echo $question['id']?>" value="<?php echo $answers['id']?>" id="answer-<?php echo $answers['id'] ?>">
									<p select="<?php echo $answers['id']?>" class="option"><?php echo $c+1?> ) <?php echo $answers['answer']?></p>
								</div>
								<?php
									}
									if($value['type']==2){	
										?>
										<div class="answer_block">
											<input type="radio" class="option_radio" name="answer-<?php echo $question['id']?>" value="0" id="answer-<?php echo $question['id']?>-0">
											<p select="<?php echo $question['id']?>-0" class="option"><?php echo $c+2?> ) Չգիտեմ</p>
										</div>
										<?php
									}
								}else{
									?>
										<div class="answers" id="answers-<?php echo $question['id']?>" >
												<p class="answer">Պատասխան՝ </p>
												<input class="answer_input"  name="answer-<?php echo $question['id']?>" id="answer_<?php echo $question['id']?>" type="text">
											</div>
									<?php
								}
								?>
							</div>
					</div>
					<?php 
				}

		}

		?>
		<input type="hidden" name="submited" value="1">
		<input type="submit" id="go" value="Պատասխանել">
		</div>
	</form>
	<script src="./js/script.js"></script>
		<?php
	}
}


?>