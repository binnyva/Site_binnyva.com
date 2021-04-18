var links_search = {
	links:new Array(),
	last_value:"",
	holder:"ul",
	individual_element:"li",
	display_type:"list-item",
	holder_id:"sitemap",
	
	
	itemShown:function (ele) {
		return (ele.style.display == this.display_type);
	},
	showAll:function() {
		var all_lis = document.getElementById(this.holder_id).getElementsByTagName(this.individual_element);
		for(var i=all_lis.length-1; i>=0; i--) {
			all_lis[i].style.display = this.display_type;
		}
	},
	filter:function(e) {
		if(!e) var e = window.event;
		var txt = document.getElementById("search").value.toLowerCase();
		
		if(txt == '') {
			links_search.showAll();
			return;
		}
		if(txt == links_search.last_value) return; //No change.
		
		var code=0;
		if (e.keyCode) code = e.keyCode;
		else if (e.which) code = e.which;
		
		var lnks = links_search.links;
		for(var i=0; i<lnks.length; i++) {
			var lnk=lnks[i];
			var individual_element = lnk.ele.parentNode;
			if(links_search.holder == "table") {
				individual_element = lnk.ele.parentNode.parentNode;
			}
			
			if(code == 13) { //Enter key was pressed
				if(links_search.itemShown(individual_element)) {
					document.location.href = lnk.url;
					return;
				}
			}
			
			if(!(lnk.text.indexOf(txt)+1)) { //Given text not found.
				individual_element.style.display = "none";
			} else {
				individual_element.style.display = links_search.display_type;
			}
		}
	},
	init:function (type, holder_id, limit_class) {
		if(type == "table") {
			this.holder = type;
			this.display_type = "table-row";
			this.individual_element = "tr";
		}
		if(holder_id) this.holder_id = holder_id;
		if(limit_class) this.limit_class = limit_class;
		
		var all_links = document.getElementById(this.holder_id).getElementsByTagName("a");
		for(var i=0;i<all_links.length;i++) {
			if(this.limit_class) {
				if(!(all_links[i].className.indexOf(this.limit_class)+1)) continue; //Make sure the specifed class is in the link - search only those links.
			}
			var lnk = {
				'url'	: all_links[i].href,
				'text'	: all_links[i].innerHTML.toLowerCase(),
				'ele'	: all_links[i]
			}
			this.links.push(lnk);
		}
		document.getElementById('search').onkeyup=this.filter;
	}
}

$(window).load(function() {
	document.getElementById("search").focus();
	document.getElementById("search-form").onsubmit=function(e){JSL.event(e).stop(); return false;}
	links_search.init("table", "all-posts", "post-link");
});
