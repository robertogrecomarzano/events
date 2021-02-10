<form method="post" class="form-horizontal">
	{$formToken} {form_hidden iname='form_action'} {form_hidden
	iname='form_id'} {foreach from=$fields item=r }

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12">{$r["Field"]|upper|replace:"_":"
			"}</label>
		<div class="col-md-9 col-sm-9 col-xs-12">{if $r["Type"] ==
			"tinyint(1)"} {form_check iname={$r["Field"]} label=' '} {else}
			{form_tbox iname={$r["Field"]} size='40'} {/if}</div>
	</div>
	{/foreach}
	<div class='btn-group'>{form_button iname='conferma'
		onclick="setConfig(this,{$pkValue});" class='btn btn-primary'
		text=true value="{form_lang value='CONFIRM'}"}</div>
</form>