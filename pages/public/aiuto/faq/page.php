<?php
$rows = Database::getRows("SELECT * FROM faq");
$page->assign("faq", $rows);