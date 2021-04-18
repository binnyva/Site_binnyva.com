<?php
include('../../../common.php');

printTop('BD V 2.00.A :: The Dir Replacement');
?>

<h1 class="heading">BD 2.00.A : The Dir Replacement</h1>
<br />
<a href="bd.zip">Download BD 2.00.A</a> &nbsp; &nbsp; 17.9 KB<br />
<br /><br />

<strong>Introduction</strong><br />
<a href="#what">What is BD?</a><br />
<a href="#why">Why was this program written?</a><br />
<br />
<strong>Comparisons</strong><br />
<a href="#how">How is BD better than DIR?</a><br />
<a href="#other">How is BD better than other DIR replacing programs?</a><br />
<br />
<strong>Getting a copy</strong><br />
<a href="#get">Enough reading! How do I get BD?</a><br />
<a href="#install">How do I install BD?</a><br />
<a href="#uninstall">How do I Uninstall BD?</a><br />
<a href="#source">Can I get the source of BD?</a><br />
<br />
<strong>Infomation</strong><br />
<a href="#tricks">Some cool tricks.</a><br />
<a href="#clo">Command Line Options</a><br />
<a href="#colours">Colour Settings</a><br />
<a href="#new">What's New?</a><br />
<br />
<strong>Feedback</strong><br />
<a href="#latest">How do I get the latest version of BD?</a><br />
<a href="#contact">How do I contact the author of BD?</a><br />
<a href="#bug">What if I find a bug?</a><br />

<br /><hr /><br />

<h2>Intoduction</h2>

<a class="heads" name="what">What is BD?</a><br />
BD is a `dir` replacement. What this program does is that it displays the contents of the specified folder in a colourful and more understandable way. BD displays files of different types in different colours, letting you see at a glance which files are executable, which are documents, directories etc.<br />

<blockquote><em>BD helps to cross the boundary between the starkness of DOS and the color of Windows and is a perfect utility for anyone who is experienced with Windows but wishes to start working in DOS.</em><br />
 &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp; <strong><a href="http://www.completelyfreesoftware.com/">Completly Free Softwares</a></strong></blockquote>

<br />
<a class="heads" name="why">Why was this program written?</a><br />
The most commenly used command in dos is the 'dir'. The limitations of this command promted me to create a "dir" of my own. The Result - Binny's DIR or BD.<br />
<br />

<h2>Comparisons</h2>

<a class="heads" name="how">How is BD better than DIR?</a><br />
To be absolutly frank, BD is not better than DIR. DIR is a very powerful command and can be used to do many things with the command line options it has. BD is not as powerful as that, but it is much more user friendly. It shows all the files colour coded according to its extensions. For example, a folder will be show in yellow colour while a executable file is shown in blue colour. This will make it easier to understand the display.<br />
<br />
<strong>The BD Command</strong>
<table class="dos" width="100%">
<tr><td class="dos_text">C:\DOS>bd<br />Directory listing of C:\DOS</td></tr>
<tr><td><table width="100%">
<tr><td class="dir">BINNY</td><td class="dir">UTILS</td><td class="dir">APPS</td>
<td class="dir">DOCUME~1</td><td class="dir">DRIVERS</td><td class="dir">BATCHS</td></tr>
<tr><td class="dir">WANTEDS</td><td class="dir">UNIX</td><td>
<font color="#ffffff">DOS.TXT</font></td><td><font color="#5854FF">DOS.BAT</font></td>
<td>&nbsp;</td><td>&nbsp;</td></tr>
</table></td>
<tr><td class="dos_text"><br />C:\DOS>_</td></tr>
</tr></table>
 <br />
90% of the time we use the DIR command we just want to know what is there in that directory. We don't want to acces any of the more complicated functions of the DIR command. BD was designed to do just that.<br />
<br />
Another advantage of BD is that it just display the needed infomation. DIR displays a lot more option which makes it more difficult to find what you need.<br />
<br />
<strong>DIR command</strong><br />
<table width="100%" class="dos"><tr><td class="dos_text">
<pre>

 Volume in drive C is WINDOWS    
 Volume Serial Number is 0E69-16EF
 Directory of C:\DOS

.              &lt;DIR&gt;        09-24-03  4:08p .
..             &lt;DIR&gt;        09-24-03  4:08p ..
BINNY          &lt;DIR&gt;        09-24-03  4:08p Binny
UTILS          &lt;DIR&gt;        09-24-03  4:08p Utils
APPS           &lt;DIR&gt;        09-24-03  4:08p Apps
DOS      TXT           626  09-24-03  5:14p dos.txt
DOCUME~1       &lt;DIR&gt;        09-24-03  4:09p Documentation
DRIVERS        &lt;DIR&gt;        09-24-03  4:09p Drivers
BATCHS         &lt;DIR&gt;        09-24-03  4:11p Batchs
DOS      BAT           837  04-05-04  1:26p DOS.BAT
WANTEDS        &lt;DIR&gt;        09-24-03 11:49p Wanteds
UNIX           &lt;DIR&gt;        01-20-04 12:52a Unix
BINNY    TXT             0  06-08-04  1:56a Binny.txt
         3 file(s)          1,463 bytes
        10 dir(s)        1,540.07 MB free
</pre></td></tr></table>
<br />
<a class="heads" name="other">How is BD better than other DIR replacing programs?</a><br />
There are many other DIR replacers. But a problem commen to all of them is that they try to be very visually appealing and display a lot of graphics. They are very good but these extra graphics will affect the speed with which the command is executed. If you want speed you will have to use BD.<br />
<br />

<h2>Getting a copy</h2>

<a class="heads" name="get">Enough reading! How do I get BD?</a><br />
BD can be downloaded <strong>FREE</strong> of charge from my site. Just follow the instructions given in the readme file to install it. The instructions are given below.<br />
<a href="bd.zip">Download BD 2.00.A</a> &nbsp; &nbsp; 17.9 KB<br />
<br />
<a class="heads" name="install">How do I intall BD?</a><br />
Just copy the file "BD.EXE" to the folder "C:\WINDOWS\COMMAND". Or just double click the "Install" script that is provided with it. This will automatically copy the BD.EXE file to "C:\WINDOWS\COMMAND" folder. Why? Whenever you run a command from DOS prompt, it searches in this directory to find if any program with that command is found. If found, that program will be executed. So when you type "BD" in the dos prompt(sans quotes), the file BD.EXE will be executed.<br />
<br />
<a class="heads" name="uninstall">How do I Uninstall BD?</a><br />
All you have to do to uninstall BD is delete the "BD.EXE" file from the "C:\WINDOWS\COMMAND" folder.<br />
<br />

<h2>Information</h2>

<a class="heads" name="tricks">Some cool tricks.</a><br />
If you rename the BD.EXE file in the "C:\WINDOWS\COMMAND" folder you can change the command name. For example, if you rename BD.EXE to LS.EXE, you will have to type "ls" in the DOS prompt to run the BD program. You can rename this to just "D.EXE" so that you have to type less. <br />
Another trick is available for UNIX users. Run BD with /ls option and you will get the display using UNIX's LS command's colouring scheme - Folders have blue colour, executable have green colour etc.<br />
BD can display small Icons for the files if run with /i option.<br />
<br />
<a class="heads" name="clo">Command Line Options</a><br />
Just run BD with /? option to see all the Command Line options.<br />
<table border="1">
<tr><td width="100">/f</td><td>Shows only files</td></tr>
<tr><td>/d</td><td>Shows only directories</td></tr>
<tr><td>/i</td><td>Shows icons</td></tr>
<tr><td>/h</td><td>Show hidden files</td></tr>
<tr><td>/s</td><td>Show system files</td></tr>
<tr><td>/nocolor</td><td>Shows content without colour</td></tr>
<tr><td>/noext</td><td>Don't display the file extensions</td></tr>
<tr><td>/v</td><td>Vertical Display</td></tr>
<tr><td>/l OR /ls</td><td>Shows linux 'ls' command's colours.</td></tr>
<tr><td>/? OR /help</td><td>Shows the help screen</td></tr>
</table>
<br />
The user can set the colour scheme for any file type. All this should be given as command line options ever time BD is executed. The command line options are shown below.
<a name="custom"></a>
<table border="1">
<tr><td><strong>File Type</strong></td><td><strong>Extension</strong></td><td><strong>Text Colour Setting</strong></td><td><strong>Background Setting</strong></td></tr>
<tr><td>Folder</td><td>-</td><td>/dir &lt;color&gt;</td><td>/dir_back &lt;color&gt;</td></tr>
<tr><td>Executables</td><td>exe,bat,com</td><td>/exe &lt;color&gt;</td><td>/exe_back &lt;color&gt;</td></tr>
<tr><td>Text Files</td><td>txt,doc</td><td>/txt &lt;color&gt;</td><td>/txt_back &lt;color&gt;</td></tr>
<tr><td>HTML Files</td><td>htm</td><td>/html &lt;color&gt;</td><td>/html_back &lt;color&gt;</td></tr>
<tr><td>Pictures</td><td>jpg,gif,bmp,tga,png</td><td>/pics &lt;color&gt;</td><td>/pics_back &lt;color&gt;</td></tr>
<tr><td>Music</td><td>mp3,mid,wav</td><td>/music &lt;color&gt;</td><td>/music_back &lt;color&gt;</td></tr>
<tr><td>Scripts</td><td>vbs,js,pl,cpp,c,jav,py,tcl,xml,mak,vb,php,h</td><td>/source &lt;color&gt;</td><td>/source_back &lt;color&gt;</td></tr>
<tr><td>Video Files</td><td>mov,asf,dat,avi,mpg,mpe</td><td>/video &lt;color&gt;</td><td>/video_back &lt;color&gt;</td></tr>
<tr><td>Compressed</td><td>zip,cab,tar</td><td>/zip &lt;color&gt;</td><td>/zip_back &lt;color&gt;</td></tr>
<tr><td>Others</td><td>*.*</td><td>/others &lt;color&gt;</td><td>/others_back &lt;color&gt;</td></tr>
</table><br />
<strong>Example</strong> : If you want to see all exe files in green colour and music files in white colour with gray background, then you should give the command -<br />
<code>bd /exe green /music white /music_back lightgray</code><br />
<br />
Now if you like those settings better than the default settings, you should make a batch file with the below content in it.<br />
<code>bd %1 %2 %3 %4 %5 %6 %7 %8 %9 /exe green /music white /music_back lightgray</code><br />
and save it to a file called(for example) "ls.bat" in C:\Windows\Command folder. Now every time to type 'ls' in command prompt, you will call BD with the specified command line options.

<br /><br />
<a class="heads" name="colours">Colour Settings</a><br />
You can use any of these colours to replace the '&lt;color&gt;' in the above <a href="#custom">list</a>. The colours are NOT case-sensitive so WHITE and whItE are the same. You can also give the colour code in the place of the colour. For example, '<code>bd /pics blue</code>' is same as '<code>bd /pics 1</code>'.<br /> One thing to remember is that you should  give only the first 8 colors in the chart as the background color. You can give any colour as the text colour.<br />
<br />
Another problem with this option is that you can give the same colour as background and as text colour. For eg. if you give "bd /zip red /zip_back red" all you see is a red strip. You will not be able to read the text in the background whose colour is same as the text colour.<br />
<br />
<table border="1">
<tr><td><strong>Colour Name</strong></td><td><strong>Colour Code</strong></td><td><strong>Use as Background</strong> </td></tr>
<tr><td>BLACK</td><td>0</td><td>Yes</td></tr>
<tr><td>BLUE</td><td>1</td><td>Yes</td></tr>
<tr><td>GREEN</td><td>2</td><td>Yes</td></tr>
<tr><td>CYAN</td><td>3</td><td>Yes</td></tr>
<tr><td>RED</td><td>4</td><td>Yes</td></tr>
<tr><td>MAGENTA</td><td>5</td><td>Yes</td></tr>
<tr><td>BROWN</td><td>6</td><td>Yes</td></tr>
<tr><td>LIGHTGRAY</td><td>7</td><td>Yes</td></tr>
<tr><td>DARKGRAY</td><td>8</td><td>No</td></tr>
<tr><td>LIGHTBLUE</td><td>9</td><td>No</td></tr>
<tr><td>LIGHTGREEN</td><td>10</td><td>No</td></tr>
<tr><td>LIGHTCYAN</td><td>11</td><td>No</td></tr>
<tr><td>LIGHTRED</td><td>12</td><td>No</td></tr>
<tr><td>LIGHTMAGENTA</td><td>13</td><td>No</td></tr>
<tr><td>YELLOW</td><td>14</td><td>No</td></tr>
<tr><td>WHITE</td><td>15</td><td>No</td></tr>
</table>
<br />

<br />
<a class="heads" name="source">Can I get the source of BD?</a><br />
BD is distruibuted as an open source program. You can get the source from the author's website <a href="http://www.geocities.com/binnyva">http://www.geocities.com/binnyva</a>. I compiled this program with Borland C++ compiler - I don't think it will have any problems if compiled in other compilers. If you want to make any change to the software feel free to do so. But please give credit where credit is due and keep my name in it. If you make some major changes to this software, I will add that change to BD and include your name in the credits.<br />
<br />
<br />

<a class="heads" name="new">Whats New?</a><br />
These are the changes in V 2.00.A
<ul>
	<li>Added support for diffrent attributes(System, Hidden and Read Only). It can be shown in a varity of background colours.
	<li>The colours of all file types can be configured using the command line.
	<li>Each filetype can have a background colour.
	<li>Gave option to exit program at every screen fill.
	<li>Giving a wild card as argument will not show the folders.
	<li>Lots of changes in the code.
	<li>Lowered the file size of bd.exe
</ul><br />

<h2>Feedback</h2>

<a class="heads" name="latest">How do I get the latest version of BD?</a><br />
You can visit my website at <a href="http://www.geocities.com/binnyva">http://www.geocities.com/binnyva</a> for more information and updates of BD. As soon as I make a major public release of BD, it will be featured there.<br />
<br />
<a class="heads" name="contact">How do I contact the author of BD?</a><br />
You can contact me by sending a email to <?=$email_html?>. You can also visit my website at <a href="http://www.geocities.com/binnyva">http://www.geocities.com/binnyva</a> for more information and updates of BD.<br />
<br />
<a class="heads" name="bug">What if I find a bug?</a><br />
If you find a bug, please send <?=$email_html?> to the author. Describe the bug in as much detail as possible, and I'll do what I can to help resolve the problem.<br />
<br /><br />
<a class="heads" name="awards">Awards</a><br />
<a href="http://www.completelyfreesoftware.com/"><img src="../../../images/awards/bd/cfs.gif" width="150" height="75" alt="CFS - 4/5" border="0" /></a> - 4/5.

<?php printEnd(); ?>