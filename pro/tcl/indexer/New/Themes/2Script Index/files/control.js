function getControlTag(src)
 {
 TRok = false
 while ("HTML" != src.tagName)
  {
  if ("IMG" == src.tagName || "FONT" == src.tagName || "A" == src.tagName)
  TRok = true
  if ("LI" == src.tagName)
  return src
  if ("TR" == src.tagName)
   {
   if(TRok)
   return src
   return null
   }
  src = src.parentElement
  }
 return null
 }

function dynOutlineEnabled(src)
 {
 while ("HTML" != src.tagName)
  {
  if("OL" == src.tagName || "UL" == src.tagName || "TABLE" == src.tagName)
  if(null != src.getAttribute("mydynamicoutline", false))
  return true
  src = src.parentElement
  }
 return false
 }

function containedIn(src, dest)
 {
 while ("HTML" != src.tagName)
  {
  if (src == dest)
  return true
  src = src.parentElement
  }
 return false
 }

function mydynOutline()
 {
 var ms = navigator.appVersion.indexOf("MSIE");
 ie4 = (ms>0) && (parseInt(navigator.appVersion.substring(ms+5, ms+6)) >= 4);
 if(!ie4)
 return;
 var src = event.srcElement
 src = getControlTag(src)
 if (null == src)
 return
 if (!dynOutlineEnabled(src))
 return
 var idx = src.sourceIndex+1
 while (idx < document.all.length && containedIn(document.all[idx].parentElement, src))
  {
  srcTmp = document.all[idx]
  tag = srcTmp.tagName
  if ("UL" == tag || "OL" == tag || "TABLE" == tag)
  srcTmp.style.display = srcTmp.style.display == "none" ? "" : "none"
  idx++;
  }
 }

function dynCollapse()
 {
 var offset
 for(offset=0; offset<document.all.length; offset++)
  {
  var tag = document.all(offset).tagName;
  if("OL" == tag || "UL" == tag)
   {
   var el = document.all(offset)
   if(null != el.getAttribute("mydynamicoutline",false) && null !=el.parentElement.parentElement.getAttribute("mydynamicoutline",false) && "LI" != el.parentElement.parentElement.parentElement.tagName)
    {
    document.all(offset).style.display = "none";
    }
   }
  }
 }
