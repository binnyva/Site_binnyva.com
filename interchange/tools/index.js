function edit(e) {
	JSL.event(e).stop();
	$("text").contentEditable = true;
	$("save-content").show("inline");
	$("show-edit").hide();
}

function save(e) {
	JSL.event(e).stop();
	$("text").contentEditable = false;
	$("save-content").hide();
	$("show-edit").show("inline");
	
	var text = $("text").innerHTML;
	JSL.ajax("index.php?text=" + escape(text) + "&id=" + $("content-id").value).load(saved);
}

function saved() {
	alert("Page Saved");
}

function init() {
	if($("show-edit")) {
		$("show-edit").click(edit);
		$("save-content").click(save);
	}
} 
