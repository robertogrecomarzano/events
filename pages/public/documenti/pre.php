<?php
$upload = new Upload($id, "pubblicazioni", true);
$uploadform = $upload->formUpload();
$upload->save();
$upload->processAction();
$fields = array(
    "descrizione" => "Descrizione",
    "orario" => "Data invio"
);
$table = $upload->getListTable(1, $fields);
$page->assign("upload", array(
    "form" => $uploadform,
    "table" => $table
));