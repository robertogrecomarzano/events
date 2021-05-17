<h3>Dati evento</h3>
	
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Lingua</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_radios iname='lingua' src=["it_IT"=>"In italiano","en_US"=>"In inglese"] inline=true}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Titolo<span class="help-block">il titolo dell'evento</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='titolo' writable=$isWritable cols=80}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Nome<span class="help-block">ammessi solo lettere e numeri (minuscolo, senza spazi)</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='nome' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Descrizione<span class="help-block">max 255 caratteri</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='descrizione' writable=$isWritable max=255}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Modello<span class="help-block">modello di form da usare</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{form_radio iname='template' writable=$isWritable value='basicit' label="<a rel='popover' data-img='{$siteUrl}/public/basicit.png'>Base (it)</a>"}
			{form_radio iname='template' writable=$isWritable value='baseinnovazioneit' label="<a rel='popover' data-img='{$siteUrl}/public/baseinnovazioneit.png'>Base Innovazione (it)</a>"}
			{form_radio iname='template' writable=$isWritable value='basic' label="<a rel='popover' data-img='{$siteUrl}/public/basic.png'>Base (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='intermediate' label="<a rel='popover' data-img='{$siteUrl}/public/intermediate.png'>Intermedio (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='preadvanced' label="<a rel='popover' data-img='{$siteUrl}/public/preadvanced.png'>Pre-Avanzato (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='advanced' label="<a rel='popover' data-img='{$siteUrl}/public/advanced.png'>Avanzato (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='international' label="<a rel='popover' data-img='{$siteUrl}/public/international.png'>International (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='call' label="<a rel='popover' data-img='{$siteUrl}/public/call.png'>Call (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='callfull' label="<a rel='popover' data-img='{$siteUrl}/public/callfull.png'>Call Full (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='expert' label="<a rel='popover' data-img='{$siteUrl}/public/expert.png'>Expert (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='experttwo' label="<a rel='popover' data-img='{$siteUrl}/public/experttwo.png'>Expert two(en)</a>"}
		</div>
	</div>
	<div class="form-group text-danger">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Modalità</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='modalita' src=['singola'=>'Singola sessione', 'multipla'=>'Multi sessione'] writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12 text-danger">Disattiva<span class="help-block">disattivare la registrazione degli utenti</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='is_offline'}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Data di inizio<span class="help-block">giorno di inizio dell'evento</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_calendar iname='data_inizio' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Data di fine<span class="help-block">giorno di fine dell'evento</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_calendar iname='data_fine' writable=$isWritable}</div>
	</div>
	{if $sessioni|count == 0}
	<div id="divOrarioEvento" hidden>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12">Inizio<span class="help-block">ora di inizio CET</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='ora_inizio' src=$ore writable=$isWritable}</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12">Fine<span class="help-block">ora di fine CET</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='ora_fine' src=$ore writable=$isWritable}</div>
		</div>
	</div>
	{/if}
	
	<div ng-app='app'>
	
		<div ng-controller="myPanelSessioni as panel">
			
			{if $sessioni|count>0}
			<div id='divListSessioni'>
			{foreach from=$sessioni item=sessione}
			<div class="row">
				<table>
					<tr id="{$sessione@index+1}">
						<td style="vertical-align:middle;"><button type="button" class="btn btn-danger" onclick="deleteRow('{$sessione@index+1}');"><span class="glyphicon glyphicon-trash"></span>{$sessione@index+1}</button></td>
						<td>
							<div class="form-group">
								<label class="control-label">Titolo della sessione</label>
								<div>{form_tbox iname="sessione_titolo[{$sessione@index+1}]" writable=$isWritable value=$sessione.titolo}</div>
								<label class="control-label">Data sessione</label>
								<div>{form_calendar iname="sessione_data[{$sessione@index+1}]" writable=$isWritable value=$sessione.data_dmy}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Ora di inizio</label>
								<div>{form_select iname="sessione_ora_inizio[{$sessione@index+1}]" src=$ore writable=$isWritable value=$sessione.ora_inizio}</div>
								<label class="control-label">Ora di fine</label>
								<div>{form_select iname="sessione_ora_fine[{$sessione@index+1}]" src=$ore writable=$isWritable value=$sessione.ora_fine}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Link zoom</label>
								<div>{form_tbox iname="sessione_zoom_link[{$sessione@index+1}]" writable=$isWritable value=$sessione.zoom_link size=50}</div>
								<div>
									{if $sessione.zoom_send_link_on_register==1}
										{form_check iname="sessione_zoom_send_link_on_register[{$sessione@index+1}]" writable=$isWritable label='Invia link in fase di registrazione' checked='checked'}
									{else}
										{form_check iname="sessione_zoom_send_link_on_register[{$sessione@index+1}]" writable=$isWritable label='Invia link in fase di registrazione'}
									{/if}
								</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Id zoom</label>
								<div>{form_tbox iname="sessione_zoom_id[{$sessione@index+1}]" writable=$isWritable value=$sessione.zoom_id}</div>
								<label class="control-label">Password zoom</label>
								<div>{form_tbox iname="sessione_zoom_pwd[{$sessione@index+1}]" writable=$isWritable value=$sessione.zoom_link}</div>
								
							</div>
						</td>
		
					</tr>
				</table>

			</div>
			{/foreach}
			
			<div class="row" ng-repeat="item in panel.getRows()">
					<table>
					<tr>
						<td style="vertical-align:middle;"><button type="button" class="btn btn-danger" ng-click="panel.removeRow($index)"><span class="glyphicon glyphicon-trash"></span> (($index+{$sessioni|count}+1))</button></td>
						<td>
							<div class="form-group">
								<label class="control-label">Titolo della sessione</label>
								<div>{form_tbox iname="sessione_titolo[((\$index+{$sessioni|count}+1))]" writable=$isWritable}</div>
								<label class="control-label">Data sessione</label>
								<div>{form_calendar iname="sessione_data[((\$index+{$sessioni|count}+1))]" writable=$isWritable}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Ora di inizio</label>
								<div>{form_select iname="sessione_ora_inizio[((\$index+{$sessioni|count}+1))]" src=$ore writable=$isWritable}</div>
								<label class="control-label">Ora di fine</label>
								<div>{form_select iname="sessione_ora_fine[((\$index+{$sessioni|count}+1))]" src=$ore writable=$isWritable}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Link zoom</label>
								<div>{form_tbox iname="sessione_zoom_link[((\$index+{$sessioni|count}+1))]" writable=$isWritable size=50}</div>
								<div>{form_check iname="sessione_zoom_send_link_on_register[((\$index+{$sessioni|count}+1))]" writable=$isWritable label='Invia link in fase di registrazione'}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Id zoom</label>
								<div>{form_tbox iname="sessione_zoom_id[((\$index+{$sessioni|count}+1))]" writable=$isWritable}</div>
								<label class="control-label">Password zoom</label>
								<div>{form_tbox iname="sessione_zoom_pwd[((\$index+{$sessioni|count}+1))]" writable=$isWritable}</div>
								
							</div>
						</td>
		
					</tr>
				</table>
			</div>
			
			<!--  button type="button" class="btn btn-success" ng-click="panel.addrow()"> <span class="glyphicon glyphicon-plus-sign"></span> Aggiungi sessione</button-->
			{else}
			<div id='divListSessioni' hidden>
			<div class="row" ng-repeat="item in panel.getRows()">
				<table>
					<tr>
						<td style="vertical-align:middle;"><button type="button" class="btn btn-danger" ng-click="panel.removeRow($index)"><span class="glyphicon glyphicon-trash"></span></button> (($index+1))</td>
						<td>
							<div class="form-group">
								<label class="control-label">Titolo della sessione</label>
								<div>{form_tbox iname="sessione_titolo[((\$index+1))]" writable=$isWritable}</div>
								<label class="control-label">Data sessione</label>
								<div>{form_calendar iname="sessione_data[((\$index+1))]" writable=$isWritable}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Ora di inizio</label>
								<div>{form_select iname="sessione_ora_inizio[((\$index+1))]" src=$ore writable=$isWritable}</div>
								<label class="control-label">Ora di fine</label>
								<div>{form_select iname="sessione_ora_fine[((\$index+1))]" src=$ore writable=$isWritable}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Link zoom</label>
								<div>{form_tbox iname="sessione_zoom_link[((\$index+1))]" writable=$isWritable size=50}</div>
								<div>{form_check iname="sessione_zoom_send_link_on_register[((\$index+1))]" writable=$isWritable label='Invia link in fase di registrazione'}</div>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="control-label">Id zoom</label>
								<div>{form_tbox iname="sessione_zoom_id[((\$index+1))]" writable=$isWritable}</div>
								<label class="control-label">Password zoom</label>
								<div>{form_tbox iname="sessione_zoom_pwd[((\$index+1))]" writable=$isWritable}</div>
								
							</div>
						</td>
		
					</tr>
				</table>
			</div>
			
			{/if}
		</div>
		<button id='btnAddSession' style="display:none;" type="button" class="btn btn-success" ng-click="panel.addrow()"> <span class="glyphicon glyphicon-plus-sign"></span> Aggiungi una sessione</button>
		</div>
	</div>
	
	
	
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Email<span class="help-block">da utilizzare per le comunicazioni</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='email' writable=$isWritable size=40}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Sito web<span class="help-block">se presente</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='website' writable=$isWritable size=40}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Mostra sito web nella mail</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='show_website_mail' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Immagine<span class="help-block">formato jpg, jpeg, png (max 150x150 px)</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{$file}
		{if !empty($immagine)}<img src="{$immagine}" width="150px" style="margin: 6px"/>{/if}
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Mostra logo progetto nel form</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='show_logo' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Mostra logo CIHEAM nel form</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='show_logo_ciheam' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Mostra logo progetto nella mail</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='show_logo_mail' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Mostra logo CIHEAM nella mail</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='show_logo_ciheam_mail' writable=$isWritable}</div>
	</div>
<hr />
<div id="divZoom">
	<h3>Dati di accesso Zoom</h3>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12">Link<span class="help-block">link del meeting Zoom</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='zoom_link' writable=$isWritable}</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12">Id<span class="help-block">identificativo del meeting Zoom</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='zoom_id' writable=$isWritable}</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12">Password<span class="help-block">password del meeting Zoom</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='zoom_pwd' writable=$isWritable}</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-6 col-sm-6 col-xs-12">Invia link subito<span class="help-block">invia il link zoom già in fase di registrazione</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='zoom_send_link_on_register' writable=$isWritable}</div>
		</div>
	</div>
	
	<hr />
	<h3>Contatto, firma e messaggio di ringraziamento</h3>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Contatto<span class="help-block">referente da inserire nella mail</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='contact' writable=$isWritable size=60}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Firma<span class="help-block">testo con cui firmare il messaggio</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='signature' writable=$isWritable size=60}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Oggetto<span class="help-block">se differente dal titolo</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_tbox iname='subject' writable=$isWritable size=60}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Testo della mail (facoltativo)<span class="block text-danger">Se indicato, verrà usato come corpo della <b>mail</b></span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='message' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Ringraziamento<span class="help-block">messaggio di ringraziamento</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='greeting_message' writable=$isWritable}</div>
	</div>
<hr />
<h3>Informativa sulla privacy</h3>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">File privacy<span class="help-block">informativa in formato pdf</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{$fileprivacy}
		{if !empty($pdf)}{form_link href=$pdf value="Informativa sulla privacy" target='_blanck' text=true img='file-pdf-o' class="btn btn-danger btn-xs"}{/if}
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Registrazione video</label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_area iname='privacy_registrazione_video' writable=$isWritable}</div>
	</div>
<div class='btn-group'>{form_add_edit type='button' onclick="form_insert(this);"}</div>