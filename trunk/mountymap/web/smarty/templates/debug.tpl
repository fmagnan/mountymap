<div id="debug">
	<div id="debug-header">DEBUG MODE :: {$nb_queries} requête(s)</div>
	{section name=number loop=$all_sql_queries}
		{if $smarty.section.number.index is even}<div class="even">{else}<div class="odd">{/if}
			{$all_sql_queries[number]}
		</div>
	{/section}
</div>
<div id="error">
	{section name=err loop=$all_errors}
		{if $smarty.section.err.index is even}<div class="even">{else}<div class="odd">{/if}
			{$all_errors[err]}
		</div>
	{/section}
</div>