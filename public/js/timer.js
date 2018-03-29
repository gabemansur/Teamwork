function initializeTimer(sec, callback, cookie = 'task-timer'){

		if(isNaN(sec)){

			alert("Invalid starting time");
			return;
		}

		if(!readCookie(cookie)) {

			// convert start time from seconds to milliseconds
			var time = sec * 1000;

			var currentTime = new Date();

			var startTime = currentTime.getTime();
			var endTime = new Date(currentTime.getTime() + time);

			createCookie(cookie, endTime);

		}

		setTimeout(function() {
			timer(callback, cookie)
		}, 1000);

}

function timer(callback, cookie){

	// Subtracts the current time from the initial time value stored in the cookie
	time_now = new Date();
	time_num = time_now.getTime();

	the_end = readCookie('task_timer');
	the_end = new Date(the_end);
	ending = the_end.getTime();
	remaining = ending - time_num;

	clock = document.getElementById('timer');

	// If there is any tme remaining, it displays it
	if(remaining > 0){

		if(clock){
				display = displayTime(remaining);
				clock.innerHTML = display;
		}

		setTimeout(function() {
			timer(callback, cookie);
		}, 1000);

	}

	// If no time is left, the timer is set to display zero
	else {

		deleteCookie(cookie);

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
