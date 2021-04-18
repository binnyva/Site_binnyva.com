function showTweet(data) {
	var month_names = ["January","February","March","April","May","June","July","Augest","September","October","November","December"];
	var created_at = new Date(data[0].created_at);
	
	var hour = created_at.getHours();
	var am_pm = "AM";
	if(hour > 12) {
		am_pm = "PM";
		hour -= 12;
	}
	else if(hour == 12) am_pm = "Noon";
	
	var time = zeroPad(hour) + ":" + zeroPad(created_at.getMinutes()) + " " + am_pm;
	var date = month_names[created_at.getMonth()] + " " + created_at.getDate();
	$("twitter-status").innerHTML = data[0].text + "<br /><a href='http://twitter.com/binnyva/status/" +data[0].id+ "'>" + date + ", " + time + "</a>";
}

function zeroPad(number) {
	return (number > 9) ? number : "0" + number;
}