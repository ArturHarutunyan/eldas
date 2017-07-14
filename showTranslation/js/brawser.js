var iframe_count = 1;
var active_iframe_id = 1;
document.getElementById("oppenButton").onclick = function(){
	var src = document.getElementById("addres").value;
	src = "HTTP://"+src;
	document.getElementById("addres-"+active_iframe_id).innerHTML = src;
	document.getElementById("iframe-"+active_iframe_id).setAttribute("src",src);
}
document.getElementById("addFrame").onclick = function(){
	if(active_iframe_id>0)
		document.getElementById("iframe-"+active_iframe_id).style.display = "none";
	iframe_count++;
	var addres_line = document.createElement("span");
	
	addres_line.id = "addres-"+iframe_count;
	addres_line.setAttribute("frameId",iframe_count);
	var closeBtn = document.createElement("p");
	
	closeBtn.id="close-"+iframe_count;
	closeBtn.innerHTML = "X";
	closeBtn.setAttribute("frameId",iframe_count);
	addres_line.appendChild(closeBtn);
	
	document.getElementById("address").appendChild(addres_line);

	var new_iframe = document.createElement("iframe");
	new_iframe.id = "iframe-"+iframe_count;
	document.getElementById("iframeBlock").appendChild(new_iframe);
	active_iframe_id = iframe_count;
	addres_line.onclick = function(){setFrame(this.getAttribute("frameId"));}
	closeBtn.onclick = function(){closeFrame(this.getAttribute("frameId"));}

	document.getElementById("addres").value = "";
}
function closeFrame(id){
	var addres_line = document.getElementById("addres-"+id);
	addres_line.parentNode.removeChild(addres_line);

	var _Frame = document.getElementById("iframe-"+id);
	_Frame.parentNode.removeChild(_Frame);
	setFrame(--active_iframe_id);
}

function setFrame(setFrame){
	document.getElementById("iframe-"+active_iframe_id).style.display = "none";
	document.getElementById("iframe-"+parseInt(setFrame)).style.display = "block";
	active_iframe_id = setFrame;
	document.getElementById("addres").value = document.getElementById("iframe-"+parseInt(setFrame)).getAttribute("src");
}		

var oppenApp = function(e){
	document.getElementById("iframe").setAttribute("src",e);
	socket.emit('setlink',e);
}