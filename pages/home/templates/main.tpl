<div class="row">

	<div class="col-xs-12 col-sm-12">
		<h4 class="blue">
			<span class="middle">{$utente.cognome} {$utente.nome}</span> <span
				class="label label-purple arrowed-in-right"> <i
				class="ace-icon fa fa-circle smaller-80 align-middle"></i> online
			</span>
		</h4>

		<div class="profile-user-info">
			<div class="profile-info-row">
				<div class="profile-info-name">{form_lang value="USERNAME"}</div>

				<div class="profile-info-value">
					<span>{$utente.username}</span>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name">{form_lang value="NATIONALITY"}</div>

				<div class="profile-info-value">
					<i class="fa fa-map-marker light-orange bigger-110"></i> 
						{foreach from=","|explode:$utente.nazionalita item=nazionalita}
							<span>{$nazionalita|nazione}</span>
						{/foreach}
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name">{form_lang value="LOCATION"}</div>

				<div class="profile-info-value">
					<i class="fa fa-map-marker light-orange bigger-110"></i> <span>{$utente.citta|comune}</span>
					<span>{$utente.nazione|nazione}</span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name">{form_lang value="AGE"}</div>

				<div class="profile-info-value">
					<span>{$utente.eta}</span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name">{form_lang value="BIRTH_LOCATION"}</div>

				<div class="profile-info-value">
					<i class="fa fa-map-marker purple bigger-110"></i> <span>{$utente.citta_nascita|comune}</span>
					<span>{$utente.nazione_nascita|nazione}</span>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name">{form_lang value="JOINED"}</div>

				<div class="profile-info-value">
					<span>{$utente.data_create_dmy}</span>
				</div>
			</div>
		</div>

		<div class="hr hr-8 dotted"></div>

		<div class="profile-user-info">
			<div class="profile-info-row">
				<div class="profile-info-name">
					<i class="middle ace-icon fa fa-envelope bigger-150 blue"></i>
				</div>

				<div class="profile-info-value">
					<a href="mailto:{$utente.email}">{$utente.email}</a>
				</div>
			</div>

			<div class="profile-info-row">
				<div class="profile-info-name">
					<i class="middle ace-icon fa fa-phone bigger-150 light-blue"></i>
				</div>

				<div class="profile-info-value">
					{$utente.telefono}
				</div>
			</div>
			
			<div class="profile-info-row">
				<div class="profile-info-name">
					<i class="middle ace-icon fa fa-skype bigger-150 blue"></i>
				</div>

				<div class="profile-info-value">
					<a href="#">{$utente.skype}</a>
				</div>
			</div>
			
			<div class="profile-info-row">
				<div class="profile-info-name">
					<i class="middle ace-icon fa fa-facebook-square bigger-150 blue"></i>
				</div>

				<div class="profile-info-value">
					<a href="#">{$utente.facebook}</a>
				</div>
			</div>
			
			<div class="profile-info-row">
				<div class="profile-info-name">
					<i class="middle ace-icon fa fa-twitter-square bigger-150 blue"></i>
				</div>

				<div class="profile-info-value">
					<a href="#">{$utente.twitter}</a>
				</div>
			</div>
			
			<div class="profile-info-row">
				<div class="profile-info-name">
					<i class="middle ace-icon fa fa-linkedin-square bigger-150 blue"></i>
				</div>

				<div class="profile-info-value">
					<a href="#">{$utente.linkedin}</a>
				</div>
			</div>
			
		</div>
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->