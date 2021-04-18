<?php
if(isset($QUERY['id']) and $QUERY['id']) {
	if(function_exists('adminGetEditData')) { //Enables the programmer to get the data via a custom function.
		$data_row = adminGetEditData($QUERY['id']);
	} else {
		$data_row = $sql->getAssoc("SELECT * FROM $admin_page->db_table WHERE ".$admin_page->db_prefix."id='$QUERY[id]'");//:TODO: The primary key may not have this kind of name
	}
	
	if(isset($QUERY['action']) and $QUERY['action'] == 'view') $admin_page->is_editable=0;
	$Submit = "Edit";
} else {
	$Submit = "Add";
}

?>
<h1 class="heading"><?php echo $admin_page->texts['edit_page_title_' . strtolower($Submit)] . ' ' . $admin_page->texts['item_name']; ?></h1>

<?php
//Show Messages - if any
if($QUERY['error']) {
	echo "<div class='error-message'>$QUERY[error]</div>";
}
elseif($QUERY['success']) {
	echo "<div class='success-message'>$QUERY[success]</div>";
}
elseif(isset($QUERY['notification']) and $QUERY['notification']) {
	echo "<div class='notification-message'>$QUERY[notification]</div>";
}
?>
<div class="alert"><?=i($QUERY,'alert')?></div>

<a href="<?php echo $admin_page->page; ?>"><?php echo $admin_page->texts['back']; ?></a>

<?php
if(isset($admin_page->content['form_start_text'])) print $admin_page->content['form_start_text'];
if($Submit == 'Add') {
	print $admin_page->content['add_form_start_text'];
} else {
	print $admin_page->content['edit_form_start_text'];
} 
//OR print $admin_page->content[strtolower($Submit).'_form_start_text'];
?>

<?php if($admin_page->is_editable or ($admin_page->is_addable and $Submit=='Add')) { ?>
<form name="frm" method="post" action="<?php echo $admin_page->page?>" enctype='multipart/form-data' onsubmit="return validate()">
<?php } ?>

<!-- Form Table -->
<table class="form-root-table">
	<?php
	$mandatory_text = ' <span class="mandatory">*</span>';
	$all_field_info = getInfo();

	for($i=0;$i<count($admin_page->fields); $i++) {
		$input_shown = 0;
		$row_end_text= "";

		if($admin_page->names[$i]) {
			//Get the info about this perticular item.
			$name = $admin_page->names[$i];
			$field_name = $admin_page->fields[$i];
			$value = (isset($QUERY[$field_name])) ? $QUERY[$field_name] : (isset($data_row) ? $data_row[$field_name] : '');
			$value = stripslashes($value);
			
			$field_info = isset($all_field_info[$field_name]) ? $all_field_info[$field_name] : '';

			$name = str_replace('_','',$name); //Remove the '_' - make secret charector

			//The Time format
			global $time_format;
			$time_format = ($time_format) ? $time_format : "%h:%i:%s";
			$time_format_php = str_replace('%','',$time_format);
			//And the Date format
			global $date_format,$date_default;
			$date_format = ($date_format) ? $date_format : "%Y-%m-%d %h:%i:%s";
			$date_format_php = str_replace('%','',$date_format);

			print '		<tr class="form-row"><td class="form-label">' . $name . '</td><td class="form-input">';
			
			//If the page is uneditable - Make all readonly
			if(((!$admin_page->is_editable and $Submit=='Edit') or (!$admin_page->is_addable and $Submit=='Add')) and $name) {
				if($name == " ") {
					print "</td></tr>\n";
					continue;
				}
				$value = ($value) ? $value : "&nbsp;";
				print "<div class='readonly'>";

				//This happens if there is no info - otherwise a warning is made.
				if(!$field_info) {
					print $value;

				//Password
				} elseif(in_array('password',$field_info)) {
					print "********";

				//Time
				} elseif(in_array('timeonly',$field_info)) {
					$timestamp = strtotime(date('Y-m-d') . " $value");
					print date($time_format_php,$timestamp);

				//Date, Time
				} elseif(in_array('date',$field_info)) {
					$timestamp = strtotime($value);
					print date($date_format_php,$timestamp);

				//Textarea
				} elseif(in_array('textarea',$field_info)) {
					print "<div class='textarea-field'>$value</div>";

				//Lists
				} elseif(in_array('list',$field_info)) {
					$key = array_search('list',$field_info);
					$lst = str_replace("%A%","",$field_info[$key+1]);
					print $GLOBALS[$lst][$value];

				} else {
					if(in_array('format',$field_info)) {
						//Format the values before printing it.
						$value = format($value);
					}

					print $value;
				}

				print "</div></td></tr>\n";
				continue;
			}

			//Create the INPUT Elements
			if(isset($admin_page->info[$i])) {
				$checks = split(";",$admin_page->info[$i]);

				//Find which type of input is necessary.
				for($j=0;$j<count($checks);$j++) {
					$current_check = $checks[$j];
					
					//Find the alternate value - given by ;value=whatever keyword.
					if(strpos(i($checks,$j+1),"value=") !== false) {
						list($alt_value) = sscanf($checks[$j+1],"value=%s");
					}

					//Create a dropdown Menu.
					if($current_check == "list") {
						if(strpos($checks[$j+1],"%A%")===false) {
							print "Coding Error : The 'list' value in the \$item_info array must be followed by the name of the array holding the items to be used as the list.";
						} else {
							$var = str_replace("%A%","",$checks[$j+1]);
							$GLOBALS['html']->buildDropDownArray($GLOBALS[$var],$field_name,$value);
							$input_shown = 1;
							break;
						}

					//Password Fields
					} elseif($current_check == "password") {
						if($Submit == 'Add') {
							print '<input type="password" name="'. $field_name .'" id="'. $field_name .'" value="" />'.$mandatory_text.'</td></tr>' . "\n";
							print '<tr class="form-row"><td class="form-label">Re-type Password</td>'
								. '<td class="form-input"><input type="password" name="confirm_password" value="" />'
								. $mandatory_text;

						} else {
							print <<<EOA
<script language="javascript">
function changePassword() {
	document.getElementById("change_password_question").style.display = "none";
	document.getElementById("change_password_field").style.display = "block";
}
</script>
<a id="change_password_question" href="javascript:changePassword();">Change password?</a>
<input id="change_password_field" style="display:none;" type="password" name="$field_name" value="" />
EOA;
						}
						$input_shown = 1;
						break;

					//Date Picker - Shows a javascript calendar which the users can use to select a date.
					} elseif($current_check == "date") {
						//Just the date - or the date and time
						$showsTime = 'false';
						if(i($checks, $j+1) == 'time') {
							$showsTime = 'true';
						}
						if(!$value && $date_default) {
							$value = $date_default;
						}
						if(!$value) $value = date('Y-m-d');
						$time_stamp = strtotime($value);
						$datetime = date(str_replace('%','',$date_format),$time_stamp);

						$js_date_format = $date_format;
						$js_date_format = str_replace('%p','%A',$js_date_format);
						

						print <<<END
<input type="text" id="$field_name" name="$field_name" value="$datetime" />
<input type="button" value=" ... " id="date_button_$field_name" />
<script type="text/javascript">
	Calendar.setup({
		inputField     :    "$field_name",   // id of the input field
		ifFormat       :    "$js_date_format",	 	// format of the input field
		showsTime      :    $showsTime,             // will display a time selector
		button         :    "date_button_$field_name",  // trigger for the calendar (button ID)
		singleClick    :    true,             // double-click mode
		timeFormat     :    12,		// The time format - 12 hr clock or the 24 Hr clock.
		step           :    1                 // show all years in drop-down boxes (instead of every other year as default)
	});
</script>
END;
						$input_shown = 1;
						break;
					//Just the time
					} elseif($current_check == "timeonly") {
						$value = ($value) ? $value : $alt_value;
						$time_value = ($value) ? $value : "00:00:00";
						
						print <<<ENDTIME
<input name="$field_name" id="$field_name" type="hidden" value="$time_value" />
<script language="javascript" type="text/javascript">
new TimeSelector('$field_name',"hidden");
</script>
ENDTIME;
						$input_shown = 1;

					//Mandatory Fields
					} elseif($current_check == "must" or $current_check == "mandatory") {
						$row_end_text = $mandatory_text;

					//Textarea
					} elseif(($current_check == "textarea")) {
						print '<textarea name="'.$field_name.'" id="'. $field_name .'" rows="5" cols="39">'.$value.'</textarea>';
						$input_shown = 1;

					//Checkbox
					} elseif(($current_check == "checkbox")) {
						print '<input type="checkbox" value="1" id="'. $field_name .'" name="'.$field_name.'"';
						print ($value) ? ' checked="checked"' : '' ;
						print ' />';
						$input_shown = 1;

					//Content Editor
					} elseif($current_check == "editor" or $current_check == "fckeditor") {
						include_once("editor.php");
						showEditor($field_name,600,400,"Default",$value);
						$input_shown = 1;

					//Now and Curdate
					} elseif(($current_check == "now") or ($current_check == "curdate")) {
						if($Submit == "Add") {
							if($current_check == "curdate")
								$value = date('Y-m-d');
							else
								$value = date('Y-m-d H:i:s'); 
						}
						if($name) print '<span style="border:1px solid black;padding-right:5px;">'.$value.'</span>';
						print '<input type="hidden" id="'. $field_name .'" name="'.$field_name.'" value="'.$value.'" />';
						$input_shown = 1;

					//Readonly Content
					} elseif(($current_check == "readonly") and ($Submit == "Edit")) {
						print '<input type="hidden" id="'. $field_name .'" name="'.$field_name.'" value="'.$value.'" />';

						if(in_array('format',$checks)) $value = format($value);
						print '<span class="readonly-field">'.$value.'</span>';
						
						$input_shown = 1;
					
					//Show
					} elseif($current_check == "show" and ($Submit == "Edit")) {
						if(in_array('format',$checks)) $value = format($value);
						print '<span class="readonly-field">'.$value.'</span>';
						$input_shown = 1;

					//Hidden
					} elseif($current_check == "hidden") {
						if(($Submit == 'Add' or $checks[$j+2] == "permanent") and $alt_value) {
							$value = $alt_value;
						}
						print '<input type="hidden" id="'. $field_name .'" name="'.$field_name.'" value="'.$value.'" />';
						$input_shown = 1;

					//Uploadable Content
					} elseif($current_check == "upload") {
						print '<input type="file" id="'. $field_name .'" name="'.$field_name.'" value="" />';

						if(strpos($checks[$j+1],"%F%")>=0) {
							$file_formats = str_replace("%F%","",$checks[$j+1]);
						}
						if ($Submit == "Edit") {
							//Show the image here - if it is an image.
							if($value && (strpos($file_formats,"jpg") >=0 )) {
								print '<img src="../user_images/'.$value.'" class="privew-image" />';
							}
						}
						$input_shown = 1;

					} elseif($name == "Status" or $checks[0]=="radio") { //$Submit == "Edit" and 
						//The STATUS Field
						print 'Active <input type="radio" name="'.$field_name.'" value="1" ';
						if($value != '0' or $value == "" or $value==NULL) echo "checked='checked'";
						print ' /> | Inactive <input type="radio" name="'.$field_name.'" value="0" ';
						if($value == '0') echo " checked='checked'";

						//The Superadmin must be un-editable
						if(isset($QUERY['id']) and $QUERY['id']==1) {
							if(strpos($admin_page->title,"Administrator") === false);
							else {
								print ' disabled="disabled"';
							}
						}
						print ' />';

						$input_shown = 1;
					}
				}
			}

			if(!$input_shown) {
				//The default INPUT Text Field
				print '<input type="text" id="'. $field_name .'" name="'. $field_name .'" value="' . $value . '" />';
			}

			print $row_end_text . "</td></tr>\n";
		}
	}
	$submit_label = ($Submit == "Add") ? $admin_page->texts['add_submit'] : $admin_page->texts['edit_submit'];

	if(($admin_page->is_editable and $Submit=='Edit') or ($admin_page->is_addable and $Submit=='Add')) {
	?>
	<tr class="form-submit-row"><td>&nbsp;</td><td class="form-submit"><input type="submit" name="action" value="<?php echo $submit_label; ?>" onClick="return validate()" /></td></tr>
	<?php } ?>
</table>

<?php if(($admin_page->is_editable and $Submit=='Edit') or ($admin_page->is_addable and $Submit=='Add')) { ?>
<input type="hidden" name="id" value="<?php echo i($QUERY,'id');?>" />
<input type="hidden" name="page" value="<?=i($QUERY,'page')?>" />
<input type="hidden" name="items_per_page" value="<?=i($QUERY,'items_per_page')?>" />
<input type="hidden" name="search" value="<?=i($QUERY,'search')?>" />
<input type="hidden" name="search_in" value="<?=i($QUERY,'search_in')?>" />
<input type="hidden" name="sortasc" value="<?=i($QUERY,'sortasc')?>" />
<input type="hidden" name="sortdesc" value="<?=i($QUERY,'sortdesc')?>" />
<?php
//If any extra parameters were given, conserve it by given it as giving it as hidden items
if($admin_page->extra_param) {
	$params = explode('&',$admin_page->extra_param);
	foreach($params as $para) {
		list($para_name,$para_value) = explode('=',$para);
		print "	<input type='hidden' name='$para_name' value='$QUERY[$para_name]' />\n";
	}
}
?>
</form>
<?php 
}
if($Submit == 'Add') {
	print $admin_page->content['add_form_end_text'];
} else {
	print $admin_page->content['edit_form_end_text'];
} 
//OR print $admin_page->content[strtolower($Submit).'_form_start_text'];
?>

<a href="<?php echo $admin_page->page; ?>"><?php echo $admin_page->texts['back']; ?></a>
<!-- This method has its advantages and its disadvantages - an alternate method is...
<a href="javascript:history.back();"><?php echo $admin_page->texts['back']; ?></a>
-->