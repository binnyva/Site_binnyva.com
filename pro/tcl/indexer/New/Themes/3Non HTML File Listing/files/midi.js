/*<script>*/
var mn="";
var content = "";
function create(mn,det)
{
content = ("<HTML><HEAD><TITLE>MIDI</TITLE><bgsound src='"+mn+"' loop=-1></head><body bgcolor=#FEC9BC><p><a href='javascript:window.close()' style='color:#FF0000;text-decoration:none'>CLOSE WINDOW</a></p><h1>"+det+"</h1><h3>"+mn+"</h3>\n<p>To stop playing click <a href='javascript:void.stop()'>Stop</a></p><p>To start from the beginning click <a href='javascript:location.reload()'>Play</a></p><p><a href='"+mn+"'>Download Song</a></p>\n</body></html>")
newwin = window.open("","window","resizeable,width=400,height=300");
setTimeout("newwin.document.write(content)",0);
//newwin.close()
}