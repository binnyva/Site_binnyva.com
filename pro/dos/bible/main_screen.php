<?php
include('../../../common.php');

printTop('Bible Aid - Main Screen');
?>


<h1 align="center">Bible Aid - Main Screen</h1>
The main screen comes after login if there is any user. You can go to the other screens
(Modification, Status etc.) from here. You can see all the books of the Bible by navigating in this
screen. A screen will show a maximum of 15 books and their status. The name of a book, its number
and the number of chapters that are read is shown for a book.<br /><br />
<strong>Colours</strong><br />
If the book is finished, its colour will be what the user diffined as 'Finished' in the option menu.<br />
If it is being currently read, its colour will be what the user diffined as 'Chapters Read' in the Options menu.<br /> 
If it is not read, its colour will be 'Default Colour'.<br /><br />
<strong>Keys</strong><br />
Press 'Space' to go to the next 15 books and Press 'Backspace' to go to the last 15 books.<br />
Press 'M' to go the <a href="working.php#modify">Modification</a> screen.<br />
Press 'S' to go the <a href="working.php#status">Status</a> screen.<br />
Press 'O' to go the <a href="working.php#options">Options</a> screen.<br />
Press 'C' to go the <a href="working.php#settings">Settings</a> screen.<br />
Press 'Esc' to Quit the program.<br /><br />
The Following is an image fo the main screen. Bring your mouse over any thing to view its name.
If it is clickable(the cursor turns to a hand), click it for more details.<br /><br />
<div id=overDiv style="Z-INDEX: 1000; VISIBILITY: hidden; POSITION: absolute"></div> 
<img src="first.gif" usemap="#first" border="0" />
<map NAME="First">
  <area SHAPE=RECT COORDS="476,49,540,64" onmouseout="return nd();" onmouseover="return drs('Version')">
  <area SHAPE=RECT COORDS="16,81,190,139" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="519,84,689,137" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="266,84,436,139" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="16,157,188,210" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="268,157,437,211" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="517,155,697,208" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="17,229,195,281" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="267,229,430,282" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="518,227,737,280" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="17,300,191,354" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="268,298,438,352" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="518,300,745,354" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="19,374,216,423" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="265,371,457,424" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="517,374,690,423" onmouseout="return nd();" onmouseover="return drs('Books')">
  <area SHAPE=RECT COORDS="588,67,728,83" onmouseout="return nd();" onmouseover="return drs('User Name')">
  <area SHAPE=RECT COORDS="588,49,768,63" onmouseout="return nd();" onmouseover="return drs('Current Users File')">
  <area SHAPE=RECT COORDS="287,66,416,81" onmouseout="return nd();" onmouseover="return drs('Name of Testment')">
  <area SHAPE=RECT COORDS="538,459,767,479" href="Working.php#Settings" onmouseout="return nd();" onmouseover="return drs('Change Settings Key - C')">
  <area SHAPE=RECT COORDS="10,461,350,478" onmouseout="return nd();" onmouseover="return drs('Navigation Keys - Backspace and Space')">
  <area SHAPE=RECT COORDS="11,479,309,496" href="Working.php#modify" onmouseout="return nd();" onmouseover="return drs('Modification Key - M')">
  <area SHAPE=RECT COORDS="382,462,497,478" href="Working.php#status" onmouseout="return nd();" onmouseover="return drs('Status Or Statestics Key - S')">
  <area SHAPE=RECT COORDS="382,480,507,496" href="Working.php#options" onmouseout="return nd();" onmouseover="return drs('Options Key - O')">
  <area SHAPE=RECT COORDS="539,480,657,495" onmouseout="return nd();" onmouseover="return drs('Exit Key - Esc')">
</map>
 
<br /><br /><br />

<?php printEnd(); ?>