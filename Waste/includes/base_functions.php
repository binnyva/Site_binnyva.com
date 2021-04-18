<?php
//Do the stuff that should be done by Magic Quotes
function processQuery() {
	$QUERY = array();

	$post_get = $_POST + $_GET;
	if(gettype($post_get) == 'array') {
		while(list($key,$value) = each($post_get)) {
			if(get_magic_quotes_gpc()) {
				$QUERY[$key] = $value;
			} else {
				$QUERY[$key] = addslashes($value);
			}
		}
	}
	return $QUERY;
}

/** Function : dump()
* Arguments  : $data - the variable that must be displayed
* Prints a array, an object or a scalar variable in an easy to view format.
*/
function dump($data) {
	if(is_array($data)) { //If the given variable is an array, print using the print_r function.
		print "<pre>-----------------------\n";
		print_r($data);
		print "-----------------------</pre>";
	} elseif (is_object($data)) {
		print "<pre>==========================\n";
		var_dump($data);
		print "===========================</pre>";
	} else {
		print "=========&gt;";
		var_dump($data);
		print "&lt;=========";
	}
}

/** Function : buildDropDownArray($array, $name, $selected)
* Arguments  : $array - The array to be used for the dropdown
*				$name - the name and Id of the dropdown
*				$selected - The value that is selected by default.
* Creates a dropdown menu by from the given array and select what is $selected.
*/
function buildDropDownArray($array,$name,$selected="") {
	echo "<select name=\"$name\" id=\"$name\">\n";
	foreach ($array as $key=>$value) {
		echo "	<option value=\"$key\"";
		if($key == $selected) echo " selected='selected'";
		echo ">$value</option>\n";
	}
	echo "\n</select>";
}
?>