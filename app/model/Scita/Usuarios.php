<?php
/**
 * Users Active Record
 * @author  <your-name-here>
 */
class Usuarios extends TRecord
{
    const TABLENAME = 'Usuarios';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
   
    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($Serial, $callObjectLoad);
        parent::addAttribute('CPF');
        parent::addAttribute('Nome');
        parent::addAttribute('Login');
        parent::addAttribute('Senha');
        parent::addAttribute('Email');
        parent::addAttribute('SerialPerfil');
        parent::addAttribute('Telefone');
        parent::addAttribute('Bloqueado');
        parent::addAttribute('UltimoLogin');
        parent::addAttribute('IP');
        parent::addAttribute('Aprovador');
        parent::addAttribute('Posto');
    }


}

