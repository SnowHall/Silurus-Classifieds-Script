var zoom_active=false;
var doczi = null;
var docz = null;

function blacksite()
{
	document.getElementById('back').style.display='block';
	if("\v"!="v")
		document.getElementById('div_body').style.position = "fixed";
	else
		window.scroll(0,0);
}

function whitesite()
{
	document.getElementById('back').style.display='none';
	if("\v"!="v")
		document.getElementById('div_body').style.position = "static";
	else
		window.scroll(0,0);
}

function zoom_ini()
{
	doczi = document.getElementById('image_zoom_img');
	docz = document.getElementById('image_zoom');
	document.onmousemove=mouse_move;
}

function enable_zoom(obj,width,height)
{
	if(docz && doczi && obj)
	{
		zoom_active=true;
		doczi.src=obj.src;
		doczi.style.width=width;
		doczi.style.height=height;
		if(navigator.appName!='Netscape') mouse_move(window.event);
		docz.style.display='block';
	}
}

function disable_zoom()
{
	if(docz)
	{
		docz.style.display='none';
		docz.style.top=0;
 		docz.style.left=0;
		zoom_active=false;
	}
}

function mouse_move(env)
{
	if(zoom_active && docz && doczi)
	{
	    e = window.event;
		if(e)
		{
			if (e.pageX || e.pageY)
			{
			   dleft = e.pageX;
			   dtop = e.pageY;
			}
			else if (e.clientX || e.clientY)
			{
			   dleft = e.clientX + (document.documentElement.scrollLeft || 	document.body.scrollLeft) - document.documentElement.clientLeft;
			   dtop = e.clientY + (document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
			}
		}
		else
		{
		   scrollTop   = window.pageYOffset;
     	   scrollLeft  = window.pageXOffset;
		   dleft   = scrollLeft + env.clientX;
		   dtop  = scrollTop + env.clientY;
		}

		//ih = doczi.style.height;
		//ih = ih.substring(0,(ih.length-2));
		dtop = dtop+12;
		dleft = dleft +12;

		docz.style.top=dtop+'px';
 		docz.style.left=dleft+'px';
	}
}

function set_banner_show(id,ip,page)
{
	var ajaxObjects = new sack();
	ajaxObjects.onCompletion = function(){};
	ajaxObjects.requestFile = "ajax_setBannerShow.php?id="+id+"&ip="+ip+"&page="+page+"&nocash="+(new Date().getTime());
	ajaxObjects.runAJAX();
}

function change_show_list(type,user)
{
	obj = document.getElementById('book_list_'+type);
	obj_img = document.getElementById('book_list_img_'+type);
	obj_td = document.getElementById('book_list_td_'+type);

	if(obj)
	{
		var param = 0;
		var ajaxObjects = new sack();
		ajaxObjects.onCompletion = function(){};
		if(obj.style.display=='none')
		{
			obj.style.display='block';
			obj_img.src=''+template_path+'img/arrb_up.png';
			obj_td.className = 'book_title_td2';
		}
		else
		{
			var param = 1;
			obj.style.display='none';
			obj_img.src=''+template_path+'img/arrb_left.png';
			obj_td.className = 'book_title_td';
		}
		ajaxObjects.requestFile = "ajax_setListStatus.php?user="+user+"&type="+type+"&param="+param+"&nocash="+(new Date().getTime());
		ajaxObjects.runAJAX();
	}
}

function show_book_info(id,obj,type,url)
{
	var ajaxObjects2 = new sack();
	ajaxObjects2.requestFile = "ajax_getPreviewContact.php?id="+id+"&url="+url+"&type="+type+"&nocash="+(new Date().getTime());
	ajaxObjects2.onCompletion = function()
	{
		document.getElementById('contact_popover_inner').innerHTML = ajaxObjects2.response;
	};
	ajaxObjects2.runAJAX();
	var ajaxObjects = new sack();
	ajaxObjects.requestFile = "ajax_getPreview.php?id="+id+"&type="+type+"&nocash="+(new Date().getTime());
	ajaxObjects.onCompletion = function()
	{
		document.getElementById('content_inner').innerHTML = ajaxObjects.response;
	};
	ajaxObjects.runAJAX();

	var fav_toppx = efav_getTop(obj);
	if(!fav_toppx || fav_toppx == 0) fav_toppx = 450;
	fav_toppx = fav_toppx - 100;
	var infoblock = document.getElementById('info_popover');
	infoblock.style.top = fav_toppx+'px';
	infoblock.style.display='block';
}

function efav_getTop(element) {
	result = element.offsetTop;
	if (element.offsetParent) result += efav_getTop(element.offsetParent);
	return result;
}


function getcitylist(num)
{
	var val = document.getElementById('autoenter_value'+num).value;
	if(val != '')
	{
		var divdoc = document.getElementById('autoenter_div'+num);
		var ajaxObjects = new sack();
		ajaxObjects.requestFile = "ajax_getCityList.php?tag="+val+"&type="+num+"&nocash="+(new Date().getTime());
		ajaxObjects.onCompletion = function()
		{
			if(ajaxObjects.response != '')
			{
				divdoc.innerHTML = ajaxObjects.response;
				divdoc.style.display = 'block';
			}
			else
			{
				divdoc.innerHTML = '';
				divdoc.style.display = 'none';
			}

		};
		ajaxObjects.runAJAX();
	}
}

function insertcity(num,val)
{
	document.getElementById('autoenter_value'+num).value=val;
	var divdoc = document.getElementById('autoenter_div'+num);
	divdoc.innerHTML = '';
	divdoc.style.display = 'none';

}

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s);js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
