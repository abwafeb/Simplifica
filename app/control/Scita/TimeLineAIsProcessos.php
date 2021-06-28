<?php
class TimelineAIsProcessos extends TWindow
{
    
    private $timeline;
    
    public function __construct()
    {
        parent::__construct();
        //parent::removePadding();
        parent::setSize(0.7,0.7);
        parent::setPosition(250,100);
        parent::setTitle('AIs do Processo');
        
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
            $obj = ProcessosAIs::where('SerialProcesso', '=', $param['SerialProcesso'])->load();

            if ($obj){
               $i = 1;   

               foreach ($obj as $object){
               
                      if (!empty($object->InfracaoData)){
                         $dataInfracao = new DateTime($object->InfracaoData);
                         $dataInfracao = $dataInfracao->format('d/m/Y H:i:s');
                      }
                      
                      if (!empty($object->ElaboradoEm)){
                         $ElaboradoEm = new DateTime($object->ElaboradoEm);
                         $ElaboradoEm = $ElaboradoEm->format('d/m/Y H:i:s');
                      }

                      $this->timeline->addItem( $i, $object->processo->Processo.' - '.$object->Acao, '<b>'.'Elaborado por: '.'</b>'.$object->usuarioScita->Nome.'<br>'.
                                                                                                     '<b>'.'Em: '.'</b>'.$ElaboradoEm.'<br>'.
                                                                                                     '<b>'.'Origem Processo: '.'</b>'.$object->ProcessoOrigem.'<br>'.
                                                                                                     '<b>'.'Aeronave: '.'</b>'.$object->Aeronave.'<br>'.
                                                                                                     '<b>'.'Tipo Aeronave: '.'</b>'.$object->AeronaveTipo.'<br><br>'.
                                                                                                     '<b>'.'Descricao Ocorrencia AI: '.'</b>'.$object->DescricaoOcorrenciaAI.'<br><br>'.
                                                                                                     '<b>'.'Enquadramento AI: '.'</b>'.$object->EnquadramentoAI.'<br><br>'.
                                                                                                     '<b>'.'Data Infração: '.'</b>'.$dataInfracao.'<br>'.
                                                                                                     '<b>'.'Local Infracao: '.'</b>'.$object->InfracaoLocal.'<br>'.
                                                                                                     '<b>'.'Ativo: '.'</b>'.($object->Ativo == 1 ? 'Sim' : 'Não')
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