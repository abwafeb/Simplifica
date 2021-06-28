<?php
/**
 * ProcessosSituacoes Active Record
 * @author  <your-name-here>
 */
class ProcessosAIs extends TRecord
{
    const TABLENAME = 'ProcessosAIs';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $usuarioScita;
    private $processo;
    
    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE)
    {
       parent::__construct($Serial, $callObjectLoad);
       parent::addAttribute('Numero');
       parent::addAttribute('SerialProcesso');
       parent::addAttribute('SerialProcessosAutuados');
       parent::addAttribute('ElaboradoEm');
       parent::addAttribute('ElaboradoPor');
       parent::addAttribute('ProcessoOrigem');
       parent::addAttribute('Aeronave');
       parent::addAttribute('AeronaveTipo');
       parent::addAttribute('DescricaoOcorrenciaAI');
       parent::addAttribute('EnquadramentoAI');
       parent::addAttribute('InfracaoData');
       parent::addAttribute('InfracaoLocal');
       parent::addAttribute('AutuadoEndereco');
       parent::addAttribute('AutuadoBairro');
       parent::addAttribute('AutuadoCidade');
       parent::addAttribute('AutuadoUF');
       parent::addAttribute('AutuadoCEP');
       parent::addAttribute('AutuadoPais');
       parent::addAttribute('Data');
       parent::addAttribute('Acao');
       parent::addAttribute('Ativo');
    }
    
    public function get_usuarioScita()
    {
        // loads the associated object
        if (empty($this->usuarioScita))
        
            $this->usuarioScita = new Usuarios($this->ElaboradoPor);
    
        // returns the associated object
        return $this->usuarioScita;
    }
    
    public function get_processo()
    {
        // loads the associated object
        if (empty($this->processo))
        
            $this->processo = new Processos($this->SerialProcesso);
    
        // returns the associated object
        return $this->processo;
    }
     
     
}