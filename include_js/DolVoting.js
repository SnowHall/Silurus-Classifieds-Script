
function DolVoting (sUrl, sSystem, iObjId, sId, sIdSlider, iSize, iMax)
{
	this._sUrl = sUrl;
	this._sSystem = sSystem;
	this._iObjId = iObjId;
	this._sId = sId;
	this._sIdSlider = sIdSlider;
	this._iSize = iSize;
	this._iMax = iMax;
	this._iSaveWidth = -1;
}

DolVoting.prototype.over = function (i)
{
	var e = this._e(this._sIdSlider)
	this._iSaveWidth = parseInt(e.style.width);
	e.style.width = i*this._iSize + 'px';	
}

DolVoting.prototype.setRate = function (fRate)
{
	var e = this._e(this._sIdSlider);
	e.style.width = fRate*this._iSize + 'px';
}

DolVoting.prototype.setCount = function (iCount)
{
	var e = this._e(this._sId);
	var eb = e.getElementsByTagName('b')[0]
	var a = eb.innerHTML.match(/(\d+)/);
	eb.innerHTML = eb.innerHTML.replace(a[1], iCount);
}

DolVoting.prototype.out = function ()
{
	var e = this._e(this._sIdSlider)
	e.style.width = parseInt(this._iSaveWidth) + 'px';
}

DolVoting.prototype.vote = function (i)
{
	var $this = this;
	var h = function (s)
	{
		if (!s.length) return;	
		var a = s.match(/([0-9\.]+),([0-9\.]+)/);
		$this._iSaveWidth = i*$this._iSize;
		$this.setRate(i);		
		$this.setCount(a[2]);
        $this.onvote(a[1], a[2])
	}

	document.getElementById(this._sId).value=i;	
	this._iSaveWidth = i*32;
}

DolVoting.prototype.onvote = function (fRate, iCount)
{

}

DolVoting.prototype._e = function (s)
{
	return document.getElementById(s);
}


