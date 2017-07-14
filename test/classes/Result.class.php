<?php
class Result{
	protected $pdo;
	protected $result=0;

	public function __construct(){
		global $pdo;
		$this->pdo = $pdo;
		if (!$this->prepare()) {
			return false;
		}
	}

	private function prepare(){
		if (isset($_POST['submited'])) {
			$_POST['clock'] = intval($_POST['clock']);
			$sql = "SELECT * FROM `task`";
			$thistaskunit = 0;
			$res = $this->pdo->query($sql);
			while($task = $res->fetch()){
				$sql = "SELECT * FROM `questions` WHERE `task_id`=".$task['id'];
				$que = $this->pdo->query($sql);
				while ($question = $que->fetch()) {
					$_POST['answer-'.$question['id']] = intval($_POST['answer-'.$question['id']]);
					$is_true_answer = 0;
					if($task['type']==1){
						if ($_POST['answer-'.$question['id']] == $question['true_answer']) {
							$is_true_answer = 1;
							$this->result++;
						}
					}else{

						if ($_POST['answer-'.$question['id']]!=0) {
							if ($_POST['answer-'.$question['id']] == $question['true_answer']) {
								$is_true_answer = 1;
								$thistaskunit++;
							}else{
								$thistaskunit--;
							}
						}
					}

					$sql = "INSERT INTO `result_answers`(`result_id`, `question_id`, `answer`, `is_true_answer`) VALUES (:result,:question,:answer,:is_true)";
						$r = $this->pdo->prepare($sql);
							$r->bindParam(":result",$_SESSION['session_id'],PDO::PARAM_INT);
							$r->bindParam(":question",$question['id'],PDO::PARAM_INT);
							$r->bindParam(":answer",$_POST['answer-'.$question['id']],PDO::PARAM_INT);
							$r->bindParam(":is_true",$is_true_answer,PDO::PARAM_INT);
						$r->execute();
				}
				if ($thistaskunit>0) {
					$this->result += $thistaskunit;
				}
			}
			$sql = "UPDATE `result` SET `unit`=:unit,`time`=:time WHERE `id`=:id";
				$res = $this->pdo->prepare($sql);
					$res->bindParam(":unit",$this->result,PDO::PARAM_INT);
					$res->bindParam(":time",$_POST['clock'],PDO::PARAM_INT);
					$res->bindParam(":id",$_SESSION['session_id'],PDO::PARAM_INT);
				if(!$res->execute()){
					return false;
				}

				unset($_SESSION['session_id']);

		}
		return true;
	}

	public function show(){
		echo $_POST['clock']." Վարկյան ".$this->result." միավոր";
	}
}


?>