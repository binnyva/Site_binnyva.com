<?php
include('../../../common.php');

printTop('Some Cool Tricks with Boot Booster');
?>


<a name="top"> </a>
<h1>Boot Booster Vs 2.01.A</h1>
<h3>Take the wait out of booting</h3>

<a href="quotes.php">More Quote Files</a><br /><br />

<table width="100%"><tr><td width="50%" valign="top">
<strong>Introduction</strong><br />
<a href="index.php#1">What is Boot Booster?</a><br />
<a href="index.php#2">What is it for?</a><br />
<a href="index.php#3">Why would I want to install Boot Booster?</a><br />
<a href="#3">How do I log Shutdown times with Boot Booster?</a><br />

</td><td width="50%" valign="top">
<strong>Getting a copy</strong><br />
<a href="index.php#4">How do I get a copy of Boot Booster?</a><br />
<a href="index.php#5">How do I intall Boot Booster?</a><br />
<a href="index.php#6">How do I Uninstall Boot Booster?</a><br />
<a href="index.php#7">Can I get the source of Boot Booster?</a><br /><br />

</td></tr>
<tr><td width="50%" valign="top">
<strong>Infomation</strong><br />
<a href="index.php#9">Command Line Options</a><br />
Some cool tricks.<br />
 &nbsp; &nbsp; &nbsp; <font size="-2">&raquo;</font> <a href="#1">Changeing Quote Files</a><br />
 &nbsp; &nbsp; &nbsp; <font size="-2">&raquo;</font> <a href="#2">A word about the "Quotes.txt" file.</a><br />
 &nbsp; &nbsp; &nbsp; <font size="-2">&raquo;</font> <a href="#3">A program called '1st Impression'</a><br />
 &nbsp; &nbsp; &nbsp; <font size="-2">&raquo;</font> <a href="#4">Logging Shutdowns and Session times.</a><br />
 &nbsp; &nbsp; &nbsp; <font size="-2">&raquo;</font> <a href="#5">How do I log the booting of Non-Windows OS like DOS and Linux?</a><br />

</td><td width="50%" valign="top">
<strong>Feedback</strong><br />
<a href="index.php#10">How do I get the latest version of Boot Booster?</a><br />
<a href="index.php#11">How do I contact the author of Boot Booster?</a><br />
<a href="index.php#12">What if I find a bug?</a><br />

</td></td></table>
<br /><br />

<strong>Some cool tricks.</strong><br />
<a href="#1">Changeing Quote Files</a><br />
<a href="#2">A word about the "Quotes.txt" file.</a><br />
<a href="#3">A program called '1st Impression'</a><br />
<a href="#4">Logging Shutdowns and Session times.</a><br />
<a href="#5">How do I log the booting of Non-Windows OS like DOS and Linux?</a><br />

<br /><hr /><br />

<a class="bookmarks" name="1">Changeing Quote Files</a><br />
If you are unsatisfied with the quotes that are given with the program or if you read them all, you can change the quotes file. I have given some samples with the installation. You can find them in the "Quotes Files" folder of Boot Booster(Usually "C:/Program Files/Boot Booster"). This is what you will have to do:<br />
Step 1 : Chose a quotes file from the above said folder.<br />
Step 2 : Copy it to C:\ root.<br />
Step 3 : Delete the quotes.txt file that is found in C:\ root and rename the copied folder to "quotes.txt"<br />
Step 4 : Run the "Booster.exe" file in C:\ root without any command line options. You can do this by double clicking the "Booster.exe" file in C:\ root or by taking Boot Booster from Start Menu -> Boot Booster.<br />
Step 5 : Enter the Quotes section by pressing the "Q" key.<br />
Step 6 : You will be asked the question "New quotes file found. Update?". Chose yes by pressing 'Y'.<br />
Step 7 : Exit by pressing 'ESC' twice.<br />
That is it. You have changed the quotes file. From now on you will see jokes from the new file.<br />
<a href="#top">Go To Top</a><br /><br />

<a class="bookmarks" name="2">A word about the "Quotes.txt" file.</a><br />
"Quotes.txt" file is just a text file with one line jokes. Each line has a one-liner. What my program does is display one line of the "Quotes.txt" file at a time. Knowing this, you can easily make a "Quotes.txt" file by yourself and set it as the quotes file for Boot Booster.<br />
<a href="#top">Go To Top</a><br /><br />

<a class="bookmarks" name="3">A program called '1st Impression'</a><br />
<a href="http://www.gromada.com/1stImpression.php">1st Impression</a> automatically replaces Windows startup and shut down logos each time your system restarts. There is a basic image collection already included with the package and more can be downloaded from various sites around the net. 1st Impression can display multi-line messages which are stored to user-editable plain-text files. One can configure this program to display a joke at startup time. So you will be reading two jokes every startup time. I don't know if you'll believe me, but I thought of this idea independently.<br />
<a href="#top">Go To Top</a><br /><br />

<a class="bookmarks" name="4">Logging Shutdowns and Session times.</a><br />
This is the feature that makes my software a powerful one. Boot Booster is capable of logging not only startup times, but also shutdown times, how much time the session lasted, chrashes etc. Now this is a little complicated, so I want you to pay attention.<br />
In the Boot Booster folder(Usually "C:/Program Files/Boot Booster"), there is a folder called "Shortcuts". In that folder there will be two batch files called "Restart.bat" and "Shutdown.bat". Copy these files, "Restart.bat" and "Shutdown.bat", to C: drive's root. Then put the two shortcuts called "Restart" and "Shutdown" where ever you want them. These shortcuts have a computer as its icon. I would suggest that the Start Menu would be a good place for them. If you double click on the "Shutdown" shortcut, the system will shutdown. If you double click on "Restart", computer will restart. From then on, you must always shutdown and restart by clicking on these shortcuts. If you shutdown by using the odinary way(Start Menu -> Shut Down -> Shut Down) the log files won't record it. The log fils will show a crash message in such cases. You can automate the whole process by double clicking the "Install.bat" batch file.<br />
There is one more thing that you should do. Run the "Booster.exe" file in C:\ root without any command line options. You can do this by double clicking the "Booster.exe" file in C:\ root or by taking Boot Booster from Start Menu -> Boot Booster -> Boot Booster. Then enter the Boot Recorder feature by pressing the 'B' Key. Press 'ENTER' to edit the default values. After pressing enter, type the file where the information should be stored(usually "Record.txt". Type it without quotes.). Then press 'Y' three times to enable all the loggings - Startup, shutdown and times. Exit by pressing 'ESC' twice.<br />
Now we are ready to roll. Whenever you want to shutdown, double click on the Shutdown shortcut. This will shutdown the computer. when you want to restart the computer, double click on the Restart shortcut. However if you use the Shutdown command from Start Menu, the Record.txt file(found in the C: root) will show a line "Session ended at : Unknown (Restart or Crash)". However if you find that you are always shuting down from the Start Menu -> Shut Down -> Shut Down by the force of habit, I can help you. In the shortcuts folder(Usually "C:/Program Files/Boot Booster/Shortcuts") there is a file called "Disable shutdown.reg". If you merge it by double clicking it, the Shut Down command will disappear from the start menu. So you will  be able to shutdown only from my shortcuts. If you want to enable the Start Menu's Shut down command double click the "Enable Shutdown.reg" file in the Shortcuts folder (Usually "C:/Program Files/Boot Booster/Shortcuts"). Please note that the effects will appear <strong>only after you restart</strong> the computer.<br /><br />

<strong>Note</strong> : Sometimes, when you have clicked the shutdown shortcut, you will see a error. Just click on the "Close" button and stop bothering about it. It don't cause any problems in my computer.<br />
<a href="#top">Go To Top</a><br /><br />

<a class="bookmarks" name="5">How do I log the booting of Non-Windows OS like DOS and Linux?</a><br />
Boot Booster currently support DOS and Linux other than windows. To log booting of DOS run the "Booter.exe" with command line option "-S -dos". I do this by creating a batch file, for example "sd.bat" and uses it in such a way that it is executed every time DOS is booted. This file will have this line :<br />
<code>C:\Booter.exe -S -dos</code><br />
To log the booting of linux, you will have to load linux by a program called LoadLin. In the batch file of LoadLin give these lines:<br />
<code>C:\Booter.exe -S -Linux</code><br /><br />
I do all this with the help of a software called XOSL(Extended Operating System Loader).<br />
<a href="#top">Go To Top</a><br />
<br /><br /><br />

<?php printEnd(); ?>