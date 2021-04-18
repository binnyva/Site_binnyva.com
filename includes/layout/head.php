<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$title?></title>
<link rel="stylesheet" href="<?= joinPath($config['site_url'], '/css/style.css') ?>" type="text/css" media="all" />
<!--[if IE]>
<link rel="stylesheet" href="<?= joinPath($config['site_url'], '/css/style_ie.css') ?>" type="text/css" media="all" />
<![endif]-->
<?=implode("\n", $template->css_includes);?>
