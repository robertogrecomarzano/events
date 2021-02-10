<?php
$sql = "SELECT l.*,
		DATE_FORMAT(l.timestamp,'%d/%m/%y %H:%i:%s') AS orario,
		DATE_FORMAT(l.data,'%d/%m/%y') AS data,
		IF(sesso!='0',sesso,'') AS sesso,
		IF(eta_min>0,eta_min,'') AS eta_min,
		IF(eta_max>0,eta_max,'') AS eta_max,
		IF(sau_min>0,sau_min,'') AS sau_min,
		IF(sau_max>0,sau_max,'') AS sau_max,
		IF(is_vendita,'X','') AS is_vendita,
		g.descrizione AS gruppo
		FROM focus_log l LEFT JOIN focus_gruppi_log g ON g.tabella = tabella_gruppi
		ORDER BY l.timestamp DESC";

$rows = Database::getRows($sql);
$template = $pagina->getTemplateServerPath("tabella");
$pagina->tpl->setCompileDir($pagina->getTemplateCompileDir());
$pagina->tpl->assign("righe", $rows);
return $pagina->tpl->display($template);