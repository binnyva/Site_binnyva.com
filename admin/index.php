<?php
include('admin_common.php');
$msg = '';

//Upon submiting the form.
if(isset($QUERY['action']) and $QUERY['action'] == 'Login') {
	if($QUERY['username'] and $QUERY['password']) { //See if the login is valid
		$qry_admin = "SELECT id FROM Admin WHERE status='1' AND username='" . $QUERY['username'] . "' AND password=MD5('" . $QUERY['password'] . "')";
		$admin = $sql->getAssoc($qry_admin);

		if($admin) { //Valid login - log it
				$sql -> execQuery( "INSERT INTO Event_Log(user_id,event,time,ip,status)
					VALUES('$admin[id]','Admin Login',NOW(),'" .$_SERVER['REMOTE_ADDR']. "','Valid Login')");
				
				$_SESSION['admin'] = $admin['id'];
				header('Location:main.php');
				exit;
		} else {
			//Log the login attempt
			$msg = "Incorrect Username/Password!";
			$sql -> execQuery( "INSERT INTO Event_Log(user_id,event,time,ip,flagged,status)
			VALUES('0','Admin Login',NOW(),'" .$_SERVER['REMOTE_ADDR']. "',5,
			'Incorrect Login attempt with user \'$QUERY[username]\' and password \'$QUERY[password]\'')");
		}
	} else {
		$msg = "Please enter Username and Password";
	}
	
} elseif(isset($QUERY['logout'])) {
	unset($_SESSION['admin']);
	
} elseif(isset($QUERY['error']) and $QUERY['error'] == "nologin") {
	$msg = "Please login to continue.";
}

render('index.php');
