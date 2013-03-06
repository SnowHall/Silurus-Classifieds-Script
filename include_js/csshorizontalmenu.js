var cssmenuids=["cssmenu1","cssmenu2","cssmenu3"] //Enter id(s) of CSS Horizontal UL menus, separated by commas
var csssubmenuoffset=-1 //Offset of submenus from main menu. Default is 0 pixels.

function createcssmenu2(){
for (var i=0; i<cssmenuids.length; i++){
  var tempd = document.getElementById(cssmenuids[i]);
  if(tempd)
  {
  
  	var ultags=tempd.getElementsByTagName("ul")
    for (var t=0; t<ultags.length; t++){
			ultags[t].style.top=ultags[t].parentNode.offsetHeight+csssubmenuoffset+"px"
    	var spanref=document.createElement("span")
			spanref.className="arrowdiv"
			spanref.innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;"
			ultags[t].parentNode.getElementsByTagName("a")[0].appendChild(spanref)
    	ultags[t].parentNode.onmouseover=function(){
					this.style.zIndex=100
    	this.getElementsByTagName("ul")[0].style.visibility="visible"
					this.getElementsByTagName("ul")[0].style.zIndex=0
					this.getElementsByTagName("a")[0].className='p_menu_h'		
					
    	}
    	ultags[t].parentNode.onmouseout=function(){
					this.style.zIndex=0
					this.getElementsByTagName("ul")[0].style.visibility="hidden"
					this.getElementsByTagName("ul")[0].style.zIndex=100
					this.getElementsByTagName("a")[0].className='p_menu'	
    	}
    }    
  }
  }
}

if (window.addEventListener)
window.addEventListener("load", createcssmenu2, false)
else if (window.attachEvent)
window.attachEvent("onload", createcssmenu2)