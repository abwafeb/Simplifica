<?php
/**
 * Acaos Active Record
 * @author  <your-name-here>
 */
class Situacoes extends TRecord
{
    const TABLENAME = 'Situacoes';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($Serial, $callObjectLoad);
        parent::addAttribute('Situacao');
        parent::addAttribute('Ordem');
        parent::addAttribute('Red');
    }
}