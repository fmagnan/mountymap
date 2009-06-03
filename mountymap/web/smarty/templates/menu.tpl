<ul>
	{foreach from=$menu_items item=data key=url}
		{if $logged_in_user->isAdmin() || !$data.admin}
			<li><a href="{$url}">{$data.title}</a></li>
		{/if}
	{/foreach}
</ul>