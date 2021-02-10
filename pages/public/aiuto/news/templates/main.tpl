{if count($righe)>0} {foreach from=$righe item=r key=k}


<div class="well chat-body clearfix">
	<div class="header">
		<strong class="primary-font">{$r.titolo}</strong> <small
			class="pull-right text-muted text-right"> <i
			class="fas fa-clock fa-fw"></i> {$r.dal_dmy}<br />{$r.al_dmy}
		</small>
	</div>
	<p>{$r.descrizione_lunga}</p>
</div>
{/foreach} {else}
<div class="alert alert-warning">Nessuna news al momento disponibile</div>
{/if}
