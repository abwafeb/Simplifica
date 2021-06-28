<?php
/**
 * PAutas Active Record
 * @author  <your-name-here>
 */
class Pautas extends TRecord{
    const TABLENAME = 'Pautas';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $Processo;
    //private $UsuarioSessao;

    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE){

      parent::__construct($Serial, $callObjectLoad);
      parent::addAttribute('Sessao');
      parent::addAttribute('SerialSessao');
      parent::addAttribute('SerialProcesso');
      parent::addAttribute('Relator');
      parent::addAttribute('Membro1');
      parent::addAttribute('Membro2');
      parent::addAttribute('Usuario');
      parent::addAttribute('Data');
      parent::addAttribute('Acao');
      parent::addAttribute('Reconsideracao');
      parent::addAttribute('SerialVoto');
      parent::addAttribute('Decisao');
      parent::addAttribute('Ementa');
      parent::addAttribute('Certidao');
      parent::addAttribute('ATARelator');
      parent::addAttribute('ATARelatorCargo');
      parent::addAttribute('ATAMembro1');
      parent::addAttribute('ATAMembroCargo1');
      parent::addAttribute('ATAMembro2');
      parent::addAttribute('ATAMembroCargo2');
      parent::addAttribute('Assinatura2');
      parent::addAttribute('Cargo2');
      parent::addAttribute('Assinatura3');
      parent::addAttribute('Cargo3');
      parent::addAttribute('CertidaoMembro1');
      parent::addAttribute('CertidaoMembro2');
   }

   public function get_Processo(){
        // loads the associated object
        if (empty($this->Processo))
        
            $this->Processo = new Processos($this->SerialProcesso);
    
        // returns the associated object
        return $this->Processo;
   }
}
