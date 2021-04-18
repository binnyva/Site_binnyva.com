<?php
include('../../../common.php');

printTop('Batch ToolKit');
?>


<h1>Batch ToolKit V 1.00.A</h1>
<a name="top"> </a>
<a href="batch_tk.zip">Download Batch ToolKit V 1.00.A</a> 56.5KB.
<br /><br />
<table width="100%"><tr><td width="20%" valign="top">
<a href="#becho"><strong>Becho</strong></a>
</td><td width="20%" valign="top">
<a href="#message"><strong>Message</strong></a>
</td><td width="20%" valign="top">
<a href="#tnd"><strong>Tnd - Time 'n Date</strong></a>
</td><td width="20%" valign="top">
<a href="#select"><strong>Select</strong></a>
</td><td width="20%" valign="top">
<a href="#getline"><strong>Getline</strong></a>
</td></tr></table>

<br /><br />
<a name="becho"></a>
<h3 class="toolname">Becho V 1.00.A</h3>

<p>Becho is a replacement for the `echo` command of DOS. Becho is a very powerful program 
and with proper use, one can work wonders with it.</p>

<strong>Command Line Options</strong>
<table>
<tr><td width="150">-Fxxxxxxx</td><td>Font Color. Replace &lt;xxxxxxx&gt; with color name. It can be any colour in the <a href="#colours">colour chart</a>.</td></tr>
<tr><td>-Bxxxxxxx</td><td>Background Colour. Replace &lt;xxxxxxx&gt; with color name. It can be any background colour in the <a href="#colours">colour chart</a>.</td></tr>
<tr><td>-blink</td><td>Enables Blinking mode.</td></tr>
<tr><td valign="top">-X</td>
<td>Enables eXtended mode. In this mode you can give diffrent
colours for the same line. An example is given below.
<blockquote>
becho -x -f4 http:// -b7 -f0 \bwww. -b2 -f15 "\bbgeocities.com/" -b3 -f13 \bbinnyva<br />
<em>Result</em> : <br />
<table class="dos">
<tr><td class="dos_text">C:\DOS>becho -x -f4 http:// -b7 -f0 \bwww. -b2 -f15 "\bbgeocities.com/" -b0 -f13 \bbinnyva</td></tr>
<tr><td>
<table class="dos" cellspacing="0" cellpadding="0">
<tr><td> <font class="dos" color="#A80000"> http://</font></td>
<td><span style="background-color:#A8A8A8;">www.</span></td>
<td><span class="dos" style="background-color:#00A800;color:#FFFFFF">geocites.com/</span></td>
<td><font class="dos" color="#FF54FF">binnyva</font></td></tr>
</table>
</td></tr>
<tr><td class="dos_text">C:\DOS>_</td></tr>
</tr></table>
</blockquote>
-noblink shuts off the blinking mode after it is enabled.<br />
<em>Note</em> : The whole command must be given in one line.</td>
</tr>
</table>
<br /><br />
<strong>Inline Formatting</strong>

<p>You can use the codes given below in the strings that you give to get untypeable characters like New Line, Audible Bell etc.</p>
<table border="1">
<tr><td><strong>Code</strong></td><td><strong>Does this</strong></td></tr>
<tr><td>\a</td><td>Sounds a bell</td></tr>
<tr><td>\b</td><td>Backspace</td></tr>
<tr><td>\n</td><td>New line</td></tr>
<tr><td>\t</td><td>Tab character</td></tr>
<tr><td>\\</td><td>Prints a slash(\)</td></tr>
</table>

<br /><hr /><br />
<a name="tnd"></a>
<h3 class="toolname">tnd - Time 'n Date &nbsp; V 2.00.A</h3>

<a href="tnd.php">Tnd Page</a><br />

<p>This command displays the time and date in the format specified at command line.</p>

<strong>Command Line Options</strong><br />
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
<tr><td>/a</td><td>For AM/PM</td></tr>
<tr><td>/-</td><td>For putting the character '-'</td></tr>
<tr><td>/_</td><td>For putting a space ' '</td></tr>
<tr><td>/'</td><td>For putting a quotes character (")</td></tr>
</tr></table>

</td></tr></table>
<br />
<strong>Note</strong> : The inline formatting option use '/' and not '\'.<br /><br />

<strong>Example</strong><br />
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

<br /><hr /><br />
<a name="message"></a>
<h3 class="toolname">Message 1.00.A</h3>

<strong>Usage : Message [OPTIONS] "&lt;Message Text&gt;"</strong><br />

<p>Shows a message box with the text specified as the argument. This message box can be in the from of an alert - just the OK button or as a conformation box - two buttons will be shown - OK and Cancel(can be changed). Any one button can be chosen using the arrow keys and enter. If OK is selected, the errorlevel will be set to 1 and if Cancel is selected, the error level will be 0.
The text colour and background colour of all elements can be set from the command line.
All the command line options are described below.</p>

<em>Example: message -bg blue -t BLACK -hs "Hello World"</em><br />
<br />

<strong>Command Line Options</strong>
<table>
<tr><td>--hide_shadow OR -hs</td><td>- Disables the drop shadow effect.</td></tr>
<tr><td>--yesno OR -yn</td><td>- The Button text will be 'Yes' and 'No'.</td></tr>
<tr><td>--okcancel OR -oc</td><td>- The Button text will be 'OK' and 'Cancel'.</td></tr>
<tr><td>--delimiter &lt;#&gt; OR -d &lt;#&gt;</td><td>- Sets the delimiter at the ends of the button.<br />&lt;#&gt; can be any of the following values.</td></tr>
<tr><td>&nbsp;</td>
<td><table>
<tr><td width="40"><strong>Code</strong></td><td><strong>Button Text</strong></td></tr>
<tr><td>0</td><td>Text (No Delimiters)</td></tr>
<tr><td>1</td><td>&lt; Text &gt;</td></tr>
<tr><td>2</td><td>- Text -</td></tr>
<tr><td>3</td><td>[ Text ]</td></tr>
<tr><td>4</td><td>.: Text :.</td></tr>
</table></td>
</tr>
<tr><td>-? OR --help</td><td>Shows help screen (this screen)</td></tr>
<tr><td>-? break</td><td>Shows help page by page.</td></tr>
</table>
<br />
<em>Example : message -yn --delimiter 4 "Hello World"</em><br />
<br />

<strong>Colour Options</strong><br />
The all the colours can be set from the command line. The format is given below.<br />		
<em>Note</em> : MB - Message Box
<table>
<tr><td><strong>Command Line</strong></td><td><strong>Function</strong></td></tr>
<tr><td>--border_color &lt;colour&gt; OR -bc &lt;colour&gt;</td><td>The colour of the border of the MB.</td></tr>
<tr><td>--background &lt;colour&gt; OR -bg &lt;colour&gt;</td><td>The background colour MB.</td></tr>
<tr><td>--text_color &lt;colour&gt; OR -tc &lt;colour&gt;</td><td>The text colour in MB.</td></tr>
<tr><td>--button_text_color &lt;colour&gt; OR -btc &lt;colour&gt;</td><td>The text colour of the selected button.</td></tr>
<tr><td>--button_background &lt;colour&gt; OR -bbg &lt;colour&gt;</td><td>The background colour of the selected button.</td></tr>
<tr><td>--disabled_text_color &lt;colour&gt; OR -dtc &lt;colour&gt;</td><td>The text colour of the button that is NOT selected.</td></tr>
<tr><td>--disabled_background &lt;colour&gt; OR -dbg &lt;colour&gt;</td><td>The background colour of the	button that is NOT selected.</td></tr>
<tr><td>--shadow_color &lt;colour&gt; OR -sc &lt;colour&gt;</td><td>The colour of the Shadow.</td></tr>
</table>

<p>&lt;colour&gt; can be any color specified in the <a href="#colours">Colour Chart</a>. You can use
the code instead of the colour name. Please be careful to give 
only the first 8 colors in the chart as the background color.</p>

<br /><hr /><br />
<a name="select"></a>
<h3 class="toolname">Select 1.00.A</h3>

<strong>Usage : Select [OPTIONS] &lt;Menu Item&gt; &lt;Menu Item&gt; &lt;Menu Item&gt; ...</strong>

<p>Select will show a interactive arrow-keys driven menu from which the user can make a selection. The number of the selection will be set as the errorlevel. The is useful in batch scripts. 
The text colour and background colour can be set from the command line.<br />
<em>Note</em> : If a item is more than one word enclose it in quotes. Like "Menu Item".</p>

<strong>Command Line Options</strong>
<table>
<tr><td>--hide_info OR -hi</td><td>Hides the "Currently Selected" text.</td></tr>
<tr><td>--show_numbers OR -sn</td><td>Shows numbers for each element in the menu.</td></tr>
<tr><td>--no_fill OR -nf</td><td>This will cause the background to be the same width as the text.</td></tr>
<tr><td>-? OR --help</td><td>Show help screen (this screen)</td></tr>
<tr><td>-? break</td><td>Shows help page by page.</td></tr>
</table>
<br /><br />
<strong>Colour Options</strong><br />
The text colour and background colour can be set from the command line.
The format is given below.<br />
<table>
<tr><td><strong>Command Line</strong></td><td><strong>Function</strong></td></tr>
<tr><td>--back &lt;colour&gt; OR -b &lt;colour&gt;</td><td>Sets the default background colour.</td></tr>
<tr><td>--text &lt;colour&gt; OR -t &lt;colour&gt;</td><td>Sets the default text colour.</td></tr>
<tr><td>--select_back &lt;colour&gt; OR -s &lt;colour&gt;</td><td>Sets the background colour for selected items.</td></tr>
<tr><td>--select_text &lt;colour&gt; OR -t &lt;colour&gt;</td><td>Sets the colour of the selected item.</td></tr>
</table>

<p>&lt;colour&gt; can be any color specified in the <a href="#colours">Colour chart</a>. You can use
the code instead of the colour name. Please be careful to give 
only the first 8 colors in the chart as the background colour.</p>

<strong>Example:</strong><br />
<em>select "Item 1" "Item 2" "Item 3" -b LIGHTGRAY -t BLACK -sb LIGHTGREEN -st RED</em>
<br />

<br /><hr /><br />
<a name="getline"></a>
<h3 class="toolname">Getline 1.00.A</h3>

<strong>Usage : Getline &lt;FileName&gt; [OPTIONS] &lt;StartLineNumber&gt; [ - ] [&lt;EndLineNumber&gt;]</strong>

<p>This command will show the contents of a file from &lt;StartLineNumber&gt; to
&lt;EndLineNumber&gt; which can be specified at command line. If &lt;EndLineNumber&gt; 
is omitted, only line number &lt;StartLineNumber&gt; is is shown. If &lt;EndLineNumber&gt; 
is end or 0 or greater than the last line number, everything from &lt;StartLineNumber&gt; 
to end of file is shown.</p>

<em>Example : getline autoexec.bat 2 - end</em><br /><br />

<strong>Command Line Options</strong><br />
<table>
<tr><td>-v</td><td>Verbose Mode</td></tr>
<tr><td>-noerror</td><td>Will not display any error.</td></tr>
<tr><td>-? OR -h</td><td>Display the help screen.</td></tr>
</table>

<br /><hr /><br />

<a name="colours"></a>
<h3 class="toolname">Colour Chart</h3>
<table>
<tr><td width="120"><strong>Colour Name</strong></td><td width="50"><strong>Code</strong></td>
<td width="100"><strong>Background</strong></td><td width="100"><strong>Example</strong></td></tr>
<tr><td>BLACK</td><td>0</td><td>Yes</td><td bgcolor="#0000000"><span class="dos_text">Example</span></td></tr>
<tr><td>BLUE</td><td>1</td><td>Yes</td><td bgcolor="#0000A8"><span class="dos_text">Example</span></td></tr>
<tr><td>GREEN</td><td>2</td><td>Yes</td><td bgcolor="#00A800"><span class="dos_text">Example</span></td></tr>
<tr><td>CYAN</td><td>3</td><td>Yes</td><td bgcolor="#00A8A8"><span class="dos_text">Example</span></td></tr>
<tr><td>RED</td><td>4</td><td>Yes</td><td bgcolor="#A80000"><span class="dos_text">Example</span></td></tr>
<tr><td>MAGENTA</td><td>5</td><td>Yes</td><td bgcolor="#A800A8"><span class="dos_text">Example</span></td></tr>
<tr><td>BROWN</td><td>6</td><td>Yes</td><td bgcolor="#A85400"><span class="dos_text">Example</span></td></tr>
<tr><td>LIGHTGRAY</td><td>7</td><td>Yes</td><td bgcolor="#585458"><span class="dos_text">Example</span></td></tr>
<tr><td>DARKGRAY</td><td>8</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:#585458;">Example</span></td></tr>
<tr><td>LIGHTBLUE</td><td>9</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:#5854FF;">Example</span></td></tr>
<tr><td>LIGHTGREEN</td><td>10</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:#58FC58;">Example</span></td></tr>
<tr><td>LIGHTCYAN</td><td>11</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:#58FCFF;">Example</span></td></tr>
<tr><td>LIGHTRED</td><td>12</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:#FF5458;">Example</span></td></tr>
<tr><td>LIGHTMAGENTA</td><td>13</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:#FF54FF;">Example</span></td></tr>
<tr><td>YELLOW</td><td>14</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:#FFFC58;">Example</span></td></tr>
<tr><td>WHITE</td><td>15</td><td>No</td><td bgcolor="#0000000"><span class="dos_txt" style="color:white;">Example</span></td></tr>
</table>
<br /><br /><br />


<?php printEnd(); ?>