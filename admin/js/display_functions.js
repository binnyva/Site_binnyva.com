//This function will check/uncheck all the checkboxes if the main one is clicked.
function checkAll() {
	var selecteds = getElementsByClassName("select-row");
	var status = $("selection-toggle").checked;
	for(var i=0; i<selecteds.length; i++) {
		selecteds[i].checked = status;
	}
}

function submit(action) {
	if(action == 'delete_record') {
		if(!confirm("This will delete all the selected items. Please confirm."))
			return false;
	}
	var selecteds = getElementsByClassName("select-row");
	for(var i=0; i<selecteds.length; i++) {
		if(selecteds[i].checked) {
			$('action').value = action;

			//Find the form which has 'action' and submit that - don't have to worry about pages with mutiple forms.
			var node = $('action');
			while(node.parentNode && (node.parentNode.tagName.toUpperCase() != 'BODY')) {
				if(node.parentNode.tagName.toUpperCase() == 'FORM') {
					node.parentNode.submit();
					break;
				} else {
					node = node.parentNode;
				}
			}
			return true;
		}
	}
	alert("Please select an item");
}

function init() {
	//Remove the all-selected if any checkbox has been unselected.
	var selecteds = getElementsByClassName("select-row");
	for(i=selecteds.length-1; ele=selecteds[i],i>=0; i--) {
		ele.onclick=function(e) {
			var item=findTarget(e);
			if(!item.checked)
				$("selection-toggle").checked = false;
			
			//If this is not given, the function that happens when the row is clicked will take place.
			if(!e) var e = window.event;
			e.cancelBubble = true;
			if (e.stopPropagation) e.stopPropagation();
		}
	}

	//For going to the edit section if a row is clicked.
	var table = getElementsByClassName("data-table","table")[0];
	var rows = table.getElementsByTagName("tr");
	for(var i=1;page=rows[i], i<rows.length; i++) {
		page.onclick=function() {
			//var all_links = this.getElementsByTagName("a");
			//Edit is the second last link.
			//var href = all_links[all_links.length-2];
			//document.location.href = href;
			var check = this.getElementsByTagName("td")[1].firstChild;
			check.checked=true;
		}
	}
	
	if(window.main) main();
}
