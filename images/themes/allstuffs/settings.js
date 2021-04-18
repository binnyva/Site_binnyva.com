/*<script>*/
/***************************************************************************
Name : Dynamic FrameWork
Version : 2.00.A
Theme : Allstuffs (By Arun)
Author : Binny V Abraham
This script and System is made by the author for personal purposes only. If 
any person other than the author wants to use this system, he/she must have
the prior written permission from the author.
***************************************************************************/

var org_loc=document.location.toString();
var sl=0
var rel=""
var loc=""
var page="none"
if(!org_loc.indexOf("file:///D:/Documents/My%20Webs/Binny")) loc=org_loc.replace("file:///D:/Documents/My%20Webs/Binny","") //In System
else if(!org_loc.indexOf("file://localhost/d:/documents/my%20webs/binny")) loc=org_loc.replace("file://localhost/d:/documents/my%20webs/binny","") //For Ophra Browser
else if(!org_loc.indexOf("http://127.0.0.1")) loc=org_loc.replace("http://127.0.0.1","") //For a in system Server(Sambar)
else if(!org_loc.indexOf("file:///mnt/d/Documents/My%20Webs/Binny")) loc=org_loc.replace("file:///mnt/d/Documents/My%20Webs/Binny","") //For Linux
else if(!org_loc.indexOf("http://binnyva.tripod.com")) loc=org_loc.replace("http://binnyva.tripod.com","") //For Internet
else loc=org_loc
for(i=0;i<loc.length;i++) {
if(loc.charAt(i)=="/") {
if(sl) rel=rel+"../"
sl++;}
}

var sep="&nbsp;&nbsp;|&nbsp;&nbsp;\n"
var nav_small="<DIV class=botnav><a href="+rel+"index.html class=navsmall>Home</a>"+sep
+"<a href="+rel+"binny/service/index.htm class=navsmall>Services</a>"+sep
+"<a href="+rel+"binny/thecds/index.html class=navsmall>CDs</a>"+sep
+"<a href="+rel+"binny/myself/index.htm class=navsmall>Myself</a>"+sep
+"<a href="+rel+"binny/privacy.html class=navsmall>Privacy Policy</a>"+sep
+"<a href="+rel+"binny/site_map.html class=navsmall>Site Map</a></DIV>";
var nav_beg = "<DIV class=nav2box><A class=nav href=\""+rel+""
var nav_end = "</A></DIV></td>\n<td noWrap>"
var home = nav_beg+"index.html\">Home"+nav_end
var service = nav_beg+"binny/service/index.htm\">Services"+nav_end
var ent = nav_beg+"binny/ent/index.htm\">Entertainment"+nav_end
var advan = nav_beg+"binny/advan/index.htm\">Advanced"+nav_end
var pro = nav_beg+"binny/pro/index.htm\">Products"+nav_end
var cds = nav_beg+"binny/thecds/index.html\">Cds"+nav_end
var techno = nav_beg+"binny/techno/index.htm\">Techno Stuff"+nav_end
var myself = nav_beg+"binny/myself/index.htm\">Myself</A></td></tr></table></DIV>"

var nav_buttons="<DIV class=nav2><table width=\"100%\" cellpadding=0 cellspacing=1 class=navigation><tr>\n<td>"
+home+service+ent+advan+pro+cds+techno+myself
var title="<div class=Logo><h1 class=title>BinnyVA</h1></div>\n";
var logo=" &nbsp;<A href=\""+rel+"binny/myself/index.htm\"><IMG SRC=\""+rel+"binny/images/logo.gif\" ALT=\"It's Me\" BORDER=0></A>";
 
var frame1="<DIV class=main><DIV class=nav1><TABLE height=75 cellPadding=0 cellSpacing=0 border=0 width=100%><TR>\
<TD width=15% align=left><A href=\"index.htm\">"+logo+"</A></TD>\
<TD width=20% align=center><IMG src=\""+rel+"binny/images/themes/allstuffs/dots_line.gif\"></TD>\
<TD width=65% align=center>"+title+"</TD></TR></TABLE></DIV>"
var frame2="</td></tr>\n<tr><td colspan=2>"+nav_buttons+"</td></tr>\n<tr><td colspan=2 class=text><div class=result>\n";

var begin=frame1+frame2
var end="</div><BR clear=all><BR><BR>\n<center>"+nav_small+"</center>\n<DIV class=copywrite>Copyright © 2003 Binny's Softwares. All Rights Reserved</DIV>\n</td></tr></table>";

var sec_buts_beg = frame1+title+"</td></tr><tr><td colspan=2>"+nav_buttons+"<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0 CLASS=sub_back><TR><TD ALIGN=left>\n\
<table width=50% cellpadding=0 cellspacing=0><tr>"
var sec_buts_end = "</tr></table></TD></TR></TABLE>\n\
</td></tr><tr><td colspan=2 class=text>"

function sublink(text) {
 return("<td noWrap class=sub_link>"+text+"</td>") }
function writeIn(content) {
 if(content) document.write(content)
 else document.write("&nbsp;")}