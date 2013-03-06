	{if $aNavi && count($aNavi)>0} 

		{foreach from=$aNavi item=item} 
			{if $item.url}
				<a href="{$item.url}" class="nav_active">{$item.title}</a> > 
			{else}
				{$item.title} > 
			{/if}
		
		{/foreach}				
			
	{/if}