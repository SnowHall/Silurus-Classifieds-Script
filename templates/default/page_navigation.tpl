	{if $aPaging and $aPaging.iCountPage>1} 			
										
					{if $aPaging.iPrevPage}
    					<a href="{$aPaging.query}&{$aPaging.name}={$aPaging.iPrevPage}{$aPaging.sGetParams}">&lt;&lt;Previous</a>
    				{else}
    					&lt;&lt;Previous
    				{/if}
    				&nbsp; &nbsp;
    				
    				
					{if $aPaging.iCurrentPage>1}
						<a href="{$aPaging.query}&{$aPaging.name}=1{$aPaging.sGetParams}">&larr;</a>
					{/if}
					{foreach from=$aPaging.aPagesLeft item=iPage}
						<a href="{$aPaging.query}&{$aPaging.name}={$iPage}{$aPaging.sGetParams}">{$iPage}</a>
					{/foreach}
					{$aPaging.iCurrentPage}
					{foreach from=$aPaging.aPagesRight item=iPage}
						<a href="{$aPaging.query}&{$aPaging.name}={$iPage}{$aPaging.sGetParams}">{$iPage}</a>
					{/foreach}
					{if $aPaging.iCurrentPage<$aPaging.iCountPage}
						<a href="{$aPaging.query}&{$aPaging.name}={$aPaging.iCountPage}{$aPaging.sGetParams}">{$aLang.dop_navi_last}</a>
					{/if}	
					
					&nbsp; &nbsp;
					{if $aPaging.iNextPage}
    					<a href="{$aPaging.query}&{$aPaging.name}={$aPaging.iNextPage}{$aPaging.sGetParams}">Next&gt;&gt;</a>
    				{else}
    					Next&gt;&gt;
    				{/if}				
				
			
	{/if}