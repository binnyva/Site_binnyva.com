<?php
//Sort the stuff if it was requested
$sort = ""; 
$sort_query = "";
$search_query= "";
$additional = "";

global $sql;

if(isset($QUERY['sortasc']) and $QUERY['sortasc']) {
	$sort = " $QUERY[sortasc] ASC";
	$sort_query = "sortasc=$QUERY[sortasc]&amp;";
} elseif(isset($QUERY['sortdesc']) and $QUERY['sortdesc']) {
	$sort = " $QUERY[sortdesc] DESC";
	$sort_query = "sortdesc=$QUERY[sortdesc]&amp;";
}

//If user wants to search
if(isset($_REQUEST['search']) and $_REQUEST['search']) {
	$main_query = "SELECT * FROM ".$admin_page->db_table." WHERE ".$QUERY['search_in']." LIKE '%".$QUERY['search']."%'";
	$search_query = "search=$QUERY[search]&amp;search_in=$QUERY[search_in]&";
} else {
	//Get the pager into this page.
	$main_query = ($admin_page->main_query) ? $admin_page->main_query : "SELECT * FROM ".$admin_page->db_table;
}
	
$additional .= $sort_query . $search_query;
if($admin_page->extra_param) {
	$additional .= $admin_page->extra_param;
}

//If there is already a 'ORDER BY' clause in the query, insert the new order by clause into it.
$sort_pos = strpos($main_query,"ORDER BY ");
if($sort_pos and $sort)  {
	$query_start = substr($main_query,0,$sort_pos);
	$query_end   = substr($main_query,$sort_pos+9,strlen($main_query));
	if($query_end) $query_end = ", ".$query_end;

	$main_query =  $query_start . " ORDER BY " . $sort . $query_end;
} elseif($sort) {
	$main_query .= " ORDER BY " . $sort;
}

//If the user have set the global variable for $items_per_page, show that much,else resort to the default 25
$items_per_page = 25;

//This will use my SqlPager class. Make sure it is included in the common.php file.
$pager = new SqlPager($main_query,$items_per_page);
$pager->page_link = $admin_page->page;
$pager->link_template = '<a href="%%PAGE_LINK%%" class="page-%%CLASS%%"><img alt="%%TEXT%%" src="images/icons/arrows/%%CLASS%%.png" /></a>';
$page_handle = $pager->getSql();

?>


<div id="page-actions">
<?php 
	if($admin_page->is_addable) { 
		$extra_items = "";
		if(isset($_REQUEST['search_in']) and $_REQUEST['search_in']) {
			$extra_items = "&amp;search_in=" . $_REQUEST['search_in'] . "&amp;search=" . $_REQUEST['search'];
		}
?>
	<a href="<?php echo $admin_page->getLink('action=add_form' . $extra_items); ?>" id="add-new"><?php echo $admin_page->texts['add_new_link']; ?></a>
<?php } ?>
</div>
<h1 id="title"><?php echo $admin_page->title; ?></h1>

<?php
//Show Messages - if any
if(isset($QUERY['error']) and $QUERY['error']) {
	echo "<div class='error-message'>$QUERY[error]</div>";
}
elseif(isset($QUERY['success']) and $QUERY['success']) {
	echo "<div class='success-message'>$QUERY[success]</div>";
}
elseif(isset($QUERY['notification']) and $QUERY['notification']) {
	echo "<div class='notification-message'>$QUERY[notification]</div>";
}
print $admin_page->content['display_start_text'];
?>

<?php 
if($pager->total_items == 0) { //If there are no items in this table,
	print "<br />No Records Found...";
}
else {
?>


<div class="actions-multiple">
	<a href="#" onclick="submit('delete_record');">Delete Selected</a> | 
	<a href="#" onclick="submit('activate');">Activate Selected</a> | 
	<a href="#" onclick="submit('deactivate');">Deactivate Selected</a>
</div>

<div class="info-bar"><?php
	if($pager->total_pages > 1) {
		print $pager->getLink("first") . $pager->getLink("back");
		$pager->printGoToDropDown();
		print $pager->getLink("next") . $pager->getLink("last");
	}
?></div>

<table class="info-bar"><tr><td>
<strong><?php
print $pager->getStatus() . " " . $admin_page->title;
?></strong>
</td><td align="right">
<?php $pager->printItemsPerPageDropDown(); ?>
</td></tr>
<?php
//This will show the search form for this page.
if(isset($GLOBALS['search_in']) and $GLOBALS['search_in']) { ?>
<tr><td><?php
	if(isset($_REQUEST['search']) and $_REQUEST['search']) print '<a href="'.$admin_page->page.'">Show All</a>';
?></td><td align="right" nowrap>
<!-- Search Form -->
<form name="search-form" id="search-form" method="post" action="<?=$GLOBALS['current_file']?>">
Search for <input type="text" name="search" value="<?=isset($_REQUEST['search']) ? $_REQUEST['search'] : '' ?>" />
in <?php
	$search_fields = array();
	$item_names = $admin_page->names;
	for($i=0;$i<count($item_names);$i++) {
		if(in_array($item_names[$i],$GLOBALS['search_in'])) {
			$search_fields[$admin_page->fields[$i]] = str_replace('_','',$item_names[$i]);
		}
	}
	$GLOBALS['html']->buildDropDownArray($search_fields,"search_in",i($QUERY,'search_in'));
?>
<input type="submit" name="action" id="search" value="Find" />
</form>
</td></tr>
<?php } ?>
</table>

<form name="display-form" id='display-form' method="post" action="">
	<!-- Table that has all the data -->
	<table class="data-table">
		<tr class="header-row"><!-- Table Header -->
			<?php
			if($admin_page->show_count) print '<th class="header-data-count">#</th>';
			?>
			<th class="header-select"><input onclick="checkAll();" id="selection-toggle" type="checkbox" value="" name="selection-toggle" /></th>
			
			<?php
			$field_count = 0;
			foreach($admin_page->names as $name) {
				if($name && $name[0]!='_') { //Dont show data if the first char of the name is a '_' - it is a secret.
					print '<th class="header-data">';
					print $name;
					
					if($admin_page->is_sortable) {
						$items_per_page_query_part="";
						if(isset($_REQUEST['items_per_page']) and $_REQUEST['items_per_page']) {
							$items_per_page_query_part = '&amp;items_per_page='.$_REQUEST['items_per_page'];
						}
						//Links to Sort the data.
						print "<a href='".$admin_page->getLink($search_query."sortasc=".$admin_page->fields[$field_count]).$items_per_page_query_part."'><img src='images/up.png' alt='Sort Ascending' /></a>";
						print "<a href='".$admin_page->getLink($search_query."sortdesc=".$admin_page->fields[$field_count]).$items_per_page_query_part."'><img src='images/down.png' alt='Sort Descending' /></a>";
					}
					print "</th>";
				}
				$field_count++;
			}

			if( $admin_page->is_editable or $admin_page->is_deleteable) {
			?>
			<th class="header-data" colspan="2" id="action-header">Action</th>
			<?php } ?>
		</tr>

		<?php
		//The displayed number of items in this page.
		$item_count = $pager->items_per_page * ($pager->page-1); //If you want continues numbering - first page is 1-5, next is 6-10 etc.
		//$item_count = 0; //Non continues numbering - first page is 1-5, next page is also 1-5 etc.

		//Get all the Data in this page as associative array
		while($data_row = $sql->fetchAssoc($page_handle)) {
			$item_count++;
			$id = $data_row[$admin_page->fields[0]];
			
			$row_class = ($item_count%2) ? 'even' : 'odd';

			print '<tr class="item-row-'.$row_class.'">';

			if($admin_page->show_count) print '<td class="item-count">'.$item_count.'</td>';
			print '<td class="item-select"><input type="checkbox" class="select-row" id="select_row_'.$id.'" value="'.$id.'" name="select_row[]" /></td>';

			$fields = $admin_page->fields;
			$names  = $admin_page->names;

			for($i=0;$i<count($fields); $i++) {
				$field_name = $fields[$i];
				$value = '';
				
				if(isset($data_row[$field_name])) $value = stripslashes($data_row[$field_name]);

				if($names[$i] and $names[$i][0] != '_') { //Dont show data if the first char of the name is a '_' - it is a secret.
					$info = explode(';',$admin_page->info[$i]); //Get the information about this item

					print '<td class="item-data" nowrap="nowrap">';

					//If the item must be a link
					if(in_array('link',$info)) {
						$key = array_search('link',$info);
						
						
						$link = str_replace("%URL%","",i($info,$key+1));
						$link = str_replace("%ID%",$id,$link);
						if(strpos($link,"%GET%") >=0) {
							preg_match("/.*%GET%<(.+?)>.*/",$link,$thing_to_get);
							
							$item_to_get = '';
							if(isset($thing_to_get[1]) and isset($data_row[$thing_to_get[1]])) {
								$item_to_get = $data_row[$thing_to_get[1]];
							}
							$link = preg_replace("/%GET%<.+?>/",$item_to_get,$link);
						}
						if(!$link) $link = $value;
						print "<a href='$link'>";
					}
					if(in_array('format',$info)) {
						//Format the values before printing it.
						$value = format($value);
					}

					//// Custom Data Views
					//Use a function to make complicated displays possible - for an ID.
					if(in_array('displayFunction',$info)) {
						$key = array_search('displayFunction',$info);
						if(function_exists('displayFunction')) {
							print displayFunction($id);
						}

					//Use a function to make complicated displays possible - for values.
					} elseif(in_array('displayValueFunction',$info)) {
						$key = array_search('displayValueFunction',$info);
						if(function_exists('displayValueFunction')) {
							print displayValueFunction($value);
						}

					//Print something from a given list
					} elseif(in_array('list',$info)) {
						$key = array_search('list',$info);
						$lst = str_replace("%A%","",$info[$key+1]);
						print $GLOBALS[$lst][$value];
		
					//Readonly Content
					} elseif(in_array('readonly',$info) or in_array('show',$info)) {
						$key = array_search('readonly',$info);
						list($val) = sscanf($info[$key+1],"value=%s");
						$value = ($val) ? $val : $value ;
						print $value;

					//Time Only
					} elseif(in_array('timeonly',$info)) {
						$time_stamp = strtotime(date('Y-m-d') . " $value");
						$datetime = date($GLOBALS['time_format'],$time_stamp);
						$value = $datetime;
						print $value;
					
					//Date/Time
					} elseif(in_array('date',$info) or in_array('time',$info) or in_array('curdate',$info)) { 
						$time_stamp = strtotime($value);
						$datetime = date(str_replace('%','',$GLOBALS['date_format']),$time_stamp);
						$value = $datetime;
						print $value;

					//Textarea
					} elseif(in_array('textarea',$info)) { 
						$value = nl2br($value);
						print '<div class="textarea-value">' . $value . '</div>';

					//Show the status 
					} elseif($names[$i] == "Status") { 
						echo ($value == '0') ?
							'<img src="images/status/inactive.png" alt="Inactive" />' : '<img src="images/status/active.png" alt="Active" />';

					//Shows email
					} elseif(strpos(strtolower($names[$i]),"mail") and strpos($field_name,"mail")) { 
						print '<a href="mailto:'.$value.'">'.$value.'</a>';

					//Shows everything else.
					} else {
						print $value;
					}
					
					//If the item must be a link
					if(in_array('link',$info)) {
						print '</a>';
					}
					print '&nbsp;</td>';
				}
			}
			
			//The links that will edit and delete an item.
			$edit_item_link  = ($admin_page->is_editable)  ? "<td class='item-action-edit'><a class='link-edit' href='" .
				$pager->makeLink(array('id'=>$id,'action'=>'edit_form')). "'>".$admin_page->texts['edit_item']."</a></td>" : "";
			$delete_item_link= ($admin_page->is_deleteable)? "<td class=\"item-action-delete\"><a class=\"link-delete\" href='" .
				$pager->makeLink(array('select_row[]'=>$id,'action'=>'delete_record')) . "' onclick=\"return (confirm('Are you sure that you want to delete this ".$admin_page->texts['item_name']."?'))\">".$admin_page->texts['delete_item']."</a></td>" : "";
			
			//The normal admins must not be able to edit other editors
			$pos = strpos($admin_page->title,"Administrators");
			if(is_numeric($pos)) {
				if((($_SESSION['admin'] == $id) or ($_SESSION['admin'] == 1))) {
					print $edit_item_link;

					//The Superadmin must be un-deletable - He must have the id '1'.
					if($id != 1 && $_SESSION['admin']==1) { //Only the Super admin can delete.
						print $delete_item_link;
					} else {
						print '<td>&nbsp;</td>';
					}
				} else {
					print '<td>&nbsp;</td><td>&nbsp;</td>';
				}
			} else {
				print $edit_item_link;
				print $delete_item_link;
			}
			?>
		</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="action" id="action" value="" />
</form>

	<div class="info-bar"><?php
		if($pager->total_pages > 1) {
			print $pager->getLink("first") . $pager->getLink("back");
			$pager->printGoToDropDown();
			print $pager->getLink("next") . $pager->getLink("last");
		}
	?></div>
	
	<div class="actions-multiple">
		<a href="#" onclick="submit('delete_record');">Delete Selected</a> | 
		<a href="#" onclick="submit('activate');">Activate Selected</a> | 
		<a href="#" onclick="submit('deactivate');">Deactivate Selected</a>
	</div>

	<?php
	print $admin_page->content['display_end_text'];
}
