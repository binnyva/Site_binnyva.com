/*<script>*/
/*Author : Binny V Abraham,http://www.geocities.com/binnyva
This script and System is made by the author for personal purposes only. If 
any person other than the author wants to use this system, he/she must have
the prior written permission from the author.*/
var org_loc=document.location.toString();
var sl=0
var rel=""
var loc=""
var in_comp=0
if(!org_loc.indexOf("http://localhost/binnyva/binnyva")) { loc=org_loc.replace("http://localhost/binnyva/binnyva",""); in_comp=1 }
else if(!org_loc.indexOf("http://www.binnyva.com")) loc=org_loc.replace("http://www.binnyva.com","")
else loc="http://www.binnyva.com/"
for(i=0;i<loc.length;i++) {
if(loc.charAt(i)=="/") {
if(sl) rel=rel+"../"
sl++;}
}

var ads = "";

var sep=" | "
var nav_small="<a href="+rel+"index.html class=\"navsmall\">Home</a>"+sep
+"<a href="+rel+"binny/service/cd/index.html class=\"navsmall\">Services</a>"+sep
+"<a href="+rel+"binny/pro/index.htm class=\"navsmall\">Programs</a>"+sep
+"<a href="+rel+"binny/thecds/index.html class=\"navsmall\">CDs</a>"+sep
+"<a href="+rel+"binny/myself/index.htm class=\"navsmall\">Myself</a>"+sep
+"<a href="+rel+"binny/privacy.html class=\"navsmall\">Privacy Policy</a>"+sep
+"<a href="+rel+"binny/site_map.html class=\"navsmall\">Site Map</a>";
var divider = "<br><center>"+nav_small+"</center>\n</td><td class=\"ads-right\">";

var nav_beg = "<A class=\"nav\" href=\""+rel+""
var nav_end = "</A></td>\n<td noWrap>"
var home = nav_beg+"index.html\">Home"+nav_end
var service = nav_beg+"binny/service/cd/index.html\">Services"+nav_end
var pro = nav_beg+"binny/pro/index.htm\">Programs"+nav_end
var cds = nav_beg+"binny/thecds/index.html\">CDs"+nav_end
var others = nav_beg+"binny/others/index.html\">Others"+nav_end
var myself = nav_beg+"binny/myself/index.htm\">Myself"+nav_end
var guest = nav_beg+"guestbook.html\">GuestBook</A></td></tr></table>"

var sb = "<TD noWrap><a class=\"sites\" HREF=\""
var se = "</a></TD>\n"
var sites = "<TABLE class=\"sites-area\"><TR>"+sb+rel+"code/index.html\">Bin-Co Source Codes"+se+
sb+rel+"creation/index.htm\">Creationism"+se+
sb+rel+"bible/index.html\">Bible Resources"+se+"</TR></TABLE>"
//sb+"http://binnyva.tripod.com/ministry/index.html\">Phileo Ministries"+se+ - Add This later

var nav_buttons="<table class=\"navigation\"><tr>\n<td>"+home+service+pro+cds+others+myself+guest
var logo="<A href=\""+rel+"index.html\"><IMG SRC=\""+rel+"binny/images/logo.gif\" ALT=\"It's Me\" class=\"logo\"></A>";

var frame1="<table class=\"root-table\">\
<tr class=\"toplogo\"><td colspan=\"2\">\n<table class=\"top-table\"><tr><td>\n"+logo+"\n</td>\n\
<td class=\"top-title-td\"><h1 class=\"title\">BinnyVA</h1>\n"+sites+"</td></tr></table>\n";
var frame2="</td></tr><tr><td colspan=\"2\">\n"+nav_buttons+"\n</td></tr>\n<tr><td class=\"text\">\n";

var last="</td></tr></table>\n"
var stat="<!-- StatCounter Code -->\n\
<script type=\"text/javascript\" language=\"javascript\">\n\
var sc_project=345387;\nvar sc_partition=1;\nvar sc_invisible=1;\n\
</script>\n\
<script type=\"text/javascript\" language=\"javascript\" src=\"http://www.statcounter.com/counter/counter.js\"></script>\n\
<noscript><a href=\"http://www.statcounter.com/free_web_stats.html\" target=\"_blank\"><img src=\"http://c2.statcounter.com/counter.php?sc_project=345387&amp;java=0&amp;invisible=1\" alt=\"free stats\" border=\"0\"></a> </noscript>\n"
var begin=frame1+frame2+ads
if (in_comp) begin=frame1+frame2; //Disable ads in our system.
var end="<br><center>"+nav_small+"</center>"+last+stat

var sec_buts_beg = frame1+"</td></tr><tr><td colspan=2>"+nav_buttons+"<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0 CLASS=sub_back><TR><TD ALIGN=left>\n\
<table width=50% cellpadding=0 cellspacing=0><tr>"
var sec_buts_end = "</tr></table></TD></TR></TABLE>\n\
</td></tr><tr><td colspan=2 class=text>"+ads
var em = "<A href=\"mailto:binnyva"+"@gmail.com\">binnyva"+"@gmail.com</A>"

var written = 0
function sublink(text) {
return("<td noWrap class=sub_link>"+text+"</td>") }
function writeIn(content) {
if(content) document.write(content)
else document.write("&nbsp;")}
function writer() {
if(!written) {
if (in_comp) document.write(frame1+frame2)
else { document.write(frame1+frame2+ads) }
written=1;
}
else document.write(last+stat)
}
function layout() {
if(!written) {
document.write(frame1+frame2)
written=1;
}
else document.write(last+stat)
}
