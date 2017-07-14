function clock(){
	var s = parseInt(document.getElementById("clock").getAttribute("time"));
	document.getElementById("clock").setAttribute("time",s+1);
	document.getElementById("_clock").value = s+1;
	var m = parseInt(s/60);
	s -= m*60;
	if (m<10) {m = "0"+m};
	if (s<10) {s = "0"+s};

	document.getElementById("clock").innerHTML = m+":"+s;
}

$( document ).ready(function() {
	$(".option").on('click',function(){
		$(this).parent().parent().children().removeClass("active");
		this.parentNode.className += " active";
		document.getElementById("answer-"+this.getAttribute("select")).checked = true;
	});
	$(".option_radio").on('click',function(){
		$(this).parent().parent().children().removeClass("active");
		this.parentNode.className += " active";
	});
	document.getElementById("go").onclick = function(){
		var unit = 0;
		var answer_1 = document.getElementById("answer-1-1").checked;
			if (answer_1) {unit++};
		var answer_2 = parseFloat(document.getElementById("answer_2").value);
			if (answer_2 == 0.5) {unit++};

		alert(unit + " Միավոր "+document.getElementById("clock").innerHTML+" րոպե")
	}
	clock();
	setInterval(clock,1000);
});