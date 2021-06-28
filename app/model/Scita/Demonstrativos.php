<?php
/**
 * FVTs Active Record
 * @author  <your-name-here>
 */
class Demonstrativos extends TRecord{
    const TABLENAME = 'Demonstrativos';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE){
      parent::__construct($Serial, $callObjectLoad);
      parent::addAttribute('Serial');
      parent::addAttribute('Ano');
      parent::addAttribute('Mes');
      parent::addAttribute('MesAnoExtenso');
      parent::addAttribute('ObsDR');
      parent::addAttribute('GRN');
      parent::addAttribute('ObsDRA');
      parent::addAttribute('Responsavel');
      parent::addAttribute('ACI');
      parent::addAttribute('OD');
      parent::addAttribute('GestorFinancas');
      parent::addAttribute('DataDR');
      parent::addAttribute('DataDRA');
      parent::addAttribute('DataGRN');
      parent::addAttribute('ContaUnica');
    }
    
}


