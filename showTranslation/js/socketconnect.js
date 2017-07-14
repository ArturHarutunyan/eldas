var server_ip = "35.158.38.199";
//var server_ip = "localhost";

var socket = io.connect('http://'+server_ip+':4200');

socket.on('connect', function(data) {
	socket.emit('setRoom',room);
	socket.emit('setUsername', info);
});
$(document).ready(function(){

	document.getElementById("send").onclick = function(){
		var message = document.getElementById("chat").value;
		document.getElementById("chat").value = "";
		info.data = message;
		socket.emit('chat', info);
	}
	document.addEventListener("keydown", function(event) {
		if (parseInt(event.keyCode) == 13) {
			var message = document.getElementById("chat").value;
			document.getElementById("chat").value = "";
			info.data = message;
			socket.emit('chat', info);
		};
	});
});
socket.on('chat',function(data){addMesage(data)});
var constraints = window.constraints = { audio: true, video: false};

function handleSuccess(mediaStream) {
	var mediaRecorder = new MediaRecorder(mediaStream);
	mediaRecorder.onstart = function(e) {
	    this.chunks = [];
	};
	mediaRecorder.ondataavailable = function(e) {
	    this.chunks.push(e.data);
	};
	mediaRecorder.onstop = function(e) {
	    var blob = new Blob(this.chunks, { 'type' : 'audio/ogg; codecs=opus' });
	    socket.emit('voice', blob);
	};
	mediaRecorder.start();
	setInterval(function() {
    	mediaRecorder.stop()
    	mediaRecorder.start()
	}, 400);
}

function handleError(error) {
	console.log('navigator.getUserMedia error: ', error);
}