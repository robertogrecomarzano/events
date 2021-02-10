<?php

/**
 * Interface per l'implemenzatione della gestione permessi
 */
interface IPermissions
{

    /**
     * Ritorna true se l'utente è proprietario dell'oggetto
     */
    function isUserOwner();

    /**
     * Ritorna true se l'oggetto risulta visibile
     */
    function isReadable();

    /**
     * Ritorna true se l'oggetto risulta modificabile
     */
    function isWritable($groups);

    /**
     * Ritorna tutti gli oggetti simili
     *
     * @param int $id
     */
    static function getAll($id);
}