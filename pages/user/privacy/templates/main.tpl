<p>
{form_lang value='PRIVACY_DOWNLOAD_LINK'}
{form_link img='download' text=true class='btn btn-danger' value={form_lang value='DOWNLOAD'} href="{$privacy_link}"}
</p>
{form_opening}
{$privacy_html}
{if !empty($privacy_html)}
<div class="btn btn-group">{form_confirm}</div>
{/if}
{form_closing}
{$privacy_html_history}

