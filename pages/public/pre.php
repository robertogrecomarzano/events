<?php
$upload = new Upload($id, "pubblicazioni", true);
$table = $upload->getListTable(1);
$page->assign("upload", array(
    "table" => $table
));