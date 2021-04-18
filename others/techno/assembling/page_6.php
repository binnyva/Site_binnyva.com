<?php
include('../../../common.php');

printTop('Assembling :: Page 6');
?>
<table width=99% border="0" cellspacing="0" cellpadding="0" align=center>
<tr><td colspan="3">
<div align=center><strong>Assembling the PC</strong></div>
</td></tr><tr><td width="8%" height="3"> 
<div align=left><a href="page_5.php">Prev</a></div>
</td><td width="86%" height="3"> 
<div align=center>Page 6</div>
</td><td width="6%" height="3"> 
<div align=right><a href="page_7.php">Next</a></div>
</td></tr><tr><td colspan="3">
 <hr align=center>
</td></tr></table>

<h4>Installing Hardisk</h4>
<p><table><tr><td class="td_text">
Ensure that the hard drive is set up to be the master drive on its IDE cable. Each IDE cable can support up to two IDE devices, such as hard-drives, CD-drives, Zip Drives, etc., but in order for this to work, one IDE device must be designated as a master device, and one must be designated as a slave device. You cannot have two master devices or two slave devices on a single cable. This must be later configured in the BIOS.
</td><td>
<img src="../../../images/assembling/hardisk_jumbers.jpg" alt="Back of Hardisk" />
</td></tr></table></p>

<p><table><tr><td class="td_text">
<img src="../../../images/assembling/fixing_hdd.jpg" width="174" height="202" alt="Fixing the Hardisk" />
</td><td>
Examine the top of your hard-drive. There should be a chart there depicting the necessary jumper settings to make the drive a master or slave device. Otherwise, the chart will be somewhere on the body of the drive. The set of jumpers will be on the back end of the drive. Ensure that they are set correctly to enable the drive as a master. You may need a set of tweezers to move the jumpers.<br />
Insert the hard drive into the 3.5" drive-tray and screw it in securely on both sides.
</td></tr></table></p>

<h4>Installing Optical Drive (DVD/CDROM)</h4>
<p><table><tr><td class="td_text">
Ensure that at least one full sized 5.25" bay is open in the case. Examine the jumper settings on the top of the drive, as you did with the hard-drive. Ensure that the drive is set to 'master'. If your case came with rails, screw them to the sides of the CD drive and insert it into the front of the case until it clicks into place. <br />
Otherwise, slide the drive into the front of the computer until the faceplate of the drive is flush with the front bezel of the case and the screw holes along the side of the drive line up with the case. Then, screw it in securely on both sides. Attach the power cable (same as the hard-drive power cable) to the drive. Attach your secondary IDE cable to the drive. Note that generally this should be a regular 40-wire IDE cable, not the 80-wire UDMA IDE cable that is used for the hard-drive. Some DVD drives will use the 80-wire cable, however.<br />
Set the jumper on the CD-ROM drive. Here you have a choice. You can either:

<ul>
    <li>Attach the CD-ROM to IDE connector 1 and make the CD-ROM a slave. In this case, you will set the jumper on the CD-ROM to "Slave" and attach the CD-ROM drive to the same IDE cable as the hard drive. Or, 
    <li>Attach the CD-ROM to IDE connector 2 and make the CD-ROM a master. In this case you will set the jumper on the CD-ROM to "Master" and attach the CD-ROM drive with a separate cable to IDE slot 2. In order to use this method, you will need a second IDE cable. 
</ul>
Connect the Sound Cable of the CDROM to the Sound Card so that the Audio CDs can work properly.
</td><td>
<img src="../../../images/assembling/inserting_cdrom.jpg" width="142" height="117" alt="Insert the CDROM into Case" />
</td></tr></table></p>

<?php printEnd(); ?>