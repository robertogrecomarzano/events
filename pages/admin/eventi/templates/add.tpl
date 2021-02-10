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
			{form_radio iname='template' writable=$isWritable value='basic' label="<a rel='popover' data-img='{$siteUrl}/public/basic.png'>Base (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='intermediate' label="<a rel='popover' data-img='{$siteUrl}/public/intermediate.png'>Intermedio (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='advanced' label="<a rel='popover' data-img='{$siteUrl}/public/advanced.png'>Avanzato (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='international' label="<a rel='popover' data-img='{$siteUrl}/public/international.png'>International (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='call' label="<a rel='popover' data-img='{$siteUrl}/public/call.png'>Call (en)</a>"}
			{form_radio iname='template' writable=$isWritable value='expert' label="<a rel='popover' data-img='{$siteUrl}/public/expert.png'>Expert (en)</a>"}
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Data<span class="help-block">giorno dell'evento</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_calendar iname='data' writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Inizio<span class="help-block">ora di inizio CET</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='ora_inizio' src=$ore writable=$isWritable}</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-6 col-sm-6 col-xs-12">Fine<span class="help-block">ora di fine CET</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">{form_select iname='ora_fine' src=$ore writable=$isWritable}</div>
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
		<div class="col-md-6 col-sm-6 col-xs-12">{form_check iname='send_zoom_link_on_register' writable=$isWritable}</div>
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