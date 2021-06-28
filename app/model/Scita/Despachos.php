<?php
/**
 * Despachos Active Record
 * @author  <your-name-here>
 */
class Despachos extends TRecord{
    const TABLENAME = 'Despachos';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $Processo;
    private $Usuario;

    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE){
      parent::__construct($Serial, $callObjectLoad);
      parent::addAttribute('Numero');
      parent::addAttribute('SerialProcesso');
      parent::addAttribute('ElaboradoEm');
      parent::addAttribute('ElaboradoPor');
      parent::addAttribute('Despacho');
      parent::addAttribute('Data');
      parent::addAttribute('Acao');
   }

    public function get_Processo(){
        // loads the associated object
        if (empty($this->Processo))
        
            $this->Processo = new Processos($this->SerialProcesso);
    
        // returns the associated object
        return $this->Processo;
    
    }

    public function get_Usuario(){
        // loads the associated object
        if (empty($this->Usuario))
        
            $this->Usuario = new Usuarios($this->ElaboradoPor);
    
        // returns the associated object
        return $this->Usuario;
    
    }
   
}
