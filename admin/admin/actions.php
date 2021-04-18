<?php
// $Id: actions.php,v 1.3 2006/12/06 14:14:30 binnyva Exp $ 

/** Function : addRecord()
* Add the given record to the Database
*/
function addRecord() {
	global $sql,$admin_page,$QUERY;

	//Get the information
	for($i=0;$i<count($admin_page->info);$i++) {
		$cur_info = explode(';',$admin_page->info[$i]);
	
		if(in_array('unique',$cur_info)) { //If anything must be unique
			$value = $QUERY[$admin_page->fields[$i]];
			$sql_add = $sql->getAll("SELECT * FROM $admin_page->db_table WHERE ".$admin_page->fields[$i]."='$value'");
			if(count($sql_add)) { //There is a duplicate.
				$name = str_replace("_","",$admin_page->names[$i]);
				$QUERY['alert']="$name '$value' already exists! Please enter another $name.";
				showForm();
				return;
			}
		}
	}

	if(isset($QUERY['alert']) and $QUERY['alert']) {
		return 0;
	} else {
		$all_values = array();
		$all_fields = array();
		//Get all field names
		foreach($admin_page->fields as $field) {
			if($field != "$admin_page->db_prefix" . "id") {//Don't insert ID - it will be auto_increment.
				array_push($all_fields,"$field");
			}
		}
		$all_fields_str = implode(',',$all_fields);

		//Get all form entries
		for($i=0;$i<count($admin_page->fields); $i++) {
			$info = explode(';',$admin_page->info[$i]);
			$field= $admin_page->fields[$i];
			$name = $admin_page->names[$i];
			$value= $QUERY[$field];
			
			//If there is anything to upload
			if(in_array('upload',$info)) {
				$file_name = "";
				if($_FILES[$field]['name'] or in_array('must',$info)) {
					//If the file is not given and its mandatory,
					if($_FILES[$field]['name'] == "") {
						$QUERY['error'] = "$name must be provided";
						return;
					}
					//Upload the image
					$file_formats = str_replace("%F%","",$info[1]);
					list($file_name, $error) = upload($field, "../user_images/", $file_formats);
					$result = $error;

					if($error) {
						$QUERY['error'] = $result; 
						return;
					}
				}
				array_push($all_values,"'$file_name'");
			
			//Encrypt the password
			} elseif(in_array('password',$info)) {
				array_push($all_values,"MD5('$value')"); //:TODO: We are using MD5 without salt - bad idea. -See http://it.slashdot.org/article.pl?sid=05/08/21/1946254&tid=172&tid=95

			//Allow only the fields that should be in the database
			} else {
				//If the password must be encoded or if you want to do some special processes, 
				//		this is the best place to do it.
				if(in_array('date',$info)) {
					$time_stamp = strtotime(str_replace(',','',$value));
					$datetime = date('Y-m-d',$time_stamp);
					if(in_array('time',$info))
						$datetime = date('Y-m-d H:i:s',$time_stamp);
					
					$value = $datetime;
				}

				if($field != $admin_page->db_prefix."id") {//Don't need the id
					array_push($all_values,"'$value'");
				}
			}
		}
		$all_values_str = implode(',',$all_values);
		
		$sql_insert="INSERT INTO " . $admin_page->db_table ."($all_fields_str) VALUES($all_values_str)";
		$result = $sql -> execQuery($sql_insert);

		if($result) $QUERY['success'] = $admin_page->texts['item_name']." added successfully";
		else $QUERY['error'] = "Internal Error : Could not add a new " . $admin_page->text['item_name'];
	}
}

/** 
* Function : deleteRecord()
* Arguments  : Query Data
* Delete a item from the database whose ID is given as the query data.
*/
function deleteRecord() {
	global $sql,$admin_page,$QUERY;
	
	if(!$admin_page->is_deleteable) return false;

	foreach($_REQUEST['select_row'] as $id) {
		//Delete the uploaded files when the record is deleted
		if(in_array('upload',getInfoSingle())) {
			$info = getInfo();

			//Find all the fields where uploaded file names are stored
			$uploads = array();
			foreach ($info as $field=>$info_bit) {
				if(in_array('upload',$info_bit)) {
					$uploads[] = $field;
				}
			}
			$files_to_delete = $sql->getAssoc("SELECT ".implode(",",$uploads)." FROM $admin_page->db_table WHERE ".$admin_page->db_prefix."id='$id'");
			$uploads_folder = "../user_images/";
			foreach($files_to_delete as $item=>$file) {
				if($file) 
					@unlink($uploads_folder.$file); //Delete the file.
			}
		}

		//Now delete the record.
		if($id) {
			$sql -> execQuery("DELETE FROM $admin_page->db_table WHERE ".$admin_page->db_prefix."id='$id'");
			$QUERY['success'] = $admin_page->texts['item_name']." was deleted succesfully";
		}
	}
}

/** Function : editRecord()
* Update the info in the database as given in the form.
*/
function editRecord() {
	global $sql,$admin_page,$QUERY;

	$sql_query = "";
	$pass = $admin_page->db_prefix."password";//Password field name
	$edits = array();
	
	//Now go thru all fields and extract the necessary data.
	for($i=0;$i<count($admin_page->fields);$i++) {
		$field = $admin_page->fields[$i];
		$type = $admin_page->info[$i];
		
		$info = explode(';',$admin_page->info[$i]);
		$field= $admin_page->fields[$i];
		$name = $admin_page->names[$i];
		$value= i($QUERY, $field);

		//If there is anything to upload
		if(in_array('upload',$info)) {
			$file_name = "";
			if($_FILES[$field]['name']) {
				//If the file is not given and its mandatory,
				if($_FILES[$field]['name'] == "") {
					$QUERY['error'] = "$name must be provided";
					return;
				}
				//Upload the image
				$file_formats = str_replace("%F%","",$info[1]);
				list($file_name,$result) = upload($field, "../user_images/", $file_formats);
				if($result) {
					//If there is an error report it
					$QUERY['error'] = $result; 
					return;
				}
				array_push($edits,"$field='$file_name'");
			}
		//Encrypt the password
		} elseif(in_array('password',$info)) {
			if($value)//Password must be edited only if a password is given.
				array_push($edits,"$field=MD5('$value')"); //:TODO: We are using MD5 without salt - bad idea. -See http://it.slashdot.org/article.pl?sid=05/08/21/1946254&tid=172&tid=95

		//Allow only the fields that should be in the database
		} else {
			//If the password must be encoded or if you want to do some special processes, 
			//		this is the best place to do it.
			if(in_array('date',$info)) {
				$time_stamp = strtotime(str_replace(',','',$value));
				$datetime = date('Y-m-d',$time_stamp);
				if(in_array('time',$info))
					$datetime = date('Y-m-d H:i:s',$time_stamp);
				$value = $datetime;
			}

			if($field != $admin_page->db_prefix."id") //Don't need the id
				array_push($edits,"$field='$value'");
		}

		if($field != $admin_page->db_prefix."id") { //Don't update the ID value.
			if($field != $pass or $value) { //If there is a password field, edit it only if there is value in it
				$sql_query .= "$field='$value',";
			}
		}
	}

	$sql_query = implode(',',$edits);

	$id = $admin_page->db_prefix . "id";
	//Now insert all the stuff into the database.
	$sql_update = "UPDATE $admin_page->db_table SET $sql_query WHERE $id='$QUERY[id]'";
	$sql -> execQuery($sql_update);

	//Show a small notice for the users benifit. :TODO: check whether it is updated before showing the notice.
	$QUERY['success'] = $admin_page->texts['item_name'] . " was updated successfully.";
}


/** 
* Activate/Deactivate all the elements that are given are given in 'select_row'. The argument is the status
*/
function setStatus($status) {
	global $sql,$admin_page,$QUERY;
	
	if(!$admin_page->is_editable) return false;

	foreach($_REQUEST['select_row'] as $id) {
		$sql -> execQuery("UPDATE $admin_page->db_table SET ".$admin_page->db_prefix."status='$status' WHERE ".$admin_page->db_prefix."id='$id'");
	}
	
	$vated = 'deactivated';
	if($status) $vated = 'activated';
	$QUERY['success'] = $admin_page->texts['item_name']." was $vated successfully";
}
