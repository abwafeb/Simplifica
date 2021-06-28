<?php
/**
 * ProcessosSituacoes Active Record
 * @author  <your-name-here>
 */
class ProcessosSituacoes extends TRecord
{
    const TABLENAME = 'ProcessosSituacoes';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $usuarioScita;
    private $situacaoScita;
    private $processoScita;
    
    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE)
    {
       parent::__construct($Serial, $callObjectLoad);
       parent::addAttribute('SerialProcesso');
       parent::addAttribute('SerialSituacao');
       parent::addAttribute('SituacaoData');
       parent::addAttribute('Justificativa');
       parent::addAttribute('Usuario');
       parent::addAttribute('Data');
       parent::addAttribute('Acao');
       parent::addAttribute('JulgadoJJ');
       parent::addAttribute('JulgadoJR');
       parent::addAttribute('AIEmitido');
       parent::addAttribute('ValorMulta');
       parent::addAttribute('SessaoPlenaria');
       parent::addAttribute('Relator');
       parent::addAttribute('Reconsideracao');
    }
    
    public function get_usuarioScita()
    {
        // loads the associated object
        if (empty($this->usuarioScita))
        
            $this->usuarioScita = new Usuarios($this->Usuario);
    
        // returns the associated object
        return $this->usuarioScita;
    }
     
    public function get_situacaoScita()
    {
        // loads the associated object
        if (empty($this->situacaoScita))
        
            $this->situacaoScita = new Situacoes($this->SerialSituacao);
    
        // returns the associated object
        return $this->situacaoScita;
    }
     
    public function get_processoScita()
    {
        // loads the associated object
        if (empty($this->processoScita))
        
            $this->processoScita = new Processos($this->SerialProcesso);
    
        // returns the associated object
        return $this->processoScita;
    }
     
}