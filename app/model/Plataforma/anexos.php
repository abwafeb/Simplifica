<?php
/**
 * Anexos Active Record
 * @author  <your-name-here>
 */
class Anexos extends TRecord
{
    const TABLENAME = 'anexos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at'; 
    
    private $jprocessos;
    private $user;
    private $referenciado;
    private $procuracao;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('hash');
        parent::addAttribute('extensao');
        parent::addAttribute('local');
        parent::addAttribute('notificacao_id');
        parent::addAttribute('acao_id');
        parent::addAttribute('processo_id');
        parent::addAttribute('referenciado_id');
        parent::addAttribute('user_id');
        parent::addAttribute('assuntoAnexo');
        parent::addAttribute('descricaoAnexo');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
        parent::addAttribute('internoExterno');
        parent::addAttribute('tipo');
        parent::addAttribute('sem_cadastro_autuado');
        parent::addAttribute('procuracao_id');
        parent::addAttribute('pedidoVistaInteiroTeor');
        parent::addAttribute('inteiroTeor');
        parent::addAttribute('publico');
    }

    
    public function get_jprocessos()
    {
        // loads the associated object
        if (empty($this->jprocessos))
            $this->jprocessos = new Jprocessos($this->processo_id);
    
        // returns the associated object
        return $this->jprocessos;
    }
    
    public function get_user()
    {
        // loads the associated object
        if (empty($this->user))
            $this->user = new users($this->user_id);
    
        // returns the associated object
        return $this->user;
    }
    
    public function get_referenciado()
    {
        // loads the associated object
        if (empty($this->referenciado))
            $this->referenciado = new users($this->referenciado_id);
    
        // returns the associated object
        return $this->referenciado;
    }

    public function get_procuracao()
    {
        // loads the associated object
        if (empty($this->procuracao))
            $this->procuracao = new Procuracaos($this->procuracao_id);
    
        // returns the associated object
        return $this->procuracao;
    }
    

}
