function addMesage (message){
	console.log(message.data == "");
	if(message.data!=""){
		document.getElementById("messages").innerHTML = "<p>"+message.name+" : "+message.data+"</p>"+document.getElementById("messages").innerHTML;
	}
}

function setTool(tool_id){
	$(".blocks").hide();
	$("#notepad_block").css("display","none");

	switch(tool_id){
		case 0: 
			$("#bord").show();
			steam.atrament = 0;
			socket.emit('setTool',0);
		break;
		case 1: 
			$("#notepad_block").show();
			socket.emit('setTool',1);
		break;
		case 2: 
			$("#browser").show();
			socket.emit('setTool',2);
		break;

	}
}
function SelectTool(tool_id){
	$(".blocks").hide();
	$("#notepad_block").css("display","none");

	switch(tool_id){
		case 0: 
			$("#bord").show();
		break;
		case 1: 
			$("#notepad_block").show();
		break;
		case 2: 
			$("#browser").show();
		break;

	}
}
function handleError(error) {
	console.log('navigator.getUserMedia error: ', error);
}
