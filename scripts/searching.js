//<script>
/****************************************************************************
Let this comment intact and inform me if you want to use this script legally.
Script developed by Binny V Abraham
E-Mail: binnyva@hotmail.com
Website: www.geocites.com/binnyva
This code is Copyright (c) 2004 Binny V Abraham
All rights reserved.
License is granted to user to reuse this code on their own Web site
if, and only if, this entire copyright notice is included. The Web Site containing this script must be a not-for-profit(non-commercial) web site.
Exclusive permission must be obtained before using  this script
End copyright - This must be retained and posted as is to use this script
****************************************************************************/
//Return the filename of the given path
function getName(path)
 {
 parts=path.split("/")
 var end=parts.length
 var folder=parts[end-2]
 var temp=parts[end-1].split(".")
 var filename=temp[0]
 //Change '%20' to space
 filename=filename.replace(/%20/g," ")
 return filename
 }

//Searchs for a string and open the first file that matchs the string 
function search()
 {
 var to_find = frm.txt.value
 var links = this.document.all.tags("A")
 var got=0
 //Go thru evey image in the file.
 for (i=0; i<links.length; i++)
  {
  var name = getName(links(i).toString())
  var loc = links(i).toString().replace(/%20/g," ")
  var position=name.toUpperCase().search(to_find.toUpperCase())
  //If the text is found
  if(position>=0)
   {
   got++
   if(frm.open.checked) location.href=loc
   else if(confirm("Got "+to_find+" at "+loc+". Open the found file?")) location.href=loc 
   }
  }
 //Display message if no hits are found.
 if(!got)
  {
  alert(to_find+" can't be found.")
  }

 return false
 }

//This will delete all the links other than those which matchs the filter text
function filter()
 {
 //Get the text to search
 var to_find = fltr_frm.txt.value
 //Get all the links
 var links = this.document.all.tags("A")
 var got=0
 var hits=""
 //Go thru evey link in the file.
 for (i=0; i<links.length; i++)
  {
  var name = getName(links(i).toString())
  var loc = links(i).toString().replace(/%20/g," ")
  var position=name.toUpperCase().search(to_find.toUpperCase())
  //If the text is found
  if(position>=0)
   {
   got++
   hits=hits+"#"+loc
   }
  }
 //Display all the hits
 var cont=""
 arr=hits.split("#")
 for(i=1;i<arr.length;i++)
  {
  cont = cont + "<A href=\""+arr[i]+"\">"+getName(arr[i])+"</a><br>\n"
  }
 this.document.all("links").innerHTML = cont

 return false
 }
