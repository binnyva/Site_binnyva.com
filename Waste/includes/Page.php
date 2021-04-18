<?php
class Page {
	var $title = "";
	var $id = 0;
	var $location = array(); #The location of this page in the site structure - eg. Tcl > Tutorial > Contents
	var $head_data = "";
	
	//Contents
	var $begin_content = "";
	var $sidebar_content = "";
	var $end_content = "";
	
	//Options
	var $show_ad = 1;
	var $page_types = array("normal");

	var $page = array();
	var $section = array();
	var $options = array(
		'show_comments'	=>	1
	);

	//Constructor
	function page() {
		global $loc,$sql;
		
		$url_parts = parse_url($loc);
		$loc = $url_parts['path'];

		//Find the location of the page - needed for breadcrumbs and for Title display(and a lot more other stuff).
		$loc = str_replace('/binnyva','',$loc);
		$loc = str_replace('/','/',$loc);
		//$this->page = $sql->query("SELECT * FROM Pages WHERE page_link='$loc'");
		//$this->id = $this->page['page_id'];
		//$this->page = $sql->query("SELECT * FROM Sections WHERE section_id='$page_section'");
		
		//Breadcrumb information
		if($loc == '/') { //Special Treatment for the main page.
			$this->location = array(
				'id'	=> 1,
				'title'	=> "BinnyVA",
				'link'	=> '/'
			);
		} else {
			//$this->location = getParentSections($this->page['page_section']);
		}
	}
	
	//Add some data to the 'head_data' variable - this will be printed in the printHead() function.
	function addResource($type,$file,$content_type="",$title="") {
		if($type == "script") {
			$this->head_data .= '<script src="'.$file.'" language="javascript" type="text/javascript"></script>'."\n";
		} else {
			if($type == 'style') $type = 'stylesheet';
			if(!$content_type) { //If the content type is not given, find it using the '$type'
				switch($type) {
					case 'stylesheet': $content_type = "text/css"; break;
					case 'alternate' : $content_type = "application/rss+xml"; break;
				}
			}
			
			//Make the link and append it the the 'head_data' variable.
			$this->head_data .= '<link href="'.$file.'" rel="'.$type.'"';
				if($content_type) $this->head_data .= ' type="'.$content_type.'"';
				if($title) $this->head_data .= ' title="'.$title.'"';
			$this->head_data .= " />\n";
		}
	}
	function addMetadata($name,$contents) {
		$this->head_data .= '<meta name="'.$name.'" content="'.$contents.'" />'."\n";
	}
	
	// :OLD: remove this - it is a left over from bin-co
	//Find the title - ie. like - 'Syntax < Perl Tutorial < Perl < OpenJS' - :TODO:
	function parseTitle($title) {
		if(in_array('literal_title',$this->page_types)) { //If the title should be printed as such.
			$this->title = $title;
		} elseif($title) {
			$title_parts = explode(' : ',$title); //My titles is formated this way.
			$full_title = "";

			for($i=count($title_parts)-1; $i>=0; $i--) { //Reverse the order - For Search Engines
				$full_title .= $title_parts[$i] . ' &lt; ';
			}
			$full_title = preg_replace("/ &lt; $/","",$full_title); //Remove the last ' < '.

			$this->title = $full_title;
		}
		return $this->title;
	}

	//////////////////////////////// Display Functions ////////////////////////
	function printHead($title,$type="normal") {
		global $rel;

		$this->page_types = explode(';',$type);

		///:TODO: Find the real title of the page from the $title variable.
		print<<<HEAD_END
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>${title}</title>
<link rel="alternate"  href="${rel}rss.xml" type="application/rss+xml" title="RSS 2.0" />
<link rel="stylesheet" href="${rel}style.css" type="text/css" media="all" />
<script language="javascript" type="text/javascript" src="${rel}common.js"></script>
HEAD_END;
	}

	function printBegin() {
		global $rel;
		//Show other head data(metadata,links etc.) - if any
		if($this->head_data) {
			print $this->head_data;
		}
		print<<<BEGIN_END
</head>
<body>
<table class="root-table"><tr class="toplogo"><td colspan="2">
<table class="top-table"><tr><td>
<A href="${rel}index.php"><IMG SRC="${rel}images/logo.gif" ALT="It's Me" class="logo"></A>
</td>
<td class="top-title-td"><h1 class="title">BinnyVA</h1>
<TABLE class="sites-area"><TR><TD noWrap><a class="sites" href="http://www.bin-co.com/">Bin-Co Source Codes</a></TD>
<TD noWrap><a class="sites" href="http://creationism.binnyva.com/">Creationism</a></TD>
<TD noWrap><a class="sites" href="http://bible.binnyva.com/">Bible Resources</a></TD>
</TR></TABLE></td></tr></table>
</td></tr><tr><td colspan="2">
<table class="navigation"><tr>
<td><A class="nav" href="${rel}index.php">Home</A></td>
<td noWrap><A class="nav" href="${rel}pro/">Programs</A></td>
<td noWrap><A class="nav" href="${rel}others/">Others</A></td>
<td noWrap><A class="nav" href="${rel}myself/">Myself</A></td>
<td noWrap><A class="nav" href="${rel}guestbook.php">GuestBook</A></td></tr></table>
</td></tr>
<tr><td class="text">
BEGIN_END;
		print '<div id="main">';
		print '<div id="content">';
		//$this->showBreadCrumbs();
		print $this->begin_content;
		$this->showAd();
	}
	
	//Print the stuff after the contents - the naviation menu is in this section.
	function printEnd() {
		global $rel,$online;
		print $this->end_content;
		
		print "</div>\n";

		//Sidebar
		//$this->sidebar();

		print "\n</div>";
		print "\n<div id='footer'></div>\n";
		print<<<END_PORTION
<br><center>
<a href="${rel}index.php" class="navsmall">Home</a> | 
<a href="${rel}pro/" class="navsmall">Programs</a> | 
<a href="${rel}myself/" class="navsmall">Myself</a> | 
<a href="${rel}privacy.php" class="navsmall">Privacy Policy</a> | 
<a href="${rel}site_map.php" class="navsmall">Site Map</a></center>
</td></tr></table>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-101361-4";
urchinTracker();
</script>
END_PORTION;

		print "</body></html>";
	}

	function sidebar() {
		global $loc,$online,$rel;
		print '<div id="sidebar">';

		if($this->page['page_title'] and $this->page['page_description']) {
			print '<h3>' . $this->page['page_title'] . '</h3>';
			print '<div class="page-info">' . $this->page['page_description'] . '</div>';
		}
		
		//Some common things for the site.
		?>
<h3>BinnyVA</h3>
<ul class="sidebar-links">
<li><a href="<?=$rel?>">Home</a></li>
</ul>
		<?php
		print $this->sidebar_content;
		print '</div><br style="clear:both;" />';

		if(strpos($loc,'/bva/')) return 1; //Admin Side
	}


	function insertPaging($paging_order,$title="",$short_title="") {
		$this_file = basename($_SERVER["PHP_SELF"]);
		$this->addResource("Start",$paging_order[0]['file']);
		
		//Create a menu
		$section_title = ($short_title) ? $short_title : $title;

		for($i=0; $i<count($paging_order); $i++) {
			$this_page = $paging_order[$i];
			
			//Add items to the menu
			if(!$this_page['hide_in_menu']) {
				$page_title = (isset($this_page['menu_title'])) ? $this_page['menu_title'] : $this_page['title'];
				$anchor_title = '';
				if(strlen($page_title) > 15) {//Cut of the bigger entries.
					$anchor_title = 'title="'.$page_title.'"';
					$page_title = substr($page_title,0,12) . "...";
				}
			}
			
			//Show the paging.
			if($this_page['file'] == $this_file) {
				$last_page = '';
				if($paging_order[$i-1]['file']) $last_page = '<a href="'.$paging_order[$i-1]['file'].'">Previous</a><br />'.$paging_order[$i-1]['title'];
				$next_page = '';
				if($paging_order[$i+1]['file']) $next_page = '<a href="'.$paging_order[$i+1]['file'].'">Next</a><br />'.$paging_order[$i+1]['title'];
				
				$this->begin_content = '<div class="multi-page-navigator-top">
<div class="mpn-previous">'.$last_page.'</div>
<div class="mpn-title"><strong>'.$title.'</strong><br />'.$this_page['title'].'</div>
<div class="mpn-next">'.$next_page.'</div>
</div>';

				if($paging_order[$i-1]['file']) $this->addResource("Prev",$paging_order[$i-1]['file']);

				$this->end_content = '<div class="multi-page-navigator-bottom">
<div class="mpn-previous">'.$last_page.'</div>
<div class="mpn-title"><strong><a href="contents.php">Contents</a></strong></div>
<div class="mpn-next">'.$next_page.'</div>
</div>

		';
				if($paging_order[$i+1]['file']) $this->addResource("Next",$paging_order[$i+1]['file']);
			}
		}
	}

	//Show the breadcrumbs for this page
	function showBreadCrumbs() {
		global $loc;
		if($loc == '/' or $loc == '/') return;
		
		$lnk = $GLOBALS['Config']['site_url'];
		$path = array_reverse($this->location);
 		print '<div id="breadcrumbs"><a href="' . $lnk . '/">OpenJS</a> &gt;  ';
 		foreach($path as $page) {
			if($page['title'] and $page['link'] != $loc)
	 			print '<a href="' . $lnk . $page['link'] . '">'.$page['title'].'</a> &gt; ';
 		}
		print $this->title . '</div>';
	}

	function showAd() {
		global $online;
		if($online and $this->show_ad) {
			print '
<div id="ad">
<script type="text/javascript"><!--
google_ad_client = "pub-6056201776714814";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel = "";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

';
		}
	}
}
