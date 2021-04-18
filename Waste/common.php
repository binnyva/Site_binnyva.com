<?php
include('configuration.php');
//include('includes/MySQL.php');
include('includes/base_functions.php');
$rel = findRelation();//Menu needs this.
include('includes/HTML.php');
include('includes/Page.php');

//Global Variables...
$QUERY = processQuery();
$loc = $_SERVER["REQUEST_URI"];//Location of the current file.
$date_format = 'd M, Y - h:i A';
$email_html = '<span class="email-encrypt">moc.liamg@avynnib<span class="email-decrypt-message">(Reverse this text to get my Email address)</span></span>';//Decrypt using CSS.
$online = 0; //1 if we are in the net and 0 if we are at home.
if(strpos($_SERVER['HTTP_HOST'],'localhost') === false and strpos($_SERVER['HTTP_HOST'],'127.') === false) {
	$online = 1;
}

$page = new Page();
$msg_success = "";
$msg_error = "";

//Find the relation between the page we are in and the root folder.
function findRelation() {
	$rel = "";
	$depth = 0;
	while($depth < 10) { //We don't want an infinite loop - do we?
		if(file_exists($rel . "configuration.php")) break; //We reached the root
		else $rel .= "../"; //Go to the top folder.

		$depth++;
	}
	return $rel; 
}

///////////////////////////////////// Listing Functions ////////////////////////////////////////
//Get the list of Items in the given Section that was edited at the latest.
//'$show' will be 0 for showing all items...
function getListData($section,$more_link,$show,$extra_query='') {
	global $sql;
	$limit = "";
	if($show) $limit = "LIMIT 0,$show";
	$section_items = $sql->getAll("SELECT page_link,page_title,page_description,page_modified
		FROM Pages INNER JOIN Sections ON section_id=page_section
		WHERE (section_parent='$section' OR section_parent_2='$section' OR section_parent_3='$section') 
		AND section_status='1' AND page_status='1' AND page_order<=1 AND page_is_content='1' $extra_query
		ORDER BY page_modified DESC,section_is_series
		$limit");
	$individual_items = $sql->getAll("SELECT page_link,page_title,page_description,page_modified FROM Pages 
		WHERE page_section='$section' AND page_status='1' AND page_order<=1
		AND page_is_content='1' $extra_query
		ORDER BY page_modified DESC
		$limit");
	$items = array_merge($section_items,$individual_items);
	
	//For sorting an array, we have to put the array in the global scope - 
	// so that comparing function will get it as The 'uksort' function will just provide the keys of the array.
	$GLOBALS['temp_items'] = $items;
	uksort($items, "compareByModifiedDate");
	
	return $items;
}
//Callback function for the uksort function.
function compareByModifiedDate($a_index, $b_index) {
	//Get the array elements for both the provided indexes.
	$a = $GLOBALS['temp_items'][$a_index];
	$b = $GLOBALS['temp_items'][$b_index];
	if ($a['page_modified'] == $b['page_modified']) return 0;
	return ($a['page_modified'] > $b['page_modified']) ? -1 : 1;
}
function showLinkList($section,$more_link='',$show=5) {
	$items = getListData($section,$more_link,$show);
	
	if(count($items)) {
		print "<ul>\n";
		foreach($items as $item) {
			$link = $item['page_link'];
			$title= $item['page_title'];
			if(!$GLOBALS['online']) $link = '/openjs' . $link; //Small Fix to make it work offline
			$date = date('dS M, Y',strtotime($item['page_modified']));

			print "<li><a href='$link' title='$date'>$title</a></li>\n";
		}
		if($show) print "<li><a href='$more_link'>More...</a></li>\n";
		print "</ul>\n";
	}
}
function showDescriptionList($section,$more_link='',$show=5,$extra_query="") {
	$items = getListData($section,$more_link,$show,$extra_query);

	if(count($items)) {
		print "<dl>\n";
		foreach($items as $item) {
			$link = $item['page_link'];
			if(!$GLOBALS['online']) $link = '/openjs' . $link; //Small Fix to make it work offline
			$date = date('dS M, Y',strtotime($item['page_modified']));

			print "<dt><a href='$link' title='$date'>$item[page_title]</a></dt>\n";
			print "<dd>" . stripslashes($item['page_description']) . "</dd>\n";
		}
		if($show) print "<li><a href='$more_link'>More...</a></li>\n";
		print "</dl>\n";
	}
}

//This is a recursive function that keeps on calling a SQL statement - beware of this one.
function getParentSections($id) {
	global $sql;
	//All the details we need for a page
	$section = $sql->query("SELECT section_parent,section_link,section_title FROM Sections WHERE section_id='$id'");
	$this_page = array(
		'id' 	=> $id,
		'title'	=> $section['section_title'],
		'link'	=> $section['section_link']
	);

	//Get all the details of the parent pages in an array
	$parents = array();
	if($section['section_parent']) 
		$parents = array_merge(array($this_page),getParentSections($section['section_parent'])); //:RECURSION:
	else
		$parents = array_merge($parents,array($this_page));

	//Just a small safeguard to make sure that the server don't commit suicide.	
	if(count($parents) > 10) {return 0;}
	if(count($parents) > 15) { //Kill the site rather than let the server down.
		dump($parents);
		die("Error : Got a infinite recursive function called 'getParentSections()' in file " . __FILE__ . ", line ".__LINE__);
	}

	return $parents;
}

function showFeedbackForm($article,$extra="") {} // :REMOVE:


/////////////////////////////////////////// Shortcut Functions //////////////////////////////////////////
function printHead($title,$type="normal") {
	$GLOBALS['page'] -> printHead($title,$type);
}
function printBegin() {
	$GLOBALS['page'] -> printBegin();
}
function printEnd() {
	$GLOBALS['page'] -> printEnd();
}
function printTop($title) {
	$GLOBALS['page'] -> printHead($title);
	$GLOBALS['page'] -> printBegin();
}

//waste
function insection() {}
