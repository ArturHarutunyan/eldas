<?php

class Login{
	public $title = "Login";

	public function show(){
		?>

			<div class="homepage">
        <div class="overlay">
            <!-- LOGO -->
            <div class="logo">
                <img src="images/el-dal-01_03.png" />
            </div>
		            <div class="register_box">
		                <div class="container">
		                    <form method="POST">
		                        <div class="row">
		                            <div class="col-md-4">
		                                <input type="text" placeholder="Մուտքանուն" name="login" class="form-control name_control">
		                            </div>
		                            <div class="col-md-4">
		                                <input type="password" placeholder="Գաղտնաբառ" name="password"  class="form-control">
		                            </div>
		                            <div class="col-md-2">
		                                <div class="el_checkbox">
		                                	 <input type="checkbox" id="nuyn_ban">
		                               		<label for="nuyn_ban">հիշել</label>
		                                   
		                                </div>
		                            </div>
		                            <div class="col-md-2">
		                                <button class="form_button">Մուտք</button>
		                            </div>
		                            <div class="col-md-2"></div>
		                        </div>
		                        <input type="hidden" value="1" name="log_in">
		                    </form>
		                </div>
		            </div>
		        </div>
		    </div>
		    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>

		<?php
	}
}

$obj = new Login()

?>