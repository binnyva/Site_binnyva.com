/*<script>*/
/*Author : Binny V Abraham,http://binnyva.tripod.com
This script and System is made by the author for personal purposes only. If 
any person other than the author wants to use this system, he/she must have
the prior written permission from the author.*/
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

var sep=" | "
var nav_small="<a href="+rel+"index.html class=navsmall>Home</a>"+sep
+"<a href="+rel+"binny/service/index.htm class=navsmall>Services</a>"+sep
+"<a href="+rel+"binny/thecds/index.html class=navsmall>CDs</a>"+sep
+"<a href="+rel+"binny/myself/index.htm class=navsmall>Myself</a>"+sep
+"<a href="+rel+"binny/privacy.html class=navsmall>Privacy Policy</a>"+sep
+"<a href="+rel+"binny/site_map.html class=navsmall>Site Map</a>";
var nav_beg = "<A class=nav href=\""+rel+""
var nav_end = "</A></td>\n<td noWrap>"
var home = nav_beg+"index.html\">Home"+nav_end
var service = nav_beg+"binny/service/index.htm\">Services"+nav_end
var ent = nav_beg+"binny/ent/index.htm\">Entertainment"+nav_end
var advan = nav_beg+"binny/advan/index.htm\">Advanced"+nav_end
var pro = nav_beg+"binny/pro/index.htm\">Products"+nav_end
var cds = nav_beg+"binny/thecds/index.html\">Cds"+nav_end
var techno = nav_beg+"binny/techno/index.htm\">Techno Stuff"+nav_end
var myself = nav_beg+"binny/myself/index.htm\">Myself</A></td></tr></table>"

var nav_buttons="<table width=\"100%\" cellpadding=0 cellspacing=1 class=navigation><tr>\n<td>"
+home+service+ent+advan+pro+cds+techno+myself
var title="<h1 class=title>BinnyVA</h1>\n";
var logo=" &nbsp;<A href=\""+rel+"binny/myself/index.htm\"><IMG SRC=\""+rel+"binny/images/logo.gif\" ALT=\"It's Me\" BORDER=0></A>";

var frame1="<table width=100% cellpadding=0 cellspacing=0 name=root>\
<tr class=toplogo><td>\n<table><tr><td>\n"+logo+"\n</td></tr></table></td>\n<td width=80%>";
var frame2="</td></tr><tr><td colspan=2>\n"+nav_buttons+"\n</td></tr>\n<tr><td colspan=2 class=text>";

var begin=frame1+title+frame2
var end="<center>"+nav_small+"</center></td></tr></table>";

var sec_buts_beg = frame1+title+"</td></tr><tr><td colspan=2>"+nav_buttons+"<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0 CLASS=sub_back><TR><TD ALIGN=left>\n\
<table width=50% cellpadding=0 cellspacing=0><tr>"
var sec_buts_end = "</tr></table></TD></TR></TABLE>\n\
</td></tr><tr><td colspan=2 class=text>"

function sublink(text) {
 return("<td noWrap class=sub_link>"+text+"</td>") }
function writeIn(content) {
 if(content) document.write(content)
 else document.write("&nbsp;")}