//<script>
//Return the filename of the given path
function getName(path)
 {
 parts=path.split("/")
 var end=parts.length
 var folder=parts[end-2]
 var temp=parts[end-1].split(".")
 var filename=temp[0]
 //Change '%20' to space
 filename=filename.replace("%20"," ")
 return filename
 }

function makeInfo()
 {
 var pix = this.document.all.tags("IMG");
 //Go thru evey image in the file.
 for (i=0; i<pix.length; i++)
  {
  var size=pix(i).width+"x"+pix(i).height  
  var divID = "id"+i
  this.document.all(divID).innerHTML = size
  
  //Resizing images.
  if (!f1.check.checked)
   {
   if (pix(i).OLDWIDTH != null) pix(i).width = pix(i).OLDWIDTH;
   if (pix(i).OLDHEIGHT != null) pix(i).height = pix(i).OLDHEIGHT;
   }
  else
   {
   pix(i).OLDWIDTH = pix(i).width;
   pix(i).OLDHEIGHT = pix(i).height;
   if (pix(i).width > 100) pix(i).width = 100;
   if (pix(i).height > 100) pix(i).height = 100;
   }
  }
 }

//Scale all the images.
function scaleImages() {
var colTemp = this.document.all.tags("IMG");
 if (!f1.check.checked) {
  for (iImgCnt = 0; iImgCnt < colTemp.length; iImgCnt++) {
    if (colTemp(iImgCnt).OLDWIDTH != null) colTemp(iImgCnt).width = colTemp(iImgCnt).OLDWIDTH;
    if (colTemp(iImgCnt).OLDHEIGHT != null) colTemp(iImgCnt).height = colTemp(iImgCnt).OLDHEIGHT;
   } //for(iImgCnt = 0;..
  } //if (this.event.srcElement.checked)
else {
  for (iImgCnt = 0; iImgCnt < colTemp.length; iImgCnt++) {
    if (colTemp(iImgCnt).complete) {
      colTemp(iImgCnt).OLDWIDTH = colTemp(iImgCnt).width;
      colTemp(iImgCnt).OLDHEIGHT = colTemp(iImgCnt).height;
      if (colTemp(iImgCnt).width > 100) colTemp(iImgCnt).width = 100;
      if (colTemp(iImgCnt).height > 100) colTemp(iImgCnt).height = 100;
      } // if (colTemp(iImgCnt).complete)
    } // for (iImgCnt = 0 ...
  } //else
}
