<?php
include('../common.php');
 
if(i($_GET, 'content') == 'twitter_status') print load('http://twitter.com/statuses/user_timeline/binnyva.json?count=1');
