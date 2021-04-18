<?php
//Custom - Different for each site
$sql = new MySQL('localhost','root','','openjs'); //Create a new MySQL object - OFFLINE
//$sql = new MySQL('mysql.openjs.com','openjs','My501DB','openjs'); //Create a new MySQL object - ONLINE

/** ************************************************************************************************
* Class  : My(Binny's) SQL
* Author : Binny V A(binnyva@hotmail.com | http://www.bin-co.com/)
* Version: 1.01.A
* Date   : 28 February, 06
* LastMod: 10 August, 06 08:10 pm
***************************************************************************************************
* 	Implements the must commenly used MySQL Functions in a small and easily re-useable class.
* 
***************************************************************************************************/
class MySQL {
	/**
	* Class Constructor
	* 	Connects to the database with the details given as the argument. Exits with error if
	* 		there are problems.
	*/
	function MySQL($db_host,$db_user,$db_password,$db_name) {
		//Connect to the database
		mysql_connect($db_host, $db_user, $db_password) or $this->fatal("Unable to connect to Database Host '".$db_host."'");
		
		//Select the necessary Database
		mysql_select_db($db_name) or $this->fatal("Unable to select the database '" . $db_name . "'.");
	}
	
	///////////////////////////////////// Member Functions ///////////////////////////////////
	/**
	* Function : getSqlHandle()
	* Arguments: $query - MySQL query
	* Return   : The SQL handle.
	* Runs a query in the open MySQL connection and return the handle.
	*/ 
	function getSqlHandle($query) {
		if(!$result = mysql_query($query)) {
			$this->fatal("MySQL Error: ".mysql_error()." in query<br /><div style='color:blue;'>".$query."</div>");
		}
		return $result;
	}

	/**
	* Function : query()
	* Arguments: $query - MySQL query
	* Return   : First row in the query result.
	* Runs a query in the and get the first row.
	*/
	function query($query) {
		$result = $this->getSqlHandle($query);
		$row = $this->_stripsls(mysql_fetch_assoc($result));
		return $row;
	}

	/**
	* Function : runQuery()
	* Arguments: $query - MySQL query
	* Return   : Number of affected rows
	* Runs a query and gets the number of affected rows.
	*/ 
	function runQuery($query) {
		$this -> getSqlHandle($query);
		$rows = mysql_affected_rows();
		return $rows;
	}

	//Returns the results as a numeric array
	function getList($query) {
		$result = $this->getSqlHandle($query);
		$row = mysql_fetch_row($result);
		return $this->_stripsls($row);
	}
	
	//Return just one item.
	function getOne($query) {
		$sql = $this -> getSqlHandle($query);
		$res = mysql_fetch_row($sql);
		return stripslashes($res[0]);
	}

	//Get all the stuff in a database and return it as a list selected by the query given as argument.
	function getAll($query) {
		if(!$query) return "";
		
		$arr = array();
		$result = $this -> getSqlHandle($query);

		$temp = mysql_fetch_row($result);
		if(!$temp) return array(); //If there is not results, just return.


		mysql_data_seek($result,0);
		if(count($temp) <= 2) { //If there is just 1 or two elements, use a Numeric array while getting the data
			while ($all = mysql_fetch_row($result)) {
				if(count($all) == 1) array_push($arr,$all[0]);
				elseif(count($all) == 2) $arr[$all[0]] = $all[1]; //Associative Array.
			}
		} else { //If there is more than 2 elements, get it as a associative array.
			while ($all = mysql_fetch_assoc($result)) {
				array_push($arr,$all);
			}
		}
		return $arr;
	}
	
	//Give the table name, array of fields and the array of data to insert the data.
	function insertArray($table,$names,$arr = array()) {
		if(count($arr) == 0) $arr = $_REQUEST;

		//Get just the nessary data form the given array
		$datas = array();
		foreach($names as $key) {
			array_push($datas,mysql_real_escape_string($arr[$key]));
		}
		$qry = "INSERT INTO $table(" . implode(',',$names) . ") VALUES('" . implode("','",$datas) . "')";
		$this->runQuery($qry);
		return mysql_insert_id();
	}
	
	//Give the table name, where condition, array of fields and the array of data to update the data.
	function updateArray($table,$where,$names,$arr = array()) {
		if(count($arr) == 0) $arr = $_REQUEST;

		//Get just the nessary data form the given array
		$datas = array();
		foreach($names as $key) {
			array_push($datas,$key."='".mysql_real_escape_string($arr[$key])."'");
		}
		$qry = "UPDATE $table SET " . implode(",",$datas);
		if($where) $qry .= " WHERE $where";
		
		return $this->runQuery($qry);
	}
	
	//Do a stripslash on every element of the array and return it.
	function _stripsls($arr) {
		if(is_array($arr)) {
			foreach($arr as $key=>$value) {
				$arr[$key] = stripslashes($value);
			}
		} else {
			$arr = stripslashes($arr);
		}
		return $arr;
	}
		
	/**
	* Call this when a error occurs
	*/
	function fatal($msg) {
		die("<div class='message-error'>$msg</div>");
	}
}
?>