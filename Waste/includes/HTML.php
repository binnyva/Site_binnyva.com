<?php
$html = new HTML();
class HTML {
	function inputRow($name,$label="",$type="text",$value="",$extra="") {
		if(!$label) $label = $this->format($name);
		if(!$value) $value = $_REQUEST[$name];
		if($type=='password') $value = "";

		$class = "field-row";
		if($type != "hidden") {//If type is not hidden show the label - all others need it.
			print "<div class='$class'><label for='$name'>$label</label>";
		}
		if($type == 'datetime' or $type == 'date') {
			$class .= " datetime-row";
			$showsTime = ($type == 'datetime') ? true : false;

			//Convert the PHP date format to the Javascript calendar format.
			$format = preg_replace("/(\w)/","%$1",$GLOBALS['date_format']);
			print<<<END
<input type="text" id="$name" name="$name" value="$value" />
<input type="button" value=" ... " id="date_button_$name" class="date-picker" />
<script type="text/javascript">
Calendar.setup({
	inputField     :    "$name",// id of the input field
	ifFormat       :    "$format",	 	// format of the input field
	showsTime      :    $showsTime,      // will display a time selector
	button         :    "date_button_$name",  // trigger for the calendar (button ID)
	singleClick    :    true,   // double-click mode
	timeFormat     :    12,	    // The time format - 12 hr clock or the 24 Hr clock.
	step           :    1       // show all years in drop-down boxes (instead of every other year as default)
});
</script>
END;
		} elseif($type == "textarea") {
			print "<textarea name='$name' id='$name' cols='70' rows='10' $extra>$value</textarea>";

		} elseif($type == "checkbox") { //checkbox,radio
			print "<input type='$type' name='$name' id='$name' value='1' $extra ";
			if($value) print "checked='checked' ";
			print '/>';
		
		} elseif($type == 'radio') {
			print "<input type='$type' name='$name' $extra ";
			if($value == $_REQUEST[$name] and $value) print "checked='checked' ";
			print '/>';

		} else {//Text,file,hidden,password
			print "<input type='$type' name='$name' id='$name' value='$value' $extra />";
		}

		if($type != "hidden") { echo "</div>\n"; }
	}

	function format($value) {
		$value = preg_replace(
			array("/_/","/([a-zA-Z])(\d)/"),
			array(" ","$1 $2"),
			$value);
		$value = ucwords($value);
		return $value;
	}
}
