
//var setCanvasOptions = function(){
	
var canvas = document.getElementById('sketcher');
var atrament = _atrament(canvas, window.innerWidth/2, window.innerHeight*0.8);
document.getElementById("bord").style.height = window.innerHeight*0.8 + "px";
document.getElementById("messages").style.maxHeight = window.innerHeight*0.15+ "px";
	
var clearButton = document.getElementById('clear');
canvas.addEventListener('dirty', function(e) {
	clearButton.style.display = atrament.dirty ? 'inline-block' : 'none';
});
//}
if(teacher){
	var pup_canvas = document.getElementById('pupil_sketcher');
	var pupil_atrament = _atrament(pup_canvas, window.innerWidth/2, window.innerHeight*0.8);
	document.getElementById("pup_bord").style.height = window.innerHeight*0.8 + "px";
}
function FuulScreenBord(image = 0){
	_this = canvas.toDataURL("image/png");
	img = new Image();
	if(parseInt(image) == 0){
		socket.emit('SetFullScreen',1);
	}
	img.src = _this;
	atrament = _atrament(canvas, window.innerWidth, window.innerHeight);
	img.onload = function() {
			canvas.getContext("2d").drawImage(img, 0, 0);
	};
	canvas.style.width = "100%";
	canvas.style.height = "100%";
	

	document.getElementById("smoller").style.display="block";
	document.getElementById("enlarge").style.display="none";
}
function SmollScreenBord(image = 0){
	_this = canvas.toDataURL("image/png");
	if(parseInt(image)==0){
		socket.emit('SetSmollScreen',1);
	}
	var img = new Image();
	img.src = _this;
	var atrament = _atrament(canvas, window.innerWidth/2, window.innerHeight*0.8);
	canvas.style.width = "50%";
	canvas.style.height = "80%";
	img.onload = function(){
		canvas.getContext("2d").drawImage(img, 0, 0);
	};

	document.getElementById("smoller").style.display="none";
	document.getElementById("enlarge").style.display="block";	
}
//pupil_sketcher