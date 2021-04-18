<h1>Posts</h1>

<ul id="site-index">
<?php foreach($all_sites as $site) { ?>
<li><a href="posts.php?feed[]=<?=$site['id']?>" class="feed-<?=$site['id']?>"><?=$site['name']?></a></li>
<?php } ?>
</ul><br />
<form action="" id="search-form">
<label for="search">Filter</label> <input type="text" id="search" name="search" />
</form>

<table id="all-posts">
<tr><th>#</th><th>Title</th><th>Feed</th><th>Date</th></tr>
<?php
$count = 0;
foreach($all_posts as $post) {
	$count++;
	$odd_even = ($count%2) ? 'odd' : 'even';
?>
<tr class='row-<?=$odd_even?>'><td><?=$count?></td>
<td><a href='<?=$post['url']?>' class="post-link"><?=$post['title']?></a></td>
<td><a href="?feed[]=<?=$post['feed_id']?>" class="feed-<?=$post['feed_id']?>"><?=$post['feed']?></a></td>
<td><?=$post['date']?></td></tr>
<?php } ?>
</table>

<a href="fetch/feeds.php">Fetch New Posts</a>