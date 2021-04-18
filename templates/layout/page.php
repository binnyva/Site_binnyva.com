<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title><?php echo $title?></title>
<?php echo $GLOBALS['template']->content['head'] ?>

<link href="<?php echo $config['site_url']?>css/style.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link rel="stylesheet" href="<?php echo $config['site_url']?>css/style_ie.css" type="text/css" media="all" />
<![endif]-->
<?php echo $css_includes?>
</head>
<body>
<div id="header">
<h1 id="logo"><a href="<?php echo $config['site_url']?>"><?php echo $title?></a></h1>
</div>

<div id="contents">
<!-- Begin Content -->
<?php 
/////////////////////////////////// The Template file will appear here ////////////////////////////

include($GLOBALS['template']->template); 

/////////////////////////////////// The Template file will appear here ////////////////////////////
?>
<!-- End Content -->
</div>

<script src="<?php echo $config['site_url']?>js/library/jsl.js" type="text/javascript"></script>
<script src="<?php echo $config['site_url']?>js/application.js" type="text/javascript"></script>
<?php echo $js_includes?>
<?php if($online) { ?>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-101361-4";
urchinTracker();
</script>
<?php } ?>
</body>
</html>