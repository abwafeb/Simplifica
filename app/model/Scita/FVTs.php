<?php
/**
 * FVTs Active Record
 * @author  <your-name-here>
 */
class FVTs extends TRecord{
    const TABLENAME = 'FVTs';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $Processo;

    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE){
      parent::__construct($Serial, $callObjectLoad);
      parent::addAttribute('SerialProcesso');
      parent::addAttribute('Numero');
      parent::addAttribute('Pergunta');
      parent::addAttribute('Instruido');
      parent::addAttribute('FolhaInicial');
      parent::addAttribute('FolhaFinal');
    }
    
    public function get_Processo(){
        // loads the associated object
        if (empty($this->Processo))
        
            $this->Processo = new Processos($this->SerialProcesso);
    
        // returns the associated object
        return $this->Processo;
    
    }
    
}

