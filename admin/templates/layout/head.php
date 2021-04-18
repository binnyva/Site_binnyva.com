<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<title><?=$title?></title>

<link href="<?=joinPath($config['site_url'],'admin/css/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?=joinPath($config['site_url'],'admin/css/admin.css')?>" rel="stylesheet" type="text/css" />
<?=implode("\n", $template->css_includes);?>

<script src="<?=joinPath($config['site_url'],'admin/js/common.js')?>" type="text/javascript"></script>