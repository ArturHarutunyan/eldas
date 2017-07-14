$( document ).ready(function() {
	editor1 = CKEDITOR.replace('notepad');

	document.getElementById("notepad_block").style.display = "none";

	document.getElementById("show_livebord").onclick = function(){
		setTool(0);
	}
	document.getElementById("show_notepad").onclick = function(){
		setTool(1);
	}
	document.getElementById("show_browser").onclick = function(){
		setTool(2);
	}
});
socket.on('notepad',function(data){
	editor1.setData(data);
})
socket.on('setlink',function(data){
	oppenApp(data);
});
socket.on('notepad',function(data){
	document.getElementById("not_block").innerHTML = data;
});
socket.on('weight',function(weight){
	atrament.weight = weight;
});
socket.on('mode',function(mode){
	atrament.mode = mode;
});
socket.on('opacity',function(opacity){
	atrament.opacity = opacity;
});
socket.on('fill',function(fill){
	if (parseInt(fill)==1) {
		atrament.fill();
	};
});
socket.on('color',function(color){
	atrament.color = color;
})


document.getElementById("send").onclick = function(){
	
	var message = document.getElementById("chat").value;
	info.data = message;
	socket.emit('chat', info);

	
}
stopStream = true;
socket.on('onMic',function(type){
	stopStream = false;
	var constraints = window.constraints = { audio: true, video: false};
	navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);
});
socket.on('offMic',function(type){
	stopStream = true;
});

socket.on('clear',function(){
	atrament.clear();
})
socket.on('draw',function(data){
	data.mouse.px = data.mouse._px;
	data.mouse.py = data.mouse._py;

	atrament.draw(data.x,data.y,data.mouse,1);
});
socket.on('CanvasMouseMove',function(data){
	if(!atrament.mouse.down){
		atrament.SetMouseMove(data.x,data.y);
	}
})




socket.on('voice', function(data) {
	if(data.id!=info.id){
		arrayBuffer = data.blob;
		var blob = new Blob([arrayBuffer], { 'type' : 'audio/ogg; codecs=opus' });
		var audio = document.createElement('audio');
		audio.src = window.URL.createObjectURL(blob);
		audio.play();
	}
});



socket.on('setTool',function(type){
	SelectTool(type);
});

socket.on('GetThisInfo',function(ansver_id){
	var img = canvas.toDataURL("image/png");
	var data = {};
	data.img = img;
	stream.teacher_id = ansver_id;
	data.id = ansver_id;
	stream.openCoonect = true;
	socket.emit('sendThisInfo',data);
});
socket.on('SetFullScreen',function(data){
	FuulScreenBord(1);
})
socket.on('SetSmollScreen',function(data){
	SmollScreenBord(1);
})
socket.on('CanvasMouseDown',function(data){
	atrament.setmouseDown(data);
})

var haveQuestion = function(){
	var id = info.id;
	socket.emit('haveQuestion', id);
}

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
	    var data = {};
		data.id = info.id;
		data.blob = blob;
		if(stopStream == false){
	    	socket.emit('voice', data);
		}
	};
	mediaRecorder.start();
	setInterval(function() {
    	mediaRecorder.stop()
    	mediaRecorder.start()
  	}, 400);
}
