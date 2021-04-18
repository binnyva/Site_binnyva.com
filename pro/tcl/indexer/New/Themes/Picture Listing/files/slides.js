//<script>
//Shows the pictures one by one
function play(imgName)
 {
 for (i=0;i<=limit;i++)
  {
  if (document.images[imgName].src==img[i].src) //Search for the current image...
   {
   if (i==limit) document.images[imgName].src = img[0].src //If last image, put the first one.
   else document.images[imgName].src = img[i+1].src //Otherwise put the next image.
   break;
   }
  }
 }

//Show the pictures in the rewerse order
function rewind(imgName)
 {
 for (i=limit;i>=0;i--)
  {
  if (document.images[imgName].src==img[i].src)
   {
   if (i==0) document.images[imgName].src = img[limit].src
   else document.images[imgName].src = img[i-1].src
   break;
   }
  }
 }

//Show the current image in a popup window.
function showPic(imgName)
{
var img=document.images[imgName].src
window.open(img, 'Picture', 'scrollbars,resizable,width=690,height=530')
} 

//Auto change the images every 'delay' seconds
function auto()
 {
 if(frmf.on.checked)
  {
  setTimeout("play('pic')", delay);
  setTimeout("auto()", delay);
  } 
 }

//Loads the first picture
function firstPic()
 { 
 document.write("<img name=pic src=\""+img[0].src+"\" alt=\"Pictures\">");
 }