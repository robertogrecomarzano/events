{if $modal} {form_hidden iname="modal" value=$modal}
<style>
.modal  a {
	color: #fcf8e3;
}

#myModal .modal-dialog .modal-content {
	background-color: #fcf8e3 !important;
}
</style>
<div id="myModal" class="modal fade" role="dialog" hidden>
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title text-center text-warning">Warning</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<p class='text text-warning'>{form_lang value='UPLOAD_YOUR_PHOTO'}</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
{/if} {form_opening id='userform'}
<div class="row">
	<div class="col-lg-4 col-md-4">
		<div class="panel-heading">
			<h3>{form_lang value="USER_DATA"}</h3>
		</div>
		<div class="panel-body">
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-user'></i></span>{form_tbox
				iname='cognome' size=30 max=45 placeholder={form_lang
				value="SURNAME"} required=""}
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-user'></i></span>{form_tbox
				iname='nome' size=30 max=45 placeholder={form_lang value="NAME"}
				required=""}
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-at'></i></span>{form_tbox
				iname='email' size=30 max=45 placeholder={form_lang
				value="EMAIL_ADDRESS"} type='email' required="email"}
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-key'></i></span>{form_tbox
				iname='password' size=20 max=45 placeholder={form_lang
				value="NEW_PASSWORD"} type='password' autocomplete="new-password"}
			</div>
			<div class="form-group input-group">
				<span class="input-group-addon"><i class='fas fa-key'></i></span>{form_tbox
				iname='password2' size=20 max=45 placeholder={form_lang
				value="PASSWORD_CONFIRM"} type='password' }
			</div>
			<label class='text text-info'>{form_lang value="PASSWORD_FORMAT"}</label>
			<ul>
				<li class='text text-info'><small>{form_lang
						value="PASSWORD_FORMAT_ONE_NUMBER"}</small></li>
				<li class='text text-info'><small>{form_lang
						value="PASSWORD_FORMAT_ONE_CHAR_LOWER"}</small></li>
				<li class='text text-info'><small>{form_lang
						value="PASSWORD_FORMAT_ONE_CHAR_UPPER"}</small></li>
				<li class='text text-info'><small>{form_lang
						value="PASSWORD_FORMAT_ONE_CHAR_BETWEEN"}</small></li>
				<li class='text text-info'><small>{form_lang
						value="PASSWORD_FORMAT_ONE_CHAR_LENGTH"}</small></li>
			</ul>
		</div>
	</div>

</div>
<div class="btn btn-group">{form_button name="signup" img='save'	text=true value={form_lang value='CONFIRM'} onclick='return	Check(this);' class='btn btn-primary'}</div>
{form_closing}
