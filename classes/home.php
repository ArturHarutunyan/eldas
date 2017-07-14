<?php
class Home{
	public $title = "Home";
	protected $PDO = 0;
	protected $pageData;

	public function __construct(){
		global $pdo;
		$this->PDO = $pdo;

		if (!$this->prepare()) {
			echo "SXAL !!";
		}
	}

	protected function prepare(){
		$sql = "SELECT * FROM `classes`";

		$res = $this->PDO->query($sql);

		while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
			$this->pageData[] = $row;
		}

		return true;
	}

	public function show(){
        $i = 0;
		foreach($this->pageData as $value){
            if ($i%4==0) {
                ?>
                    <div class="row">
                <?php
            }
		?>
		<div class="col-md-3 one_col">
                        <!-- ONE CARD -->
                        <a href="/showTranslation?id=<?=$value['id']?>">
                        <div class="lesson_card">
                            <div class="lesson_card_header">
                                <div class="table_layout">
                                    <div class="header_left">
                                        <div class="img_wrapper">
                                            <img src="images/el-dal-02_03.png">
                                        </div>
                                    </div>
                                    <div class="header_right">
                                        <h5>Marine Manukyan</h5>
                                        <p>երկրաչափության ուսուցիչ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="lesson_card_content">
                                <div class="back_img" style="background-image: url(images/lesson_bg_03.png)">
                                    <div class="black_overlay">
                                    </div>
                                </div>
                                <div class="lesson_title" href="/showTranslation?id=<?=$value['id']?>">
                                    <?=$value['name']?>
                                </div>
                            </div>
                            <div class="lesson_card_footer">
                                <div class="date_box">
                                    <span class="lesson_day">05</span>
                                    <span class="lesson_month">ապրիլի</span>
                                    <span class="lesson_time">
                                        15:30
                                    </span>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
		<?php
        $i++;
        if ($i%4==0) {
                ?>
                    </div>
                <?php
            }
			}
	}
};
$obj = new Home()

?>