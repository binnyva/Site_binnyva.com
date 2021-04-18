<?php
include('../../../common.php');

printTop('Tips and Tricks');
?>


<h1 align="center">Lyrics Bank</h1>
<h2 align="center">Tips and Tricks</h2>

(I) <strong>You can change the looks of almost the entire collection of lyrics by modifing just one file.</strong>
Just open the <strong>default.css</strong> in the lyrics folder.
The default contents will be:
<br />
<br />
<font face="tahoma" size="1">
BODY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;(Defines the properties of the text in most of the files)<br />
	{<br />
	background-color: "#000000";   <br />
	font-family: Tahoma;<br />
	font-size: 10;<br />
	color: "#00FF00"<br />
	}<br />
<br />
A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;(Defines the properties of Hyperlinks)<br />
	{<br />
	COLOR: "#0013ee"; <br />
	FONT-FAMILY: verdana,arial; <br />
	TEXT-DECORATION: none<br />
	}<br />
<br />
A:hover <br />
	{<br />
	COLOR: "#ff8019"; <br />
	FONT-FAMILY: verdana,arial; <br />
	TEXT-DECORATION: none<br />
	}<br />
<br />
A:active <br />
	{<br />
	COLOR: "#ff8019"; <br />
	FONT-FAMILY: verdana,arial; <br />
	TEXT-DECORATION: none<br />
	} <br />
<br />
</font>
By changeing that file you will be able to change to appearace of most of the files.<br /><br /><br />
(II) <strong>You may have noticed that the loading is very slow for the lyrics databank. To speed up
the loading do the following:</strong><br />
1) Rename winampmb.htm to 1winampmb.htm(this file is in winamp folder[usually c:\Program files\winamp])<br />
2) Rename faster.htm to winampmb.htm<br />
3) Open the lyrics box from Winamp. You will find it faster.
<br /><br /><br />
(III) <strong>If you tried viewing the source code</strong> of the index file, you will find it hard to understand.
 That is because I applied source compression. To view it without source compression take other/index.html.

<br /><br /><br />

<?php printEnd(); ?>