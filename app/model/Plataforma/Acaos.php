<?php
/**
 * Acaos Active Record
 * @author  <your-name-here>
 */
class Acaos extends TRecord
{
    const TABLENAME = 'acaos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at';   
    
    private $solicitante;  
    private $solicitado;
    private $respondente;
    private $processoNumero;
    
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
        parent::addAttribute('title');
        parent::addAttribute('processo');
        parent::addAttribute('solicitacao');
        parent::addAttribute('resposta');
        parent::addAttribute('observacao');
        parent::addAttribute('status');
        parent::addAttribute('tipo');
        parent::addAttribute('dataResposta');
        parent::addAttribute('dataLimite');
        parent::addAttribute('dataLimiteCiencia');
        parent::addAttribute('deleted_at');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('dataCiencia');
        parent::addAttribute('ciente_id');
        parent::addAttribute('processo_id');
        parent::addAttribute('processo_numero');
        parent::addAttribute('opcoes');
        parent::addAttribute('abrangencia');
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

    public function get_processoNumero()
    {
        // loads the associated object
        if (empty($this->processoNumero))
            $this->processoNumero = new Jprocessos($this->processo_id);
    
        // returns the associated object
        return $this->processoNumero;
    }

}
