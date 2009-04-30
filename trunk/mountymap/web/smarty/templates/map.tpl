{include file='header.tpl'}
    
{if is_array($map) && count($map) > 0}
	nombre de cases par ligne : {$row_size}
	<table id="map">
		{section name=numero loop=$map}
			{assign var=num_cell value=$smarty.section.numero.index}
			{assign var=trolls value=$map[$num_cell].info_trolls}
			{assign var=monstres value=$map[$num_cell].info_monstres}
			{assign var=tresors value=$map[$num_cell].info_tresors}
			{assign var=champignons value=$map[$num_cell].info_champignons}

			{if ($num_cell mod $row_size) eq 0}<tr>{/if}
			<td>{if $trolls ne ''}<img src="/images/ico_troll_16.png" /><div class="tooltip">{$trolls}</div>{/if}{if $monstres ne ''}<img src="/images/ico_monstre_16.png" /><div class="tooltip">{$monstres}</div>{/if}{if $tresors ne ''}<img src="/images/ico_tresor_16.png" /><div class="tooltip">{$tresors}</div>{/if}{if $champignons ne ''}<img src="/images/ico_champignon_16.png" /><div class="tooltip">{$champignons}</div>{/if}</td>
			{if ($num_cell mod $row_size) eq ($row_size - 1)}</tr>{/if}
		{/section}
	</table>
	
	<script type="text/javascript" src="/js/qTip/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="/js/qTip/jquery.qtip.js"></script>
	<script type="text/javascript">
		{literal}
			$(document).ready(function() {
   				$('img').each(function() {
      				$(this).qtip({
         				content: $(this).next('div.tooltip:first'),
     					show: {
        					solo: true
     					},
     					hide: {
     						delay: 200,
     						fixed: true
     					},
     					style: {
        					padding: '5px 15px',
        					width: '500px'
     					}
					});
   				});
			});
		{/literal}
	</script>
{/if}
{include file='footer.tpl'}