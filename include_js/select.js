function rsSelectReplace(sel)
{
	//а вдруг мы на осле :)
	var ie6 = (navigator.userAgent.search('MSIE 6.0') != -1);

	var ul = document.createElement('ul');
	//список заменяющий select, свернутый, не в фокусе
	ul.className = 'srList srCollapsed srBlur';
	
	//связь между ul и select
	ul.srSelect = sel;
	sel.srReplacement = ul;
	
	//устанавливаем для элемента select
	//класс показывающий, что он замещен
	sel.className += ' srReplacedSelect';

	//меняем класс элемента ul
	//при получении и потере фокуса
	//элементом select
	sel.onfocus = function() { this.srReplacement.className = this.srReplacement.className.replace(/[\s]?srBlur/, ' srFocus'); }

	sel.onblur = function() {
		//this.srReplacement.srCollapse();
		this.srReplacement.className = this.srReplacement.className.replace(/[\s]?srFocus/, ' srBlur');
	}
	
	//каждый браузер болеет по своему
	//поэтому обрабатываем и onchange и onkeypress
	sel.onchange = function()
	{
		var ul = this.srReplacement;
		ul.srSelectLi(ul.childNodes[this.selectedIndex]);
	}
	
	sel.onkeypress = function(e)
	{
		var i = this.selectedIndex;
		var ul = this.srReplacement;
		switch (e.keyCode) {
			case 9:
				this.srReplacement.srCollapse();
			break;

			case 37: // влево
			case 38: // вверх
				if (i - 1 >= 0)
					ul.srSelectLi(ul.childNodes[i - 1]);
			break;

			case 40: // вниз
				if(e.altKey)
				{
					//ul.srExpand();
					//break;
				}
			case 39: // вправо

				if (i + 1 < ul.childNodes.length)
					ul.srSelectLi(ul.childNodes[i + 1]);
			break;

			case 33: // Page Up
			case 36: // Home
				ul.srSelectLi(ul.firstChild);
			break;

			case 34: // Page Down
			case 35: // End
				ul.srSelectLi(ul.lastChild);
			break;
		}
	}

	//меняем класс элемента ul
	//при наведении на него мышки
	ul.onmouseover = function() { this.className += ' srHoverUl'; }

	ul.onmouseout = function() { this.className = this.className.replace(/[\s]?srHoverUl/, ''); }

	ul.srSelectLi = function(li)
	{
		var ul = li.parentNode;

		//если уже есть выбранный элемент
		//то назначаем снимаем выделение
		if(ul.srSelectesIndex != null)
			ul.childNodes[ul.srSelectesIndex].className = '';

		//запоминаем индекс выбранного элемента
		ul.srSelectesIndex = li.srIndex;

		//устанавливаем для выбранного элемента
		//класс srSelectedLi
		ul.childNodes[li.srIndex].className = 'srSelectedLi';
		return li.srIndex;
	}

	ul.srExpand = function()
	{
		if(!this.srExpanded)
		{
			if(document.srExpandedList)
				document.srExpandedList.srCollapse();

			document.srExpandedList = this;

			//разворачиваем список
			this.className  = this.className.replace(/[\s]?srCollapsed/, ' srExpanded');
			this.srExpanded = true;
			
			//при раскрытии элемента передаем фокус
			//соответствующему select
			this.srSelect.focus();

			//для особо одаренного браузера
			//разворачиваем список особенным способом
			if(ie6) 
			{
				var node = this.firstChild;
				var offset = 0;
				var height = node.clientHeight;
				while(node)
				{
					node.style.position = 'absolute';
					node.style.top = offset;
					offset += height; 
					node = node.nextSibling;
				}
			}
		}
	}

	ul.srCollapse = function(li)
	{	
		if(this.srExpanded)
		{
			document.srExpandedList = null;

			//выбираем элемент списка на который кликнул пользователь
			//и устанавливаем соответсвующий индекс выбранного элемента
			//для спрятанного элемента select
			if(li)
				this.srSelect.selectedIndex = this.srSelectLi(li);
			
			//при клике на элементы списка
			//соответствующий спрятанный select
			//теряет фокус нужно вернуть на место
			this.srSelect.focus();

			//сворачиваем список
			this.className = this.className.replace(/[\s]?srExpanded/, ' srCollapsed');
			this.srExpanded = false;

			//для особо одаренного браузера
			//сворачивам список особенным способом
			if(ie6)
			{
				var node = this.firstChild;
				while(node)
				{
					node.style.position = '';
					node = node.nextSibling;
				}
			}
		}
	}


	var options = sel.options;
	var len = options.length;

	for(var i = 0; i < len; i++)
	{
		//для каждого элемента option
		//создаем соответствущий li
	    var li = document.createElement('li');
		li.appendChild(document.createTextNode(options[i].text));

		//в каждом элементе списка
		//храним индекс соответствующего
		//элемента option
		li.srIndex = i;

		//псевдо класс hover в IE работает только для ссылок
		//поэтому будем менять класс при наведении мышки
		li.onmouseover = function() { this.className += ' srHoverLi'; }

		li.onmouseout = function() { this.className = this.className.replace(/[\s]?srHoverLi/, ''); }

		ul.appendChild(li);
	}
	
	//если по умолчанию не выбран никакой элемент
	//выбираем первый
	if(sel.selectedIndex == null)
		sel.selectedIndex = 0;

	//устанавливаем элемент выбранный по умолчанию
	ul.srSelectLi(ul.childNodes[sel.selectedIndex]);

	//вставляем созданный список
	//перед заменяемым select
	sel.parentNode.insertBefore(ul, sel);
}

function srAddEvent(obj, type, fn)
{ 
	// функция добавляет обработчик события
	if (obj.addEventListener)
		obj.addEventListener(type, fn, false);
	else if (obj.attachEvent)
		obj.attachEvent( "on"+type, fn );
}

function srOnDocumentClick(e)
{
	var target = (window.event) ? window.event.srcElement : e.target;

	if(document.srExpandedList)
	{
		//принадлежит ли соответствующий li списку заменителю select
		if((target.srIndex || target.srIndex === 0)
			//принадлежит ли наш li открытому в данный момент списку
			&& document.srExpandedList == target.parentNode	)
			document.srExpandedList.srCollapse(target);
		else
			document.srExpandedList.srCollapse();
	}
	else
	{
		if(target.srIndex || target.srIndex === 0)
			target.parentNode.srExpand();
	}
}


function srReplaceSelects()
{
	//заменяем все элементы select
	/*var s = document.getElementsById('select');
	var len = s.length
	for (var i = 0; i < len; i++)
		rsSelectReplace(s[i]);*/
		
	var s = document.getElementById('selectid');
	rsSelectReplace(s);
	srAddEvent(document, 'click', srOnDocumentClick);
}

//при реальном применение желательно
//вызывать эту функцию сразу
//после загрузки DOM во многих фреймворках
//есть такая возможность, например, в jQuery
//это можно сделать так:
//$(document).ready(rsReplaceSelects);
srAddEvent(window, 'load', srReplaceSelects);

