window.addEventListener("gamepadconnected", function(e) {
	gp = navigator.getGamepads()[e.gamepad.index];
	index = e.gamepad.index;
	console.log("Gamepad connected at index " + gp.index + ": " + gp.id + ". It has " + gp.buttons.length + " buttons and " + gp.axes.length + " axes.");
});


function ajax(flag_status, step){
    $.ajax({
		url: "send.php",
		type: "post",
		data: {Flag: flag_status, Step:step},

        success: function (response) {
          console.log(response);
          var elem = document.getElementById("Bar0");   
  			  var height = parseInt(response, 10);
  			  var height = height * 100/1023;
      		elem.style.height = 100 - height + '%'; 
      		elem.innerHTML = height + '%';

        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}


function getPwm(){


  $.ajax({
    url: "check.php",
    type: "get",

    success: function (response) {
      console.log(response);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });


}


function loop(){
    var t0 = performance.now();
    var t = t0;
    getPwm();
  	if(flag == "keyboard"){
      if(t < performance.now()) {
  		  kd.tick();
        t += 16;
      }
  	}else{
  		if(typeof gp !== 'undefined'){
			gp = navigator.getGamepads()[index];
			//console.log(gp.axes);
			if(gp.buttons[0].value == 1) {
				//console.log(gp.buttons[0]);
    			clearInterval(intervalId);
    		}
		}
  	}
    var t1 = performance.now();
    console.log("Call to doSomething took " + (t1 - t0) + " milliseconds.");

}

$(document).ready(function() {
	intervalId = setInterval(loop, 16)
	flag = "keyboard";
  flag_status = "-";
  step = 5;

  $.ajax({
    url: "init.php",
    type: "post",
    success: function (response) {
          console.log(response);
    },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
  });

});


function destruir(){
   $.ajax({
    url: "destruir.php",
    type: "post",
    data: {destroy: '1'},

        success: function (response) {
          console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

/*
window.onbeforeunload = function () {
   $.ajax({
    url: "destruir.php",
    type: "post",
    success: function (response) {
          console.log(response);
    },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
  });
}*/
	
kd.SPACE.down(function () {
  //console.log('The space bar is being held down!');
  clearInterval(intervalId);
});

kd.W.down(function () {
  //console.log('The w is being held down!');
  if (flag_status != "w") {
    flag_status = "w";
    ajax(flag_status, step);
  }
});

kd.W.up(function () {
  //console.log('The w is being released!');
  if (flag_status == "w") {
    flag_status = "-";
    ajax(flag_status, step);
  }
});

kd.A.down(function () {
  //console.log('The a is being held down!');
  //ajax(direction, step);
});

kd.S.down(function () {
  //console.log('The s is being held down!');
  if (flag_status != "s") {
    flag_status = "s";
    ajax(flag_status, step);
  }
});

kd.S.up(function () {
  //console.log('The s is being released!');
  if (flag_status == "s") {
    flag_status = "-";
    ajax(flag_status, step);
  }
});

kd.D.down(function () {
  //console.log('The d is being held down!');
  //ajax(direction, step);
});

function reset(){
	var elem = document.getElementById("Bar0");
	elem.style.height = 100 + '%';    
	elem.innerHTML = 0 + '%';
    $.ajax({
		url: "reset.php",
		type: "post",
    });
}


function cambiar(btn){
	var elem = document.getElementById("botones");
	var children = elem.children;
	for (var i = 0; i < children.length; i++) {
  		var boton = children[i];
  		if(boton == btn){
  			boton.setAttribute("disabled", "true")
  		}else{
  			boton.removeAttribute("disabled");
  			if(flag == "keyboard"){
  				flag = "controller";
  			}else{
  				flag = "keyboard";
  			}
  		}
  
	}

}
