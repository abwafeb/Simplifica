<?php
/**
 * Jprocessos Active Record
 * @author  <your-name-here>
 */
class Jprocessos extends TRecord
{
    const TABLENAME = 'jprocessos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
      
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at'; 

    private $autuado;
    private $anexos;
    private $notificacaos;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('serial');
        parent::addAttribute('dataLimite');
        parent::addAttribute('hash');
        parent::addAttribute('observacao');
        parent::addAttribute('deleted_at');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('autuado_id');
        parent::addAttribute('sem_cadastro_autuado');
        parent::addAttribute('sem_cadastro_autuado_email');
        parent::addAttribute('processo_numero');
        parent::addAttribute('antigo');
        parent::addAttribute('podeVer');
    }

    public function get_autuado()
    {
        // loads the associated object
        if (empty($this->autuado))
        
            $this->autuado = new users($this->autuado_id);
    
        // returns the associated object
        return $this->autuado;
    }

    public function get_anexos()
    {
        // loads the associated object
        if (empty($this->anexos))
        
            $this->anexos = anexos::where('processo_id', '=', $this->id)
                                  ->load();
    
        // returns the associated object
        return $this->anexos;
    }

    public function get_notificacaos()
    {
        // loads the associated object
        if (empty($this->notificacaos))
        
            $this->notificacaos = notificacaos::where('id_processo', '=', $this->id)
                                  ->load();
    
        // returns the associated object
        return $this->notificacaos;
    }



}
