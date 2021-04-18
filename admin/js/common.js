function addEvent(elm,evType,fn,capture) {
if(!capture) var capture = true;
if (elm.addEventListener) {elm.addEventListener(evType, fn, capture);return true;}
else if (elm.attachEvent) {var r = elm.attachEvent('on' + evType, fn);return r;}
else {elm['on' + evType] = fn;}
}
function getPosition(offsetTrail) {
    var offsetLeft = 0;
    var offsetTop = 0;
    while (offsetTrail) {
        offsetLeft += offsetTrail.offsetLeft;
        offsetTop += offsetTrail.offsetTop;
        offsetTrail = offsetTrail.offsetParent;
    }
    if (navigator.userAgent.indexOf("Mac") != -1 && typeof document.body.leftMargin != "undefined") {
        offsetLeft += document.body.leftMargin;
        offsetTop += document.body.topMargin;
    }

	var xy = new Array(offsetLeft,offsetTop);
    return xy;
}
//Returns the target of the event.
function findTarget(e) {
	var element;
	if (!e) var e = window.event;
	if (e.target) element = e.target;
	else if (e.srcElement) element = e.srcElement;
	if (element.nodeType == 3) element = element.parentNode;// defeat Safari bug
	return element;
}
//Compressed Stuff
function getAll(e){return e.all?e.all:e.getElementsByTagName('*');}
function getElementsByCSS(selector){if(!document.getElementsByTagName) return new Array();var tks=selector.split(' '),cc=new Array(document);for(var i=0;i<tks.length;i++){tk=tks[i].replace(/^\s+/,'').replace(/\s+$/,'');if(tk.indexOf('#')>-1){var bits=tk.split('#'),tn=bits[0],id=bits[1],el=document.getElementById(id);if(tn && el.nodeName.toLowerCase()!=tn)return new Array();cc=new Array(el);continue;}if(tk.indexOf('.')>-1){var bits=tk.split('.'),tn=bits[0],className=bits[1],fnd=new Array,fc=0;if(!tn) tn='*';for(var h=0;h<cc.length;h++){var es;if(tn=='*')es=getAll(cc[h]);else es=cc[h].getElementsByTagName(tn);for(var j=0;j<es.length;j++){fnd[fc++]=es[j];}}cc=new Array;var ccIndex=0;for(var k=0;k<fnd.length;k++){if(fnd[k].className && fnd[k].className.match(new RegExp('\\b'+className+'\\b')))cc[ccIndex++]=fnd[k];}continue;}if(tk.match(/^(\w*)\[(\w+)([=~\|\^\$\*]?)=?"?([^\]"]*)"?\]$/)) {var tn=RegExp.$1,an=RegExp.$2,attrOperator=RegExp.$3,av=RegExp.$4,fnd=new Array,fc=0;if(!tn) tn='*';for(var h=0;h<cc.length;h++) {var es;if(tn=='*')es=getAll(cc[h]);else es=cc[h].getElementsByTagName(tn);for(var j=0;j<es.length;j++) {fnd[fc++]=es[j];}}cc=new Array;var ccIndex=0,cf;switch(attrOperator){case '=':cf=function(e){return(e.getAttribute(an)==av);};break;case '~':cf=function(e){return(e.getAttribute(an).match(new RegExp('\\b'+av+'\\b')));};break;case '|':cf=function(e){return(e.getAttribute(an).match(new RegExp('^'+av+'-?')));};break;case '^':cf=function(e){return(e.getAttribute(an).indexOf(av)==0);};break;case '$':cf=function(e){return(e.getAttribute(an).lastIndexOf(av)==e.getAttribute(an).length-av.length);};break;case '*':cf=function(e){return(e.getAttribute(an).indexOf(av)>-1);};break;default:cf=function(e){return e.getAttribute(an);};}cc=new Array;var ccIndex=0;for(var k=0;k<fnd.length;k++)if(cf(fnd[k]))cc[ccIndex++]=fnd[k];continue;}tn=tk;var fnd=new Array,fc=0;for(var h=0;h<cc.length;h++){var es=cc[h].getElementsByTagName(tn);for(var j=0;j<es.length;j++) fnd[fc++]=es[j];}cc=fnd;}return cc;}
function getElementsByClassName(classname,tag){if(!tag)var tag="";return getElementsByCSS(tag+"."+classname);}
function $(id){return document.getElementById(id);}
function toggle(item,state) {if(state) item.style.display = state;else item.style.display = (item.style.display == "block") ? "none" : "block";}

jx={http:false,format:'text',callback:function(data){},error:false,getHTTPObject:function(){var http=false;
if(typeof ActiveXObject !='undefined'){try{http=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){
try{http=new ActiveXObject("Microsoft.XMLHTTP");}catch(E){http=false;}}
}else if(XMLHttpRequest){try{http=new XMLHttpRequest();}catch(e){http=false;}}return http},
load:function(url,callback,format){this.init();if(!this.http||!url)return;
if(this.http.overrideMimeType)this.http.overrideMimeType('text/xml');this.callback=callback;
if(!format)var format="text";this.format=format.toLowerCase();var ths=this;
if(this.http.overrideMimeType)this.http.overrideMimeType('text/xml');var now="uid="+new Date().getTime();
url+=(url.indexOf("?")+1)?"&":"?";url+=now;this.http.open("GET",url,true);this.http.onreadystatechange=function(){
if(!ths)return;var http=ths.http;if(http.readyState==4){if(http.status==200){var result="";
if(http.responseText)result=http.responseText;if(ths.format.charAt(0)=="j"){result=result.replace(/[\n\r]/g,"");
result=eval('('+result+')'); }if(ths.callback)ths.callback(result);}else{
if(ths.error)ths.error();}}};this.http.send(null);},init:function(){this.http=this.getHTTPObject();}}

//Custom Stuff
var rel = "";

function menuInit() {
	if (document.all && document.getElementById) { //Only IE allowed(only it supports 'document.all')
		var navRoot = document.getElementById("main-menu");

		for (var i=0; i<navRoot.childNodes.length; i++) {
			var node = navRoot.childNodes[i];
			if (node.nodeName == "LI") {
				node.onmouseover=function() {
					this.className+=" over";
				}
				node.onmouseout=function() {
					this.className=this.className.replace(" over", "");
				}
			}
		}
	}
}

function replyTo(id,subject) {
	$('replyto').value = id;
	toggle($('replyto-message'),'block');
	$('replyto-message').innerHTML = "Reply to "+subject+"'s comment. <a href='#comment_text' onclick='noReply()'>Don't Reply</a>";
}
function noReply() {
	toggle($('replyto-message'),'none');
	$('replyto').value = 0;
}

function siteInit() {
	var email = 'bin'+ 'nyva';
	var email_links = getElementsByClassName("email-encrypt","span");
	email += '@gma' + 'il.com';
	for(var i=0;i<email_links.length;i++) {
		email_links[i].innerHTML = '<a href="mailto:'+email+'">'+email+'</a>';
		email_links[i].className = "";
	}
	
	//Find relation
	var org_loc=document.location.toString();
	var sl=0,in_comp=0;
	if(!org_loc.indexOf("http://localhost/binco")) {loc=org_loc.replace("http://localhost/binco","");in_comp=1;}
	else if(!org_loc.indexOf("http://www.bin-co.com")) loc=org_loc.replace("http://www.bin-co.com","")
	else loc=org_loc;
	for(var i=0;i<loc.length;i++) {
	if(loc.charAt(i)=="/") {
	if(sl) rel=rel+"../";
	sl++;}
	}
	
	//Protection against Spam bots
	if($("commenter")) {
		$("commenter").checked = false;
		$("bot-protection").style.display = 'none';
	}
	menuInit();
	if(window.init) init();
}
addEvent(window,'load',siteInit);