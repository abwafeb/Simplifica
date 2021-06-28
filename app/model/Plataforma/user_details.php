<?php
/**
 * UserDetails Active Record
 * @author  <your-name-here>
 */
class user_details extends TRecord
{
    const TABLENAME = 'user_details';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at'; 
   
    
    private $users;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('user_id');
        parent::addAttribute('CPF');
        parent::addAttribute('identidade');
        parent::addAttribute('identidade_orgao_emissor');
        parent::addAttribute('CEP');
        parent::addAttribute('pais');
        parent::addAttribute('unidade_federativa');
        parent::addAttribute('cidade');
        parent::addAttribute('bairro');
        parent::addAttribute('logradouro');
        parent::addAttribute('complemento');
        parent::addAttribute('numero');
        parent::addAttribute('telefone_1');
        parent::addAttribute('telefone_2');
        parent::addAttribute('telefone_3');
        parent::addAttribute('observacaoRole');
        parent::addAttribute('observacao');
        parent::addAttribute('concordancia');
        parent::addAttribute('foto_identidade');
        parent::addAttribute('foto_estatuto_social');
        parent::addAttribute('registro_comercial');
        parent::addAttribute('role');
        parent::addAttribute('explicacaoRejeitado');
        parent::addAttribute('rejeitado');
        parent::addAttribute('deleted_at');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
    }

    

}
