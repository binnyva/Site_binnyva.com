<?php
//Global variables
$msg = "";

/** Function : upload()
* Arguments  :	$file_id - the name of the file field in the HTML Form.
*				$folder  - the folder to which all uploaded files must be put.
* Returns	 : $result - A string with a message of success or error.
* Uploads the file from a HTML Form and put it in the folder specifed as the '$folder' argument.
*/
function upload($file_id,$folder="") {
	$file_name = $_FILES[$file_id]['name']; //Get file name

	//Where the file ust be uploaded to
	if($folder) $folder .= '/';//Add a '/' at the end of the folder
	$uploadfile = $folder . $file_name;

	//Move the file from the stored location to the new location
	if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
		$result = "<span class='upload-error'>Error : Cannot upload the file '$file_name'.</span>"; //Show error if any.
	}
	else {
		$result = "<span class='upload-success'>Uploaded file '$file_name' successfully.</span>"; //Show the success message
	}

	return $result;
}

$msg = "";
if ($_REQUEST['action'] == "Submit") {
	for($i=1;$i<=10;$i++) {
		if($_FILES['file'.$i]['name'] != "") { //Make sure that a file was selected.
			$msg .= upload("file".$i,"../in") . "<br />";
		}
	}
}
?>
<html><head>
<link rel="shortcut icon" href="favicon.ico" />
<title>Language References</title>
<style>
.upload-error { color:red; }
.upload-success { color:darkgreen;font-weight:bold; }
</style>
</head>
<body>
<?php echo $msg; ?>

<form name="form1" method="post" enctype="multipart/form-data">
<div id="stuff">
<span>File 1  </span><input size="30" name="file1" type="file"><br>
<span>File 2  </span><input size="30" name="file2" type="file"><br>
<input name="action" value="Submit" type="submit"></div>
</form>


</body>
</html>	