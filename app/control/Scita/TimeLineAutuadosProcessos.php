<?php
class TimelineAutuadosProcessos extends TWindow
{
    
    private $timeline;
    
    public function __construct()
    {
        parent::__construct();
        //parent::removePadding();
        parent::setSize(0.9,0.9);
        parent::setPosition(100,50);
        parent::setTitle('Autuado do Processo');
        
        $this->timeline = new TTimeline;
        //$this->timeline->setUseBothSides();
        $this->timeline->setTimeDisplayMask('dd/mm/yyyy');
        $this->timeline->setFinalIcon('fa:flag-checkered bg-red');
        
        //$action1 = new TAction([$this, 'onEdit'],   ['id' => '{id}', 'nome' => '{nome}']);
        //$action2 = new TAction([$this, 'onDelete'], ['id' => '{id}', 'nome' => '{nome}']);
        
        //$action1->setProperty('btn-class', 'btn btn-primary');
        
        //$display_condition = function($object) {
        //    return ($object->tipo == 'ativo');
        //};
        
        //$timeline->addAction($action1, 'Editar',  'fa:edit blue');
        //$timeline->addAction($action2, 'Excluir', 'fa:trash red', $display_condition);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->timeline);
        
        parent::add($container);
        
        //parent::add($this->timeline);
    }
    
    public static function onEdit($param)
    {
        new TMessage('info', 'Ação onEdit: <br> <b> ID </b>: ' .$param['id'] . ' <b> Nome: </b> ' . $param['nome']);
    }
    
    public static function onDelete($param)
    {
        new TMessage('info', 'Ação onDelete: <br> <b> ID </b>: ' .$param['id'] . ' <b> Nome: </b> ' . $param['nome']);
    }
    
    public function onSearch($param)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            $obj = ProcessosAutuados::where('SerialProcesso', '=', $param['SerialProcesso'])->load();

            if ($obj){
               $i = 1;   

               foreach ($obj as $object){
                      $this->timeline->addItem( $i, $object->Processo.' - '.$object->Acao, 'Usuário: '.$object->usuarioScita->Nome.'<br>'.
                                                                                           'Autuado: '.$object->Autuado.'<br>'.
                                                                                           'e-mail Autuado: '.$object->AutuadoEmail.'<br>'.
                                                                                           'ANAC Autuado: '.$object->AutuadoCodANAC.'<br>'.
                                                                                           'CPF/CNPJ Autuado: '.$object->AutuadoCPFCNPJ.'<br>'.
                                                                                           'Endereço Autuado: '.$object->AutuadoEndereco.'<br>'.
                                                                                           'Bairro Autuado: '.$object->AutuadoBairro.'<br>'.
                                                                                           'Cidade Autuado: '.$object->AutuadoCidade.'<br>'.
                                                                                           'UF Autuado: '.$object->AutuadoUF.'<br>'.
                                                                                           'CEP Autuado: '.$object->AutuadoCEP.'<br>'.
                                                                                           'País Autuado: '.$object->AutuadoPais
                                                                                           ,$object->Data, 'fa:check bg-blue', null, $object);
                   ++$i;
               }
               
            }

            TTransaction::close(); // close the transaction
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
            
        //return false;
    }
    
}