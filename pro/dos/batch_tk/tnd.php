<?php
include('../../../common.php');

printTop('Tnd V 3.00.A - Time \'n Date');
?>

<a name="top"> </a>
<h1 class="heading">Tnd V 3.00.A - Time 'n Date</h1>

<p><a class="heads" name="desc">Description</a><br /><br />
This program will displays the time and date in the format specified at command line. Made as a replacement for the 'time' and 'date' commands of MS DOS. I mixed the two commands together and added a lot of features to it. DOS users will find this very useful if they want to display time in Batch file.</p>
<br />

<p><a class="heads" name="get">Getting A Copy</a><br /><br />
Bnd can be downloaded <strong>FREE</strong> of charge from my site. Just follow the instructions given in the readme file to install it. The instructions are given below.<br />
<a href="tnd.zip">Download Tnd 3.00.A</a> &nbsp; &nbsp; 15.9 KB</p>

<p><a class="heads" name="install">Intalling Tnd</a><br /><br />
Just copy the file "TND.EXE" to the folder "C:\WINDOWS\COMMAND". Or just double click the "Install" script that is provided with it. This will automatically copy the TND.EXE file to "C:\WINDOWS\COMMAND" folder. Why? Whenever you run a command from DOS prompt, it searches in this directory to find if any program with that command is found. If found, that program will be executed. So when you type "TND" in the dos prompt(sans quotes), the file TND.EXE will be executed.</p>
<br />

<p><a class="heads" name="uninstall">Uninstalling Tnd</a><br /><br />
All you have to do to uninstall Tnd is delete the "TND.EXE" file from the "C:\WINDOWS\COMMAND" folder.</p>
<br />

<p><a class="heads" name="source">Can I get the source of Tnd?</a><br /><br />
Tnd is distruibuted as an open source program. If you want the source, send a mail to me at <?=$email_html?>. I compiled this program with Borland C++ compiler - I don't think it will have any problems if compiled in other compilers. If you want to make any change to the software feel free to do so. But please give credit where credit is due and keep my name or my site in it. If you make some major changes to this software, I will add that change to Tnd and include your name in the credits.</p>
<br />

<p><a class="heads" name="clo">Command Line Options</a><br /><br />
<table>
<tr><td>-t</td><td>Shows Time in "Hours:Min AM/PM" Format</td></tr>
<tr><td>-d</td><td>Shows Date in "D-M-Y" Format</td></tr>
<tr><td>-dm</td><td>Shows Date in "D-M" Format</td></tr>
<tr><td>-md</td><td>Shows Date in "M-D" Format</td></tr>
<tr><td>-l</td><td>Display day in Long Format - 1st January 2000.</td></tr>
<tr><td>-0</td><td>Add 0 to the number. 1-9-2004 becomes 01-09-2004</td></tr>
<tr><td>-?</td><td>Displays Help screen</td></tr>
<tr><td>-x</td><td>Allows eXtended formatting of date and time.</td></tr>
<tr><td> &nbsp; </td><td>After the '-x' leave a space and type the following</td></tr>
<tr><td> &nbsp; </td><td>

<table><tr>
<tr><td width="30">/d</td><td>For Day</td> <td width="30">/D</td><td>For zeros in day(1 becomes 01)</td></tr>
<tr><td>/m</td><td>For Month</td> <td>/M</td><td>For month with zeros</td></tr>
<tr><td>/w</td><td>For small name of Weekday (Mon,Tue, etc.)</td>
	<td>/W</td><td>For name of Weekday (Monday,Tuesday, etc.)</td></tr>
<tr><td>/n</td><td>For small Name of the month (Jan, Feb, etc.)</td>
	<td>/N</td><td>For Name of the month (January, February, etc.)</td></tr>
<tr><td>/y</td><td>For Year</td><td>/Y</td><td>For 4 digit year(2004)</td></tr>
<tr><td>/h</td><td>For Hour</td><td>/H</td><td>For hours with zeros</td></tr>
<tr><td>/2</td><td>For hours in 24 hour clock</td></tr>
<tr><td>/e</td><td>For minutE</td><td>/E</td><td>For minutEs with zeros</td></tr>
<tr><td>/s</td><td>For Seconds</td><td>/S</td><td>For Seconds with zeros</td></tr>
<tr><td>/p</td><td>For the Postfix. It is the 2 end chars in 1st,2nd etc-st,nd,rd,th</td></tr>
<tr><td>/a</td><td>For AM/PM</td></tr>
<tr><td>/-</td><td>For putting the character '-'</td></tr>
<tr><td>/_</td><td>For putting a space ' '</td></tr>
<tr><td>/'</td><td>For putting a quotes character (")</td></tr>
</tr></table>

</td></tr></table>
<br />
<strong>Note</strong> : The inline formatting option use '/' and not '\'.</p>
<br />

<p><a class="heads" name="examples">Examples</a><br /><br />
I am assuming that you use windows. If this should be done in dos some changes should be made.<br />
1) <u>To make a folder with today's date</u>. Make a batch file with the below content and run it.<br />
<pre>
@echo off
becho mkdir > c:\windows\temp\tmp$~.bat
becho " \"">> c:\windows\temp\tmp$~.bat
tnd -x "/M - /D\'" >> c:\windows\temp\tmp$~.bat
echo. >> c:\windows\temp\tmp$~.bat
call c:\windows\temp\tmp$~.bat
</pre>
<br />
2) <u>Get today's date into a file.</u> Run this command and replace "filename.ext" with the name of the file.<br />
<pre>tnd -l >> filename.ext</pre>

3) <u>Get the time into a file.</u> Run this command and replace "filename.ext" with the name of the file.<br />
<pre>tnd -t >> filename.ext</pre>
</p>

<p><a class="heads" name="history">History</a><br /><br />
<strong>V 1.00.A</strong><br />
Very basic build. Internal release only.<br />
<br />
<strong>V 2.00.A</strong><br />
First Major Public Release as the part of <a href="index.php">BatchTk</a>.<br />
<br />
<strong>V 3.00.A</strong><br />
<ul>
	<li>BugFix : Corrected the non appearing 0 problem.
	<li>Added the extending char '%'. '/' and '\' are still supported. DOS users will have problem with this option as '%' is a special charector in DOS.
	<li>Added an option to include Postfix - st,nd,rd,th to date.
	<li>Added Seconds support.
	<li>Released as seperate program as well as a part of BatchTk
</ul>
</p><br />

<h2>Feedback</h2>

<p><a class="heads" name="latest">How do I get the latest version of Tnd?</a><br /><br />
You can visit my website at <a href="http://www.geocities.com/binnyva">http://www.geocities.com/binnyva/binny/pro/dos/batch_tk/tnd.html</a> for more information and updates of Tnd. As soon as I make a major public release of Tnd, it will be featured there.</p>
<br />

<p><a class="heads" name="contact">How do I contact the author of Tnd?</a><br /><br />
You can contact me by sending a email to <?=$email_html?>. You can also visit my website at <a href="http://www.geocities.com/binnyva">http://www.geocities.com/binnyva</a> for more information and updates of Tnd.</p>
<br />

<p><a class="heads" name="bug">What if I find a bug?</a><br /><br />
If you find a bug, please send <?=$email_html?> to the author. Describe the bug in as much detail as possible, and I'll do what I can to help resolve the problem.</p>
<br />


<?php printEnd(); ?>