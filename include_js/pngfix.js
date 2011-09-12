var arVersion = navigator.appVersion.split("MSIE");
var version = parseFloat(arVersion[1]);

if ((version >= 5.5) && (document.body.filters))
{
	window.attachEvent( 'onload', png_fix );
}

function png_fix()
{
	for(var i=0; i<document.images.length; i++)
	{
		var img = document.images[i];
		if (img.src.substring(img.src.length-3, img.src.length).toUpperCase() == "PNG")
		{
			img.style.cssText = img.style.cssText + '; width:' + img.width + 'px; height:' + img.height + 'px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + img.src + '\', sizingMethod=\'scale\');';
			img.src = site_url + 'templates/default/img/spacer.gif';
		}
	}
}