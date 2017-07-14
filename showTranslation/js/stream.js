
var Stream = function(is_connect_oppen = false){
	this.openCoonect=is_connect_oppen;
	this.teacher = teacher;
	this.forPupil = 0;
	this.teacher_id = 0;
	this.atrament = 0;
	if (teacher) {
		this.openCoonect = true;
	};
	

	this.submitInfo = function(x,y,mouse){
		if(this.openCoonect){	
			var data = {};
			data.x = x;
			data.y = y;
			data.mouse = mouse;
			if (this.forPupil != 0) {
				data._for = this.forPupil;
				/*color = $("input[type='color']")[1].value;
				var col = {};
				col._for = this.forPupil;
				col.color = '#ff0000';
				socket.emit('color',col);*/

			}else if (this.teacher_id!=0) {
				data._for = this.teacher_id;
			}
			if (this.forPupil != 0) {
				/*var col = {};
				col._for = this.forPupil;
				col.color = color;
				socket.emit('color',col);*/

			}

			socket.emit('draw',data)
			
		}
	}
	this.SendMouseMove = function(x,y){
		if(this.openCoonect){	
			var data = {};
			data.x = x;
			data.y = y;
			if (this.forPupil != 0) {
				data._for = this.forPupil;
			}else if (this.teacher_id!=0) {
				data._for = this.teacher_id;
			}
			socket.emit('CanvasMouseMove',data);
		}
	}
	this.SendMouseDown  = function(_data,mouse=0){
		data = {};
		data.data = _data;
		data.mouse = mouse;
		if(this.openCoonect && this.teacher){	
			socket.emit('CanvasMouseDown',data);
		}
	}
	this.setmode = function(mode){
		if(this.atrament == 0){
			atrament.mode=mode;
		}else{
			pupil_atrament.mode=mode;
		}
		$(".modes").css("background-color","red");
		event.target.style.backgroundColor  = 'green';
		if(this.openCoonect){
			var data = {};
			data.mode = mode;
			if (this.forPupil != 0) {
				data._for = this.forPupil;
			}else if (this.teacher_id!=0) {
				data._for = this.teacher_id;
			}
			socket.emit('mode',data);
		}
	}
	this.setOpacity = function(opacity){
		if(this.atrament == 0){
			atrament.opacity = opacity;
		}else{
			pupil_atrament.opacity = opacity;
		}
		if(this.openCoonect){	
			data = {};
			if (this.forPupil != 0) {
				data._for = this.forPupil;
			}else if (this.teacher_id!=0) {
				data._for = this.teacher_id;
			}
			data.opacity = opacity;
			socket.emit('opacity',data);	
		}
	}

	this.setCollor = function(color){
		if(this.atrament == 0){
				atrament.color = color;
		}else{
			pupil_atrament.color = color;
		}
		if(this.openCoonect){
			var data = {};
			//atrament.color = color;
			if (this.forPupil != 0) {
				data._for = this.forPupil;
			}else if (this.teacher_id!=0) {
				data._for = this.teacher_id;
			}
			data.color = color;
			socket.emit('color',data);
		}
	}
	this.clear = function(){
		if(this.openCoonect){
			socket.emit('clear');
		}
	}
	this.setFill = function(){
		if(this.openCoonect){	
			data = {};
			if (this.forPupil != 0) {
				data._for = this.forPupil;
			}else if (this.teacher_id!=0) {
				data._for = this.teacher_id;
			}
			data.fill = 1;
			socket.emit('fill',data);
			
		}
	}

	this.setWeight = function(weight){
		if(this.atrament == 0){
			atrament.weight = weight;
		}else{
			console.log("asdf");
			pupil_atrament.weight = weight;
		}
		if(this.openCoonect){	
			data = {};
			if (this.forPupil != 0) {
				data._for = this.forPupil;
			}else if (this.teacher_id!=0) {
				data._for = this.teacher_id;
			}
			data.weight = weight
			socket.emit('weight', data);
		}
	}

}

