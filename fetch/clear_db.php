<?php
include('../common.php');

if(!isset($QUERY['i_am_sure']) or $QUERY['i_am_sure'] != 'yes') {
	print 'This will clear the database. Are you sure? <a href="?i_am_sure=yes">Yes</a> <a href="..">No</a>';
	exit;
}
print 'Resetting the database...<br /><br />';

$quries = <<<END
UPDATE Feed SET `last_modified`='0000-00-00 00:00:00';
TRUNCATE TABLE Post;
TRUNCATE TABLE Tag;
TRUNCATE TABLE PostTag;
END;

$all_quires = explode("\n",$quries);
foreach($all_quires as $query) {
	$query = trim($query);
	// Enable this only if you are sure // if($query) $sql->execQuery($query);

	print $query . '<br />';
}

