<div id="debug">
	<div id="debug-header">DEBUG MODE :: {$nb_queries} requête(s)</div>
	{section name=number loop=$all_queries}
		{if $smarty.section.number.index is even}<div class="even">{else}<div class="odd">{/if}
			{$all_queries[number]}
		</div>
	{/section}
</div>	