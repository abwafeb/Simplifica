<?php
/**
 * Sessoes Active Record
 * @author  <your-name-here>
 */
class Sessoes extends TRecord{
    const TABLENAME = 'Sessoes';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $Aprovado_por;
    private $UsuarioSessao;

    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE){

      parent::__construct($Serial, $callObjectLoad);
      parent::addAttribute('Sessao');
      parent::addAttribute('SessaoData');
      parent::addAttribute('Tipo');
      parent::addAttribute('Local');
      parent::addAttribute('Presidente');
      parent::addAttribute('Secretario');
      parent::addAttribute('Aprovada');
      parent::addAttribute('AprovadoPor');
      parent::addAttribute('AprovadoEm');
      parent::addAttribute('Usuario');
      parent::addAttribute('Data');
      parent::addAttribute('Acao');
      parent::addAttribute('Sequencial');
      parent::addAttribute('vSessao');
      parent::addAttribute('SessaoDataFim');
      parent::addAttribute('ATAPresidente');
      parent::addAttribute('ATAPresidenteCargo');
      parent::addAttribute('ATASecretario');
      parent::addAttribute('ATASecretarioCargo');
      parent::addAttribute('ATARelator');
      parent::addAttribute('ATARelatorCargo');
      parent::addAttribute('ATAMembro1');
      parent::addAttribute('ATAMembroCargo1');
      parent::addAttribute('ATAMembro2');
      parent::addAttribute('ATAMembroCargo2');
      parent::addAttribute('Assinatura1');
      parent::addAttribute('Cargo1');
      parent::addAttribute('Assinatura2');
      parent::addAttribute('Cargo2');
      parent::addAttribute('Assinatura3');
      parent::addAttribute('Cargo3');
      parent::addAttribute('CertidaoPresidente1');
      parent::addAttribute('CertidaoMembro1frm');
      parent::addAttribute('CertidaoMembro2frm');
      parent::addAttribute('Cidade');
    }
    
    public function get_Aprovado_por(){
        // loads the associated object
        if (empty($this->Aprovado_por))
        
            $this->Aprovado_por = new Usuarios($this->AprovadoPor);
    
        // returns the associated object
        return $this->Aprovado_por;
    
    }
    
    public function get_UsuarioSessao(){
        // loads the associated object
        if (empty($this->UsuarioSessao))
        
            $this->UsuarioSessao = new Usuarios($this->Usuario);
    
        // returns the associated object
        return $this->UsuarioSessao;
    
    }
    
}
