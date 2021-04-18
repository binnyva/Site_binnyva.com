<?php
/**********************************************************************************************
* Name    : AdminRender
* Version : 1.00.A
* All the pages of the administration side are rendered by this script.
**********************************************************************************************/
include('actions.php');

//Find Which section we are on...
$section = "Display";
if(isset($QUERY['action'])) {
	if($QUERY['action'] == "edit" or $QUERY['action'] == "edit_form") $section = "Edit";
	elseif($QUERY['action'] == "add" or $QUERY['action'] == "add_form") $section = "Add";
}

/////////////////////////////////// Action Functions //////////////////////////////////////////
function renderAdminPage() {
	global $date_format;
	if(!isset($date_format)) $date_format = 'd M, Y - h:i A';

	printAdminHead();
	doAction();
	printEnd();
}
/**
 * Decides what is to be done by looking at the 'action' element in the query. This is there
 *		equvivalent of the main loop. Calls the other functions based on the contents of 
 *		the 'action' parameter.
 */
function doAction() {
	global $QUERY,$admin_page;
	//Decide what to do...
	switch(i($QUERY,'action')) {
		case 'view'			:
		case 'add_form'		: showForm(); break; //Show the adding form
		case $admin_page->texts['add_submit']	: addRecord(); //Add the data given in the form to the database.
							  if(!i($QUERY,'alert')) display();
							  break;
		case 'edit_form' 	: showForm(); break; //Show the edit form.
		case $admin_page->texts['edit_submit'] : editRecord(); //Edit the data in the database.
							  if(!i($QUERY,'alert')) display();
							  //showForm();
							  break;
		case 'delete_record': deleteRecord(); //Delete a record.
							  if(!i($QUERY,'alert')) display();
							  break;
		case 'activate'		: setStatus(1);display();break;
		case 'deactivate'	: setStatus(0);display();break;
		default 			: display(); //If nothing, just display the data.
	}
}

/**
 * Function to display all the records with paging. This function finds the format 
 *		of the data and will display it accordingly.
 */
function display() {
	global $admin_page,$QUERY;
	include("display.php");
}

/**
 * Shows the form from which the admin can add/edit data. All the fields are created according 
 *		to the format specified for that data. For example, the if the list keyword is used,
 *		a dropdown menu will be shown or if a textarea keyword is specified, a textarea will 
 *		be shown.
 */
function showForm() {
	global $admin_page,$QUERY,$coding_error,$sql;
	
	include("form.php");
}
///////////////////////////////////// Other General Functions ///////////////////////////////
/**
 * This will print the head part of all HTML Pages. That will include the Javascript validation
 *		for the Add/Edit forms, the javascript files for Calendar, Date Selector etc.
 */
function printAdminHead() {
	global $admin_page,$QUERY,$sql,$section;
	
	includeAdminHead($admin_page->title);
	if($admin_page) {
		if($section == "Edit" or $section == "Add") {
			$included_calender = 0;
			//Check whether there is a date picker option - if yes print the following includes
			foreach($admin_page->info as $info_bit) {
				$info_arr = explode(';',$info_bit);
				if((in_array('date',$info_arr) or in_array('time',$info_arr)) and (!$included_calender)) {
					$included_calender = 1;
					print <<<TOEND
<link href="js/jscalendar/calendar-blue.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-en.js"></script>
<script type="text/javascript" src="js/jscalendar/calendar-setup.js"></script>
	
TOEND;
				}
				if(in_array('timeonly',$info_arr)) {
					print '<script src="js/timeselector.js"></script>'."\n";
				}
			}
		}
		if($admin_page->code['embedded_styles']) {
			print "<style type='text/css'>\n" . $admin_page->code['embedded_styles'] . "\n</style>";
		}
	}
?>

<?php if(($admin_page->is_editable and $section=='Edit') or ($admin_page->is_addable and $section=='Add')) {

if(isThereOption('date')) { ?>
<script type="text/javascript" src="js/date_functions.js"></script>
<?php } ?>
<script type="text/javascript" src="js/form_functions.js"></script>

<script type="text/javascript">
date_format = "<?php echo $GLOBALS['date_format']; ?>";

function validate() {
<?php
		for($i=0;$i<count($admin_page->fields); $i++) {
			if($admin_page->names[$i]) {
				//Get the info about this perticular item.
				$name = $admin_page->names[$i];
				$field_name = $admin_page->fields[$i];

				$name = str_replace('_','',$name); //Remove the '_' - make secret charector

				//Create the INPUT Elements
				if($admin_page->info[$i]) {
					$checks = split(";",$admin_page->info[$i]);
		
					//Find which type of input is necessary.
					for($j=0;$j<count($checks);$j++) {
						//Password Fields
						if($checks[$j] == "password") {
							if($Submit == 'Add') { ?>
	if(document.frm.<?php echo $field_name; ?>.value != document.frm.confirm_password.value) {
		alert("The given passwords does not match.");
		document.frm.<?php echo $field_name; ?>.focus();
		return false;
	}
							<?php } else { ?>
	if(document.frm.<?php echo $field_name; ?>.value != "") {
		if(document.frm.<?php echo $field_name; ?>.value != document.frm.confirm_password.value) {
			alert("The given passwords does not match.");
			document.frm.<?php echo $field_name; ?>.focus();
			return false;
		}
	}
							<?php
							}

						//Date Picker
						} 
						if($checks[$j] == "date") { ?>
	if(!checkDate(document.frm.<?php echo $field_name; ?>.value,"<?php echo isset($checks[$j+1]) ? $checks[$j+1] : ''; ?>")) {
		alert("Please provide a valid date");
		document.frm.<?php echo $field_name; ?>.focus();
		return false;
	}
						<?php
						//Mandatory Fields
						}
						if($checks[$j] == "must" or $checks[$j] == "mandatory") {
							//These stuff must be mandatory only while adding.
							if( (!in_array('password',$checks) or $Submit == "Add") and
								(!in_array('upload',$checks) or $Submit == "Add")) {
						?>
	if(stripWierd(document.frm.<?php echo $field_name; ?>.value) == "") {
		alert("Please enter the <?php echo $name; ?>");
		document.frm.<?php echo $field_name; ?>.focus();
		return false;
	}
						<?php
							}
						//Name
						}
						if($checks[$j] == "name") { ?>
	if(document.frm.<?php echo $field_name; ?>.value.match(/[\d\_\~\!\@\#\$\%\^\&\*\(\)\_\+\|\\\=\-\{}\[\]\:\"\;\<\>\?]/)) {
		alert("Please enter a proper name");
		document.frm.<?php echo $field_name; ?>.focus();
		return false;
	}					<?php
						//Number
						}
						if($checks[$j] == "number") { ?>
	if(isNaN(document.frm.<?php echo $field_name; ?>.value)) {
		alert("Please enter the a numeric value in this field.");
		document.frm.<?php echo $field_name; ?>.focus();
		return false;
	}
						<?php
						//Email Fields
						}
						if($checks[$j] == "email") { ?>
	if(!document.frm.<?php echo $field_name; ?>.value.match(/^[\w\.\-]+\@[\w\.\-]+\.[a-z\.]{2,6}$/)) {
		alert("Please enter the a valid Email address");
		document.frm.<?php echo $field_name; ?>.focus();
		return false;
	}
						<?php
						//Uploadable Content
						}
						if($checks[$j] == "upload") {
							if(strpos($checks[$j+1],"%F%")>=0) {
								$file_formats = str_replace("%F%","",$checks[$j+1]);
								$allowed_formats = explode(',',$file_formats);
								$allowed_formats_check = "";
								foreach($allowed_formats as $ext) {
									$allowed_formats_check .= "ext != \"$ext\" && ";
								}
								$allowed_formats_check = substr($allowed_formats_check,0,-4);//Remove the last ' && '
						?>

	var ext = getFileExtention(document.frm.<?php echo $field_name; ?>.value);
	if (<?echo $allowed_formats_check; ?> && document.frm.<?php echo $field_name; ?>.value != "") {
		alert("The given format("+ext+") is not a valid file for this upload.");
		document.frm.<?php echo $field_name; ?>.focus();
		return false;
	}
<?php
							}
						}
					} //end of for($j=0;$j<count($checks);$j++) {
				}
			}
		} //end of for($i=0;$i<count($admin_page->fields); $i++) {
		print "return true;\n}\n\n";
		print "/******** Custom Code *********/\n";
		if(isset($admin_page->code['javascript'])) print $admin_page->code['javascript'] . "\n";
		if(isset($admin_page->code['form_javascript'])) print $admin_page->code['form_javascript'] . "\n";
		if(isset($admin_page->code[strtolower($section) . '_javascript'])) print $admin_page->code[strtolower($section) . '_javascript'] . "\n";
		?></script><?php

///////////////////////////// Javascript for the display screen ///////////////////////////////
} elseif($section == 'Display') {
	
	if($admin_page->code['javascript'] or $admin_page->code['display_javascript']) {
		print '<script type="text/javascript">';
		print $admin_page->code['javascript'];
		print "\n".$admin_page->code['display_javascript']."\n</script>";
	}
?>
<script type="text/javascript" src="js/display_functions.js"></script>
<?php }


///////////////////////// All Javascript files for including ///////////////////////////////////
		if(isset($admin_page->code['javascript_include'])) { ?>
<script type="text/javascript" src="<?php echo $admin_page->code['javascript_include']; ?>"></script>
		<?php
		}
	includeAdminBegin();
}

//Returns the info array of every element in the page as an associative array with the field_name as
//	the key and the array as the value part.
function getInfo() {
	global $admin_page;
	$info = array();

	for($i=0;$i<count($admin_page->info); $i++) {
		if($admin_page->info[$i]) {
			$info[$admin_page->fields[$i]] = split(";",$admin_page->info[$i]);
		}
	}
	return $info;
}

//Get all the info as one numeric array
function getInfoSingle() {
	$info = getInfo();
	$new_info = array();
	foreach ($info as $field=>$info_bit) {
		$new_info = array_merge($new_info,$info_bit);	
	}
	return $new_info;
}

//Search the infos of this page to see wherether the given info exists in them.
function isThereOption($option) {
	global $admin_page;
	//Check whether there is the given option - if yes print the following includes
	foreach($admin_page->info as $info_bit) {
		$info_arr = explode(';',$info_bit);
		if(in_array($option,$info_arr)) {
			return true;
		}
	}
	return false;
}

//////////////////////////////////////// Classes /////////////////////////////////////////////
//The object of this class will hold all the details about this page.
class AdminPage {
	var $title = "";//The title of this page
	var $admin_page  = "";//The page's filename - given to 'a href'

	var $db_table  = ""; //Name of the table from which the data can be extracted
	var $db_prefix = ""; //The prefix of field names in that table

	var $main_query = "";//The query that is used to display the data.
	var $extra_param= "";//Extra parameters that must be appended to the end of the file url.(eg. index.php?date=13)

	var $is_editable   = 1;//Shows the Edit link for every row.
	var $is_deleteable = 1;//Shows the 'Delete' link for every row.
	var $is_addable	   = 1;//Shows the 'Add' link at the top
	var $is_sortable   = 1;//Decides wether the page fields are sortable or not.
	
	var $show_count	= 1; //Decides whether or not to show the counter to the left in the display pages

	var $texts = array(
		'add_new_link'	=> "Add New",
		'add_submit'	=> "Add",
		'edit_submit'	=> "Edit",
		'back'			=> "Go Back",
		'edit_item'		=> "<img src='images/icons/edit.gif' alt='Edit' />",
		'delete_item'	=> "<img src='images/icons/delete.gif' alt='Delete' />",
		'edit_page_title_edit'	=> "Edit",
		'edit_page_title_add'	=> "Add",
		'item_name'		=> ""
	);
	var $content = array(
		'display_end_text'		=> "",	//Show this at the display page.
		'display_start_text'	=> "",
		'add_form_end_text'		=> "",	//Show this at the end of the add form. :TODO:
		'add_form_start_text'	=> "",
		'edit_form_end_text'	=> "",	//Show this at the end of the edit form :TODO:
		'edit_form_start_text'	=> ""
	);
	var $code = array(
		'embedded_styles'		=> '',	//The styles that is to be used in the page.
		'javascript'			=> '',	//Extra Javascripts to be used.
		'add_javascript'		=> '',
		'edit_javascript'		=> '',
		'display_javascript'	=> ''
	);

	//Database fields, their names, and types
	var $names  = array();
	var $fields = array();
	var $info   = array();

	//Constructor 
	function AdminPage($title,$admin_page="",$db_table,$db_prefix="",$item_names,$item_fields,$item_info) {
		//Initialize all the variables
		$this -> title 		= $title;
		$this -> page  		= $admin_page;
		$this -> db_table	= $db_table;
		$this -> db_prefix	= $db_prefix;
		$this -> names		= $item_names;
		$this -> fields		= $item_fields;
		$this -> info		= $item_info;
		$this -> texts['add_new_link'] = "Add New $title";
		$this -> texts['item_name'] = preg_replace("/e?s$/","",$title);//Makes the plurels in the title singular
	}

	//Get a link to the page.
	function getLink($more_param="") {
		$link = $this -> page;

		//If extra parameters are given.
		if($this->extra_param) {
			$link .= "?$this->extra_param";
			if($more_param) {
				$link .= "&amp;$more_param";
			}
		} else {
			if($more_param) {
				$link .= "?$more_param";
			}
		}
		return $link;
	}
}

/// Layout Includes
function includeAdminHead($title) {
	global $template, $config;
	require('templates/layout/head.php');
}

function includeAdminBegin() {
	global $template, $config;
	require('templates/layout/begin.php');
}

/************************************** To Do ***********************************************
* Search for the term ':TODO:' to find what all that is yet to be done.
* Server Side Form Validation
* Sort order implementation
* The implementation of radio buttons.
* Getting data from muliple databases.
* All Output messages must be extracted and put in varaibles(localization - Hehe).
*********************************************************************************************/
?>