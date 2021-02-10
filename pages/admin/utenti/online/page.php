<?php
$righe = Database::getRows("SELECT u.*,o.*,
 CONCAT(cognome,' ',u.nome) AS utente,
 GROUP_CONCAT(g.nome SEPARATOR ', ') AS gruppo,
 DATE_FORMAT(tm,'%d/%m/%Y %H.%i.%s') AS orario
 FROM utenti u
 JOIN utenti_has_gruppi USING(id_utente)
 JOIN utenti_gruppi g USING(id_gruppo_utente)
 JOIN utenti_online o USING(id_utente)
 WHERE o.status=1 
 GROUP BY u.id_utente ORDER BY tm DESC");
$page->assign("righe", $righe);