<?php
require('admin_common.php');

$date_format = str_replace('%','',$config['date_format']);
//Get the time that this admin logged in - not counting this login.
$last_login_details = $sql->getAssoc("SELECT time,ip FROM Event_Log WHERE user_id='$_SESSION[admin]' AND event='Admin Login' ORDER BY time DESC LIMIT 1,1");
$last_login_ip = i($last_login_details,'ip');
$last_login = i($last_login_details, 'time');

//The difference between 2 given time - chances are PHP already have a native function for that.
function dateDifference($day_1,$day_2) {
	$diff = strtotime($day_1) - strtotime($day_2);

	$sec   = $diff % 60;
	$diff  = intval($diff / 60);
	$min   = $diff % 60;
	$diff  = intval($diff / 60);
	$hours = $diff % 24;
	$days  = intval($diff / 24);
	
	return array($sec,$min,$hours,$days);
}

printHead("Admin Area : Main");
?>
<style type="text/css">
.row-odd {background-color:#ccc;}
.subject {color:#3b90ff;font-weight:bold;}
.responses-data {
	width:100%;
	border-collapse:collapse;
}
.responses-data .message {
	width:70%;
}
.box {
	display:block;
	width:100px;
	height:50px;
	background:#ccc;
	border:1px solid black;
	margin:10px;
	float:left;	
}
</style>
<?php printBegin(); ?>
<a href="index.php?logout=true">Log Out</a><br /><br />

<?php if($last_login_details) { ?>
Last Login : <span class="notice"><?php
	$diff = dateDifference(date('r'),$last_login);
	print $diff[3] . ' days, ' . $diff[2] . ' hours ago(';
	print date($date_format,strtotime($last_login));
	print ") from <a href='http://$last_login_ip/' target='_blank'>$last_login_ip</a>(Current IP $_SERVER[REMOTE_ADDR])";
?></span><br />
<?php }

//Show any logins that were made that were invalid.
$handle = $sql->getSql("SELECT time,ip,flagged,status FROM Event_Log WHERE time>'$last_login' AND event='Admin Login' AND flagged>0 LIMIT 0,50");
if($sql->fetchNumRows($handle)) { ?>
<h2>Illegal Login Attempts</h2>
<table><?php
	$class = "odd";
	while($row = $sql->fetchAssoc($handle)) {
		$class = ($class == "odd") ? "even" : "odd";
		print "<tr class='row-$class'><td>$row[time]</td><td><a href='http://$row[ip]' target='_blank'>$row[ip]</a></td>" .
			"<td class='alert-level-$row[flagged]'>$row[status]</td></tr>\n";
	}
?>
</table>
<?php } ?>

<ul>
<li><a href="blogs.php">Blogs/Feeds</a></li>
<li><a href="posts.php">Posts</a></li>
<li><a href="logs.php">Log</a></li>
</ul>


<?php
printEnd();
