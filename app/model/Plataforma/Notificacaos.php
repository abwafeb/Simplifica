<?php
/**
 * Notificacaos Active Record
 * @author  <your-name-here>
 */
class Notificacaos extends TRecord
{
    const TABLENAME = 'notificacaos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $solicitante;
    private $solicitado;
    private $respondente;
    private $processo;
    private $notificacao_origem;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('hash');
        parent::addAttribute('id_solicitante');
        parent::addAttribute('id_solicitado');
        parent::addAttribute('id_respondente');
        parent::addAttribute('id_processo');
        parent::addAttribute('id_notificacao_origem');
        parent::addAttribute('assunto');
        parent::addAttribute('notificacao');
        parent::addAttribute('resposta');
        parent::addAttribute('dataEnvio');
        parent::addAttribute('dataLeitura');
        parent::addAttribute('dataResposta');
        parent::addAttribute('status');
        parent::addAttribute('dataLimiteLeitura');
        parent::addAttribute('dataLimiteResposta');
        parent::addAttribute('observacao');
        parent::addAttribute('deleted_at');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
    }
    
    public function get_solicitante()
    {
        // loads the associated object
        if (empty($this->solicitante))
            $this->solicitante = new users($this->id_solicitante);
    
        // returns the associated object
        return $this->solicitante;
    }
    
    public function get_solicitado()
    {
        // loads the associated object
        if (empty($this->solicitado))
            $this->solicitado = new users($this->id_solicitado);
    
        // returns the associated object
        return $this->solicitado;
    }
    
    public function get_respondente()
    {
        // loads the associated object
        if (empty($this->respondente))
            $this->respondente = new users($this->id_respondente);
    
        // returns the associated object
        return $this->respondente;
    }
    
    public function get_processo()
    {
        // loads the associated object
        if (empty($this->processo))
            $this->processo = new Jprocessos($this->id_processo);
    
        // returns the associated object
        return $this->processo;
    }
    

}
