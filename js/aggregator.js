function init() {
	$(".post").on("mouseover", function(e) {
		var id = this.id.replace(/[^\d]/g,"");
		var pos = $(this).getPosition();
		
		var summary = $("#summary");
		if(!summary) return;
		
		summary.innerHTML = $("summary-"+id).innerHTML.replace("\n", "<br />");
 		summary.setStyle({"top": pos.top + 30, "left": pos.left});
 		summary.show();
	});
	
	$(".post").on("mouseout", function(e) {
		$("#summary").hide();
	});
}
