</div>

<script src="<?= joinPath($config['site_url'], '/js/library/jsl.js') ?>" type="text/javascript"></script>
<script src="<?= joinPath($config['site_url'], '/js/application.js') ?>" type="text/javascript"></script>
<?php 
print implode("\n", $template->js_includes);

if($GLOBALS['online']) { ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-101361-4");
pageTracker._trackPageview();
</script>
<?php } ?>
</body>
</html>