function initializeTimer(sec, callback, cookie = 'task-timer'){

		if(isNaN(sec)){

			alert("Invalid starting time");
			return;
		}

		time = sec * 1000;

		setTimeout(function() {
			timer(callback)
		}, 1000);

}

function timer(callback){

	var ending = time;
	var remaining = ending - 1000;
	time = remaining;

	clock = document.getElementById('timer');

	// If there is any tme remaining, it displays it
	if(remaining > 0){

		if(clock){
				display = displayTime(remaining);
				clock.innerHTML = display;
		}

		setTimeout(function() {
			timer(callback);
		}, 1000);

	}

	// If no time is left, the timer is set to display zero
	else {

		if(clock){
				clock.innerHTML = '00:00';
		}

		if (typeof callback === "function") {
			callback();
		}
	}

}

function createCookie(name, value) {

		var date = new Date();
		date.setTime(date.getTime()+ (10 * 60 * 1000) ); // expires in 10 mins
		var expires = "; expires="+date.toGMTString();


	document.cookie = name+"="+value+expires+"; path=/";

}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return false;
}

function deleteCookie(name) {
    document.cookie = name+'=; Max-Age=-99999999;';
}



function displayTime(timer){

	var theTime = new Date(timer);

	var minutesDisplay = pad(theTime.getMinutes(), 2);
	var secondsDisplay = pad(theTime.getSeconds(), 2);

	return minutesDisplay+':'+secondsDisplay;

}


function pad(number, length) {

	var str = '' + number;
	while (str.length < length) {
		str = '0' + str;
	}

	return str;

}
