<?php
include('../../../common.php');

printTop('Indexer V 1.00.D');
?>

<script>writer()</script>

<h1>Indexer V 1.00.D</h1>

<a href="screenshots.php">Screenshots</a><br />

<p><a class="heads" name="desc">Description</a><br />
Indexer makes an HTML index(list) of all selected files.
This is extremely useful for Web Designers, Web Developers or those with a large collection of
HTML Files. All you have to do is select all the files to be indexed and chose how the index should be made. Then select the file where the index should be written to and the program will do the rest. It will find the relative links to the specified files and write the index in specified format.</p>

<p><a class="heads" name="download">Download Indexer</a><br />
<a href="indexer.zip">Download Indexer - 72.3 KB</a><br />
This is a free software. You can give it to others.
</p>

<p><a class="heads" name="dependencies">Dependencies</a><br />
IMPORTANT:<br />
You need the Tcl/Tk compiler to run this program - it is a Tcl script and not an executable file. So you need the interpreter to run it. A free interpreter can be downloaded from <a href="http://www.tcl.tk/">http://www.tcl.tk/</a>. I have tested the software with ActiveTcl 8.4 on Windows 98. So far I have not tested it on any other platforms. If any one can do that for me, I would be extremely grateful.<br />
Indexer will need Iwidget 4.0 to run. Please make sure that it is available. It is available with the Tcl interpreter in the latest versions.</p>

<p><a class="heads" name="limitations">Limitations</a><br />
This will work in Windows only. Some minor adjustments can make it work in Linux, but I was too lazy to do it. Another big problem is that Internet Explorer is needed for seeing the preview. Other browsers are not supported. I plan to remove these limitations as soon as possible.
</p>

<p><a class="heads" name="installation">Installation</a><br />
Just unzip the downloaded file and copy ALL the files with its folder structure intact to any directory. Then run the "Indexer.tcl" file.</p>

<p><a class="heads" name="todo">To Do - Pending work</a><br />
<ul>
	<li>Make the program portable to other platforms like Linux, Unix, Mac etc.
	<li>Write the documentation. This file can't be called the documentation by a far shot.
	<li>Improve the code.
	<li>Optimize the code - the script is way too slow.
	<li>Some more "To Do"s are specified at the end of the script.
</ul>

Any help regarding any of the above work is highly appreciated. If interested, contact me at <?=$email_html?>.
</p>


Binny V A,<br />
<?=$email_html?>
<br /><br /><br />
<script>writer()</script>

<?php printEnd(); ?>