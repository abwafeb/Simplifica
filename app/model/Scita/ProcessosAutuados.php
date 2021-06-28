<?php
/**
 * ProcessosSituacoes Active Record
 * @author  <your-name-here>
 */
class ProcessosAutuados extends TRecord
{
    const TABLENAME = 'ProcessosAutuados';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $usuarioScita;
    
    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE)
    {
       parent::__construct($Serial, $callObjectLoad);
       parent::addAttribute('SerialProcesso');
       parent::addAttribute('Processo');
       parent::addAttribute('Autuado');
       parent::addAttribute('AutuadoCodANAC');
       parent::addAttribute('AutuadoCPFCNPJ');
       parent::addAttribute('AutuadoEndereco');
       parent::addAttribute('AutuadoBairro');
       parent::addAttribute('AutuadoCidade');
       parent::addAttribute('AutuadoUF');
       parent::addAttribute('AutuadoCEP');
       parent::addAttribute('AutuadoPais');
       parent::addAttribute('AutuadoEmail');
       parent::addAttribute('Usuario');
       parent::addAttribute('Data');
       parent::addAttribute('Acao');
    }
    
    public function get_usuarioScita()
    {
        // loads the associated object
        if (empty($this->usuarioScita))
        
            $this->usuarioScita = new Usuarios($this->Usuario);
    
        // returns the associated object
        return $this->usuarioScita;
    }
     
}