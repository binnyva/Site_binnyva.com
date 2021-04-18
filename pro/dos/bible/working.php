<?php
include('../../../common.php');

printTop('Bible Aid - Working');
?>


<h1 align="center">Bible Aid - Working</h1>
<a href="#working">Working</a><br />
<a href="#login">Login</a><br />
<a href="main_screen.php">Main Screen</a><br />
<a href="#modify">Modification Mode</a><br />
<a href="#status">Status</a><br />
<a href="#options">Options</a><br />
<a href="#settings">Settings</a><br />
<br /><br />
<hr width="70%">
<br /><br />
<a name="working"><h3>Working</h3></a>
<p align="justify">When ever you wish to update your reading progress, Login with your UserName And
Password. In the main screen navigate by pressing 'Space' or 'Backspace' and find the number of the
book you are reading. Press 'M' key and enter the book number. The book number is shown in a 
braket ie."()" next to the Book Name. When you enter the book number you will be taken to 
<a href="#modify">modification mode</a>. Enter how many chapters you have read.
<br /> For Example, you have read 30 chapters of Genesis. The
number of Genesis is 1. Press M and enter 1(You can enter the number by pressing the number and
pressing enter). It will show you the <a href="#modify">modification mode</a>. Enter 30 here.</p>
<hr width="70%">
<br /><br />
<a name="login"><h3>Login</h3></a>
<p align="justify">If there is no user(Single user mode), the login screen will not be shown and the user
will be taken directly to the main screen. But if there is one or more user, he/she will be 
asked to enter their user name and password(optional) before useing the software. Upto 10 user
can use this software together. They will use the login feature to load their file to the
main screen. The password is used for security - if the user do not wish to share
their informaition with other. But if the user don't want the password he/she can opt for 
no password option by typing "nil" in the user creation screen.</p>
<hr width="70%">
<a name="modify"><h3>Modification Mode</h3></a>
<p align="left">This mode is reached when the user enter the number of the book to be modified.
In this mode the user can change the number of chapters read by entering the new number.</p>
<hr width="70%">
<a name="status"><h3>Status</h3></a>
<p align="justify">This screen will show total number of chapters in the Bible, how many chapters are already 
read, how many chapters are to be read, current date, Target date, how many chapters must be
read to finish the Bible before the target date per day and per month. The last to numbers
will be shown as approximate and accurate(in brackets).<br />
To change the target date press the 'M' key in your keyboard and enter the date. When entering
the new date, Enter the day, Press 'ENTER', Enter month, Press 'ENTER', enter year and Press 'ENTER'.<br />
To create a certificate, press the 'C' key and a certificate with your information will be created
in the program folder(Default - 'C:\Program Files\Binny's Softwares\Bible Aid\') as a text file
with the user's User Name.</p>
<hr width="70%">
<a name="options"><h3>Options</h3></a>
<p align="left">Here the user can change almost all the colours in this program. To change a colour please
press its number and chose a colour for the shown list. 
<table border="1">
<tr>
       <td>Key &nbsp;</td>
       <td>&nbsp; Name Of Option &nbsp;</td>
       <td>&nbsp; Discription</td>
</tr>
<tr>
       <td>1</td>
       <td>Finished</td>
       <td>The main screen will use this colour the show the books you have finished.</td>
</tr>
<tr>
       <td>2</td>
       <td>Chapters Read</td>
       <td>The main screen will use this colour the show the books you are reading.</td>
</tr>
<tr>
       <td>3</td>
       <td>New Testment</td>
       <td>Shown at the top of the main screen.</td>
</tr>
<tr>
       <td>4</td>
       <td>Old Testment</td>
       <td>Shown at the top of the main screen.</td>
</tr>
<tr>
       <td>5</td>
       <td>Background</td>
       <td>The background colour used through out the program.(Not all colours can be used for this option)</td>
</tr>
<tr>
       <td>6</td>
       <td>Keys</td>
       <td>Shown at the bottom of the main screen</td>
</tr>
<tr>
       <td>7</td>
       <td><a href="#messbox">Message Boxes</a></td>
       <td>All the Message Boxes will use these colours</td>
</tr>
<tr>
       <td>8</td>
       <td>Default Colour</td>
       <td>The default colour used in the porgram</td>
</tr>
</table><br />
<a name="messbox" class="black"><strong>Message box</strong></a><br />
This option will control all the colours used in the message boxes throughout the program.<br />
<center><img src="box.jpg" alt="Message Box" border="0" /></center></p>

<hr width="70%">
<a name="settings"><h3>Settings</h3></a>
<p align="left">This screen is to control all the user information.
<table border="1">
<tr>
       <td>Key</td>
       <td>Name of Option</td>
       <td>Discription</td>
</tr>
<tr>
       <td>1</td>
       <td>Create New User</td>
       <td>Create a new user by entering a new User Name and a password.</td>
</tr>
<tr>
       <td>2</td>
       <td>Change your User Name</td>
       <td>Change the User Name Of the current user</td>
</tr>
<tr>
       <td>3</td>
       <td>Change your Password</td>
       <td>Change the Password Of the current user</td>
</tr>
<tr>
       <td>4</td>
       <td>View All the Users</td>
       <td>View the user details of every user execpt their passwords</td>
</tr>
<tr>
       <td>5</td>
       <td>Delete Any User</td>
       <td>Delete any user of this program. If the current user is deleted you will be asked to login again.</td>
</tr>
<tr>
       <td>6</td>
       <td>Change the User</td>
       <td>Brings up a login screen to change the current user</td>
</tr>
</table></p><br />
<hr width="70%">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p align="left">&nbsp;</p>
<p align="left">&nbsp;</p>

<br /><br /><br />

<?php printEnd(); ?>