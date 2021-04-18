<?php
include('../../common.php');

$password = 'noyoume';
$content_id = i($_GET, 'id');
$txt = '';
$name = '';

if(i($_GET, 'pass') == $password) $_SESSION['admin'] = true;
elseif(!isset($_SESSION['admin'])) $_SESSION['admin'] = false;

//If the save button is clicked, save the data
if(isset($_REQUEST["text"]) and $_REQUEST["text"]) {
	if($content_id) {
		$sql->execQuery("UPDATE Data SET content='$QUERY[text]', edited_on=NOW() WHERE id=$content_id");
		$msg = "Success, saved the data.";
	} else {
		$sql->execQuery("INSERT INTO Data (name, content, added_on, edited_on, status) 
			 VALUES('$QUERY[name]', '$QUERY[text]', NOW(), NOW(), '1')");
		$content_id = $sql->fetchInsertId();
		$msg = "Success, created the page.";
	}
	$_GET['action'] = 'list';
}

// Get The contents
if($content_id) {
	$data = $sql->getAssoc("SELECT name, content, edited_on FROM Data WHERE id=$content_id");
	$name = $data['name'];
	$edited_on = $data['edited_on'];
	$txt = stripslashes(trim($data['content']));
	
	// A Special situation - full HTML file is there in the DB.
	if(preg_match('/^\s*<!DOCTYPE/', $txt) or preg_match('/^\s*<html/', $txt) or preg_match('/^\s*<?xml/', $txt)) {
		//Its a full HTML File - print and exit.
		print $txt; exit;
	}
}

$template->addResource('index.css', 'css', true);
printTop('Web Notepad');

///////////////////////////////// The Add/Edit Form ////////////////////////
if(i($_GET, 'action') == 'form' and $_SESSION['admin']) {
	?>
<form name="ftext" id="ftext" method="post">
<label for="name">Name</label>
<input type="text" name="name" id="name" value="<?=$name?>" /><br />
<textarea name="text" id="text" rows="30" cols="90"><?=$txt?></textarea>

<br style="clear:both;" />
<input type="hidden" value="<?=i($_GET, 'id')?>" name='id' />
<input type="submit" value="Save" />
<input type="reset" value="Clear" />
</form>
<a href="index.php">List All</a><br />

	<?php

///////////////////////////////// Content Display /////////////////////////
} else if($content_id) { // If the name is given, show that page
	print "<h2>$name</h2>\n";
	print "<h4>Last edited on: " . date('d<\s\u\p>S</\s\u\p> M, Y', strtotime($edited_on)) . "</h4>\n";
	
	$out = $txt;
	//Auto link hyperlinks
	$out = preg_replace(
		'/([^\'\"\=\/]|^)(http:\/\/|(www.))([\w\.\-\/\\\=\?\%\+\&]+?)([\.\?])?(\s|$)/',
		"$1<a rel='nofollow' href='http://$3$4'>$3$4</a>$5$6",
		$out);
	$out = preg_replace( //Two times as an insurence.
		'/([^\'\"\=\/]|^)(http:\/\/|(www.))([\w\.\-\/\\\=\?\%\+\&]+?)([\.\?])?(\s|$)/',
		"$1<a rel='nofollow' href='http://$3$4'>$3$4</a>$5$6",
		$out);
	
	//Find the text to be inside the Hyperlink.
	$out = preg_replace("/\n<a href=\"http:\/\/(.+?)\">(.+?)<\/a>\s+-\s*(.+?)(\n|\r|$)/","<a href=\"http://$1\">$3</a>$4",$out);
	$out = nl2br($out);
	print "<div id='text'>$out</div>";
?>

<form action="">
<input type="hidden" id="content-id" name="content-id" value="<?=$content_id?>" />
</form>

<br />
<?php if($_SESSION['admin']) { ?>
<a href="#" id="save-content">Save</a>
<a href="?id=<?=$content_id?>&amp;action=form" id="show-edit">Edit</a> |
<?php } ?>
<a href="index.php">List All</a><br />

<?php

////////////////////////////////////// Default List View /////////////////////////
} else { // No Content specifed - show all posts...
	$all_pages = $sql->getAll("SELECT id,name FROM Data WHERE status='1'");
	if($all_pages) {
		print "<ul>";
		foreach($all_pages as $page_details) {
			print "<li><a href='?id=$page_details[id]'>$page_details[name]</a></li>";
		}
		print "</ul>";
	}
	
	if($_SESSION['admin']) print '<a href="?action=form">New Page</a>';
}

$template->addResource('index.js', 'js', true);
printEnd();
