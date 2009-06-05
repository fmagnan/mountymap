<ul>
	{foreach from=$menu_items item=data key=url}
		<li><a href="{$url}">{$data}</a></li>
	{/foreach}
</ul>