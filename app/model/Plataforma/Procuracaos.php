<?php
/**
 * Procuracaos Active Record
 * @author  <your-name-here>
 */
class Procuracaos extends TRecord
{
    const TABLENAME = 'procuracaos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at'; 
    
    private $autuado;
    private $procurador;
    private $jprocessos;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('hash');
        parent::addAttribute('sem_cadastro_autuado');
        parent::addAttribute('sem_cadastro_procurador');
        parent::addAttribute('anexo_hash');
        parent::addAttribute('anexo_id');
        parent::addAttribute('autuado_id');
        parent::addAttribute('procurador_id');
        parent::addAttribute('processo_id');
        parent::addAttribute('tipo');
        parent::addAttribute('todos');
        parent::addAttribute('verificado');
        parent::addAttribute('validade_inicio');
        parent::addAttribute('validade_final');
        parent::addAttribute('deleted_at');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('requererConceder');
        parent::addAttribute('numero');
        parent::addAttribute('poderes');
        parent::addAttribute('idLogado');
        parent::addAttribute('explicacaoRejeicao');
        parent::addAttribute('idsProibidos');
    }

    public function get_autuado()
    {
        if ( empty($this->autuado))
            $this->autuado = new Users($this->autuado_id);
        return $this->autuado;    
    }

    public function get_procurador()
    {
        if ( empty($this->procurador))
            $this->procurador = new Users($this->procurador_id);
        return $this->procurador;    
    }

    public function get_jprocessos()
    {
        // loads the associated object
        if (empty($this->jprocessos))
            $this->jprocessos = new Jprocessos($this->processo_id);
    
        // returns the associated object
        return $this->jprocessos;
    }
    

}
