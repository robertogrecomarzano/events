{if $action != "mod" && $action != "add"}
{form_opening class="form-horizontal"}
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Evento<span class="help-block">seleziona l'evento per cui vuoi esportare gli iscritti</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='evento' src=$eventi first=true}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12"></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{form_button text=true value='Esporta excel' img='file-excel' onclick="form_esporta(this);" read-allowed=true}
			{form_button text=true value='Elimina iscritti evento' img='trash' onclick="form_delete(this);" class="btn btn-danger" }
		</div>
	</div>
	
	{if !empty($filename)}
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12"></label>
			<div class="col-md-6 col-sm-6 col-xs-12">{form_link img="download" text=true class="btn btn-primary" value="Clicca qui per avviare il download del file" target='_blank' href="{$siteUrl}/core/download.php?t=x&file={$filename}" read-allowed=true}</div>
		</div>
		
	{/if}
{form_closing}
{/if}
{form_table src=$src}