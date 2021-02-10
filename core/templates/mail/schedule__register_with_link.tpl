<p>
{if $params.event.lingua == "en_US"}
Dear participant,<br />
thank you very much for having registered in the "<b>{$params.event.titolo}</b>".<br />
You may access the meeting <b>{$params.event.titolo}</b> with the following link.<br />
Topic:  {$params.event.titolo}<br />
Date: {$params.event.data_dmy} {$params.event.ora_inizio} - {$params.event.ora_fine} CET<br />
Meeting link: <a href="{$link}">{$params.event.zoom_link}</a><br />
Meeting ID: {$params.event.zoom_id}<br />
Meeting Passcode: {$params.event.zoom_pwd}<br /><br />
{if !empty($params.event.contact)}In case of problems on accessing please contact {$params.event.contact} at <a style='color: #00589A; text-decoration: none;' href="mail=to:{$params.event.email}">{$params.event.email}</a><br />{/if}
{else}
Gentile participante,<br />
grazie per esserti iscritto all'evento "<b>{$params.event.titolo}</b>".<br />
Puoi accedere all'evento <b>{$params.event.titolo}</b> usando il seguente link.<br />
Argomento:  {$params.event.titolo}<br />
Data: {$params.event.data_dmy} {$params.event.ora_inizio} - {$params.event.ora_fine} CET<br />
Link evento: <a href="{$link}">{$params.event.zoom_link}</a><br />
ID evento: {$params.event.zoom_id}<br />
Password evento: {$params.event.zoom_pwd}<br /><br />
{if !empty($params.event.contact)}In caso di difficoltà tecniche, contattare {$params.event.contact} a <a style='color: #00589A; text-decoration: none;' href="mail=to:{$params.event.email}">{$params.event.email}</a><br />{/if}
{/if}
{if !empty($params.event.greeting_message)}{$params.event.greeting_message}<br /><br />{/if}
{$params.event.signature}
</p>