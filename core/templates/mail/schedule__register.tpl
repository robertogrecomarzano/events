<p>
{if $params.event.lingua == "en_US"}
	{if empty($params.event.message)}
		Dear participant,<br />
		thank you for having registered in the "<b>{$params.event.titolo}</b>".<br />
		You will receive soon further information on how to participate to the event.<br />
	{else}
		{$params.event.message}
	{/if}
{if !empty($params.event.contact)}In case of any technical difficulties on accessing please contact {$params.event.contact} at <a style='color: #00589A; text-decoration: none;' href="mail=to:{$params.event.email}">{$params.event.email}</a><br />{/if}
{else}
	{if empty($params.event.message)}
		Gentile partecipante,<br />
		grazie per esserti iscritto all'evento "<b>{$params.event.titolo}</b>".<br />
		Riceverai presto ulteriori informazioni su come partecipare all'evento.<br />
	{else}
		{$params.event.message}
	{/if}
{if !empty($params.event.contact)}In caso di difficoltà tecniche, contattare {$params.event.contact} a <a style='color: #00589A; text-decoration: none;' href="mail=to:{$params.event.email}">{$params.event.email}</a><br />{/if}
{/if}
{if !empty($params.event.greeting_message)}{$params.event.greeting_message}{/if}
</p>
<p>{$params.event.signature}</p>