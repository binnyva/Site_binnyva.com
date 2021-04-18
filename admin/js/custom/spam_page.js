var inputs;
function pageInit() {
	var find_selecteds = getElementsByCSS("a.find-selected");
	var find_all = getElementsByCSS("a.find-all");
	
	inputs = getElementsByCSS("td.item-select input");
	var all_records = [];
	
	for(var i=0; i<inputs.length; i++) {
		all_records.push("select_row[]=" + inputs[i].value);
	}
	
	if(all_records) {
		for(var j=0; j<find_all.length; j++) {
			find_all[j].href += "&" + all_records.join("&");
		}
	}
	
	for(var j=0; j<find_selecteds.length; j++) {
		find_selecteds[j].onclick=getSelected;
	}
}


function getSelected(e) {
	var selected_records = [];
	for(var i=0; i<inputs.length; i++) {
		if(inputs[i].checked) {
			selected_records.push("select_row[]=" + inputs[i].value);
		}
	}
	
	var link = this.href + "&" + selected_records.join("&");
	document.location.href = link;
	
	e.stopPropagation();
	e.preventDefault();	
}
addEvent(window,'load', pageInit);