<?php
include('../../../common.php');

printTop('Assembling :: Trouble Shooting');
?>

<table width=99% border="0" cellspacing="0" cellpadding="0" align=center>
<tr><td colspan="3">
<div align=center><strong>Assembling the PC</strong></div>
</td></tr><tr><td width="8%" height="3"> 
<div align=left><a href="page_9.php">Prev</a></div>
</td><td width="86%" height="3"> 
<div align=center>TroubleShooting</div>
</td><td width="6%" height="3"> 
<div align=right>Next</div>
</td></tr><tr><td colspan="3">
 <hr align=center>
</td></tr></table>

<h3>Troubleshooting</h3>
 
<p>The Troubleshooting section here is not intended as a comprehensive guide to troubleshooting computer systems, but rather as a quick checklist to point you in the right direction. </p>

<p><strong>If you hit the power button and nothing happened:</strong><br />
Is the power cord plugged in? Is it plugged in the other end too? Check the switch at the back of the case. Make sure that you connected the wire from the case power button to the right connector on the motherboard. Make sure the power connector to the motherboard is in correctly. Check the floppy power cable. Double-check all connections.<br />
If none of this makes a difference, next step is to unplug everything from the motherboard with the exception of the power cable, power button wire, video card, memory and processor. If it still will not power up, it's likely that you have one or more defective components. The most likely culprits are the motherboard or the case power supply.</p>

<p><strong>If the system turns on, but does not beep or begin to boot up:</strong><br />
First, double check all connections and try again. Otherwise, the best thing to do in this circumstance is to unplug everything from the motherboard with the exception of the power button wire, video card, memory and processor, then test it again.<p>
If the computer successfully starts at this point, power off and reconnect one component at a time until you find the problem. If you cannot get it to boot up successfully, it is likely that you have one or more defective parts. </p>

<p><strong>System turns on, beeps intermittently, does not boot up: </strong><br />
Check that your memory (RAM) chip is installed correctly. Remove it and re-install it if necessary. </p>

<p><strong>System turns on, gives a sequence of quick beeps, does not boot up: </strong><br />
Check that your video card is correctly seated in its AGP or PCI slot. The AGP slot especially can be unforgiving of a card that is a tiny bit out of position. <br />
There are a number of other error codes indicated by patterns of beeps from the motherboard speaker, but the two above are the most commonly encountered.</p>

<p>If you have got the system up and running, but are experiencing some problems installing an operating system, here are a couple of common issues:</p>

<p><strong>Your system freezes intermittently while installing the OS:</strong><br />
Could well be a heat issue, especially with AMD processors or older Intel ones. Check that the heat sink fan is spinning and that the heat sink itself is firmly mounted and parallel to the surface of the processor. Assuming you are using a stock heat sink from the manufacturer of the processor, it should be more than adequate to cool the system if properly applied.</p>

<p><strong>You are having problems fully installing the OS due to errors copying files and blue screens:</strong><br />
Errors while copying the setup files, especially with Windows 2000 or XP, are a common indicator of problems with your memory (RAM). It's possible it could also be a hard-drive problem, but if you are getting blue-screens also, especially any ones indicating that a 'page-fault' has occurred, it's time to pop the memory out and haul it back to the store to be tested. And don't leave it there for the night either. </p>

<?php showFeedbackForm('Computer Assembly'); ?>

<?php printEnd(); ?>