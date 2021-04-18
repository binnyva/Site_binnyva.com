<h2>Aggregator</h2>

<ul>
<?php foreach($all_sites as $site) { ?>
<li><a class="feed-<?=$site['id']?>" href="<?=$site['url']?>"><?=$site['name']?></a> - <?=$site['description']?></li>
<?php } ?>
</ul>

<?php
$calendar->display(); 
?>
<div id="summary"></div>