$( document ).ready(function() {
	editor1 = CKEDITOR.replace('notepad');
	editor1.on('contentDom', function() {
		editor1.document.on('keydown', function(event) {
			var message = editor1.getData();
			socket.emit('notepad',message);
		});
	})
	document.getElementById("notepad_block").style.display = "none";
		function KeyPress(e) {
			if (e.keyCode == 26){
				var image = new Image();
				if(vijak_count>0)vijak_count--
				image.src = hinvijak[vijak_count];
				image.onload = function(){
					canvas.getContext("2d").clearRect(0, 0,canvas.width,canvas.height);
					canvas.getContext("2d").drawImage(image, 0, 0);
					canvas.getContext("2d").beginPath();
				}
			}
        }

        document.onkeypress = KeyPress;

	document.getElementById("show_livebord").onclick = function(){
		parent = document.getElementById("pupils").children;

		for(i=0;i<parent.length;++i){
			parent[i].style.background = "linear-gradient(#ccc, #000)";
		}
		$(".button").css("background","linear-gradient(#ccc, #000)");
		document.getElementById("show_livebord").style.background = "green";
		setTool(0);
	}
	document.getElementById("show_notepad").onclick = function(){
		$(".button").css("background","linear-gradient(#ccc, #000)");
		document.getElementById("show_notepad").style.background = "green";
		setTool(1);
	}
	document.getElementById("show_browser").onclick = function(){
		$(".button").css("background","linear-gradient(#ccc, #000)");
		document.getElementById("show_browser").style.background = "green";
		setTool(2);
	}

});

socket.on('clear',function(){
	pupil_atrament.clear();
})

ollmic = false;
function connectOllMic(){
	if(!ollmic){
		//var childrens = document.getElementById("pupils").children;
		//for(var i=0;i<=childrens.length;i++){
		//	if(document.getElementById("pupils").children[i].getAttribute("_id")!=info.id){
				socket.emit('onMic',/*document.getElementById("pupils").children[i].getAttribute("_id")*/1);
		//	}
		//}
		ollmic = true;
	}else{
		//var childrens = document.getElementById("pupils").children;
		//for(var i=0;i<=childrens.length;i++){
		//	if(document.getElementById("pupils").children[i].getAttribute("_id")!=info.id){
				socket.emit('offMic',/*document.getElementById("pupils").children[i].getAttribute("_id")*/0);
		//	}
		//}
		ollmic = false;
	}
}



socket.on('haveQuestion',function(id){
	var name = document.getElementById("pupil-"+id).innerHTML;
	document.getElementById("pupil-"+id).style.background = "red";
	if (confirm("Միացնել "+name+" -ի բարձրախոսը ")) {
		socket.emit('onMic',id);
	};
});
socket.on('addUser',function(data){
	if($("#pupil-"+data.id).length==0)
	pupil_list = document.getElementById("pupils");
	pupil_list.innerHTML += "<p server_ip='"+data.serverId+"' _id='"+data.id+"' onclick='showPupilBord(this)' id='pupil-"+data.id+"'>"+data.name+"</p>";//<span id='pupil-reaise-"+data.id+"'></span>"
});
socket.on('disconnect',function(data){
	var disconnect_user = document.getElementById("pupil-"+data);
	disconnect_user.parentNode.removeChild(disconnect_user);

})
var showPupilBord = function(elem){
	//if (parseInt(elem.getAttribute("_id")) != info.id) {
		    //background: linear-gradient(#ccc, #000);
	parent = elem.parentNode.children;

	for(i=0;i<parent.length;++i){
		parent[i].style.background = "linear-gradient(#ccc, #000)";
	}
	$(".button").css("background","linear-gradient(#ccc, #000)");
		elem.style.background = "green";
		server_id = elem.getAttribute('server_ip');
		socket.emit('ConnectTo',server_id)
		stream.forPupil = server_id;
		document.getElementById("bord").style.display = "none";
		document.getElementById("pup_bord").style.display = "block";
		$("input[type='color']").val("#ff0000");
		stream.atrament = 1;
		stream.setCollor("#ff0000");
	//};
} 
socket.on('sendThisInfo',function(img){
	var image = new Image();
	pup_canvas.getContext("2d").clearRect(0, 0,pup_canvas.width,pup_canvas.height);
	image.src = img;
	pup_canvas.getContext("2d").drawImage(image, 0, 0);
});



socket.on('draw',function(data){
	data.mouse.px = data.mouse._px;
	data.mouse.py = data.mouse._py;
	if(!pupil_atrament.mouse.down)
		pupil_atrament.draw(data.x,data.y,data.mouse);
});
socket.on('CanvasMouseMove',function(data){
	pupil_atrament.SetMouseMove(data.x,data.y);
});
socket.on('GetStartInfo',function(data){
	for (var i = 0; i <data.users.length; i++) {
		var pupil_list = document.getElementById("pupils");
		pupil_list.innerHTML += "<p server_ip='"+data.users[i].serverId+"' _id='"+data.users[i].id+"' onclick='showPupilBord(this)' id='pupil-"+data.users[i].id+"'>"+data.users[i].name+"</p><span style='display:none' id='pupil-reaise-"+data.users[i].id+"'></span>"
	};

	for (var i = 0; i < data.chat.length; i++) {
		addMesage(data.chat[i]);
	};
	//console.log(data);
});

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
			    socket.emit('voice', data);
			};
			mediaRecorder.start();
			setInterval(function() {
		    	mediaRecorder.stop()
		    	mediaRecorder.start()
		  	}, 1000);
		}

		navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);

socket.on('voice', function(data) {
	if(data.id!=info.id){
		arrayBuffer = data.blob;
		var blob = new Blob([arrayBuffer], { 'type' : 'audio/ogg; codecs=opus' });
		var audio = document.createElement('audio');
		audio.src = window.URL.createObjectURL(blob);
		audio.play();
	}
});
