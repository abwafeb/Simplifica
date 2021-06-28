<?php
/**
 * UsersList Listing
 * @author  <your name here>
 */
class ProcessosList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Processos');
        $this->form->setFormTitle('Processos SCITA');
        
        $this->form->addExpandButton();
        
        // create the form fields
        $Processo = new TEntry('Processo');
        $ProcessoOrigem = new TEntry('ProcessoOrigem');
        $OficioOrigem = new TEntry('OficioOrigem');
        $ProcessoData = new TDate('ProcessoData');
        $Autuado = new TEntry('Autuado');
        $EmpresaAerea = new TEntry('EmpresaAerea');

        // add the fields
        $this->form->addFields( [ new TLabel('Nº processo') ], [ $Processo ] );
        $this->form->addFields( [ new TLabel('Origem processo') ], [ $ProcessoOrigem ] );
        $this->form->addFields( [ new TLabel('Origem ofício') ], [ $OficioOrigem ] );
        $this->form->addFields( [ new TLabel('Data processo') ], [ $ProcessoData ] );
        $this->form->addFields( [ new TLabel('Autuado') ], [ $Autuado ] );
        $this->form->addFields( [ new TLabel('Empresa aérea') ], [ $EmpresaAerea ] );

        // set sizes
        $Processo->setSize('100%');
        $ProcessoOrigem->setSize('100%');
        $OficioOrigem->setSize('100%');
        $ProcessoData->setSize('100%');
        $ProcessoData->setMask('dd/mm/yyyy');
        $ProcessoData->setDatabaseMask('dd/mm/yyyy');
//        $ProcessoData->setDatabaseMask('yyyy-mm-dd');
        $Autuado->setSize('100%');
        $EmpresaAerea->setSize('100%');
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';

        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->disableDefaultClick();
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_Processo = new TDataGridColumn('Processo', 'Nº processo', 'right');
        $column_ProcessoOrigem = new TDataGridColumn('ProcessoOrigem', 'Origem processo', 'left');
        $column_ProcessoData = new TDataGridColumn('ProcessoData', 'Data processo', 'left');
        $column_Oficio = new TDataGridColumn('Oficio', 'Nº ofício', 'right');
        $column_OficioOrigem = new TDataGridColumn('OficioOrigem', 'Origem ofício', 'left');
        $column_OficioData = new TDataGridColumn('OficioData', 'Data ofício', 'left');
        $column_Protocolo = new TDataGridColumn('Protocolo', 'Protocolo', 'right');
        $column_ProtocoloData = new TDataGridColumn('ProtocoloData', 'Data protocolo', 'left');
        $column_MsgITA = new TDataGridColumn('MsgITA', 'Msg ITA', 'right');
        $column_MsgITAData = new TDataGridColumn('MsgITAData', 'Data Msg ITA', 'left');
        $column_FCI = new TDataGridColumn('FCI', 'FCI', 'right');
        $column_FCIOrigem = new TDataGridColumn('FCIOrigem', 'Origem FCI', 'left');
        $column_FCIData = new TDataGridColumn('FCIData', 'Data FCI', 'left');
        $column_Autuado = new TDataGridColumn('Autuado', 'Autuado', 'left');
        $column_AutuadoCodANAC = new TDataGridColumn('AutuadoCodANAC', 'Cod ANAC autuado', 'right');
        $column_AutuadoCPFCNPJ = new TDataGridColumn('AutuadoCPFCNPJ', 'CPF/CNPJ autuado', 'left');
        $column_AutuadoEndereco = new TDataGridColumn('AutuadoEndereco', 'Endereço autuado', 'left');
        $column_AutuadoBairro = new TDataGridColumn('AutuadoBairro', 'Bairro autuado', 'left');
        $column_AutuadoCidade = new TDataGridColumn('AutuadoCidade', 'Cidade autuado', 'left');
        $column_AutuadoUF = new TDataGridColumn('AutuadoUF', 'UF autuado', 'left');
        $column_AutuadoCEP = new TDataGridColumn('AutuadoCEP', 'CEP autuado', 'left');
        $column_AutuadoPais = new TDataGridColumn('AutuadoPais', 'Pais autuado', 'left');
        $column_AutuadoEmail = new TDataGridColumn('AutuadoEmail', 'E-mail autuado', 'left');
        $column_EmpresaAerea = new TDataGridColumn('EmpresaAerea', 'Empresa aérea', 'left');
        $column_Aeronave = new TDataGridColumn('Aeronave', 'Aeronave', 'left');
        $column_AeronaveTipo = new TDataGridColumn('AeronaveTipo', 'Tipo aeronave', 'left');
        $column_TipoInfracao = new TDataGridColumn('TipoInfracao', 'Tipo infração', 'left');
        $column_Infracao = new TDataGridColumn('Infracao', 'Infração', 'left');
        $column_InfracaoData = new TDataGridColumn('InfracaoData', 'Data infração', 'left');
        $column_InfracaoLocal = new TDataGridColumn('InfracaoLocal', 'Local infração', 'left');
        $column_AerodromoPartida = new TDataGridColumn('AerodromoPartida', 'Aerodromo partida', 'left');
        $column_AerodromoDestino = new TDataGridColumn('AerodromoDestino', 'Aerodromo destino', 'left');
        $column_OrgaoInformante = new TDataGridColumn('OrgaoInformante', 'Orgão informante', 'left');
        $column_NivelVooRota = new TDataGridColumn('NivelVooRota', 'Nivel de voo e rota', 'left');
        $column_Meteoro = new TDataGridColumn('Meteoro', 'Meteoro', 'left');
        $column_SerialSituacao = new TDataGridColumn('Situacao->Situacao', 'Situação', 'left');
        $column_SituacaoData = new TDataGridColumn('SituacaoData', 'Data situação', 'left');

        $column_ProcessoData->setTransformer( function ($ProcessoData, $object, $row){
            if (!empty($ProcessoData)){
                $date = new DateTime($ProcessoData);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_OficioData->setTransformer( function ($OficioData, $object, $row){
            if (!empty($OficioData)){
                $date = new DateTime($OficioData);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_ProtocoloData->setTransformer( function ($ProtocoloData, $object, $row){
            if (!empty($ProtocoloData)){
                $date = new DateTime($ProtocoloData);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_MsgITAData->setTransformer( function ($MsgITAData, $object, $row){
            if (!empty($MsgITAData)){
                $date = new DateTime($MsgITAData);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_FCIData->setTransformer( function ($FCIData, $object, $row){
            if (!empty($FCIData)){
                $date = new DateTime($FCIData);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_InfracaoData->setTransformer( function ($InfracaoData, $object, $row){
            if (!empty($InfracaoData)){
                $date = new DateTime($InfracaoData);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_SituacaoData->setTransformer( function ($SituacaoData, $object, $row){
            if (!empty($SituacaoData)){
                $date = new DateTime($SituacaoData);
                return $date->format('d/m/Y H:i:s');
            }
        });


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_Processo);
        $this->datagrid->addColumn($column_ProcessoOrigem);
        $this->datagrid->addColumn($column_ProcessoData);
        $this->datagrid->addColumn($column_Oficio);
        $this->datagrid->addColumn($column_OficioOrigem);
        $this->datagrid->addColumn($column_OficioData);
        $this->datagrid->addColumn($column_Protocolo);
        $this->datagrid->addColumn($column_ProtocoloData);
        $this->datagrid->addColumn($column_MsgITA);
        $this->datagrid->addColumn($column_MsgITAData);
        $this->datagrid->addColumn($column_FCI);
        $this->datagrid->addColumn($column_FCIOrigem);
        $this->datagrid->addColumn($column_FCIData);
        $this->datagrid->addColumn($column_Autuado);
        $this->datagrid->addColumn($column_AutuadoCodANAC);
        $this->datagrid->addColumn($column_AutuadoCPFCNPJ);
        $this->datagrid->addColumn($column_AutuadoEndereco);
        $this->datagrid->addColumn($column_AutuadoBairro);
        $this->datagrid->addColumn($column_AutuadoCidade);
        $this->datagrid->addColumn($column_AutuadoUF);
        $this->datagrid->addColumn($column_AutuadoCEP);
        $this->datagrid->addColumn($column_AutuadoPais);
        $this->datagrid->addColumn($column_AutuadoEmail);
        $this->datagrid->addColumn($column_EmpresaAerea);
        $this->datagrid->addColumn($column_Aeronave);
        $this->datagrid->addColumn($column_AeronaveTipo);
        $this->datagrid->addColumn($column_TipoInfracao);
        $this->datagrid->addColumn($column_Infracao);
        $this->datagrid->addColumn($column_InfracaoData);
        $this->datagrid->addColumn($column_InfracaoLocal); 
        $this->datagrid->addColumn($column_AerodromoPartida);
        $this->datagrid->addColumn($column_AerodromoDestino);
        $this->datagrid->addColumn($column_OrgaoInformante);
        $this->datagrid->addColumn($column_NivelVooRota);
        $this->datagrid->addColumn($column_Meteoro);
        $this->datagrid->addColumn($column_SerialSituacao);
        $this->datagrid->addColumn($column_SituacaoData);

        $action1 = new TDataGridAction(['TimelineSituacoesProcessos', 'onSearch'], ['SerialProcesso'=>'{Serial}', 'register_state' => 'false']);
        $action1->setDisplayCondition([$this,'displaySituacoesProcesso']);
        
        $action1->setLabel('Situações');
        $action1->setImage('fa:copy blue');
        //$this->datagrid->addAction($action1, 'Situações',   'fa:copy blue');
        
        $action2 = new TDataGridAction(['TimelineAutuadosProcessos', 'onSearch'], ['SerialProcesso'=>'{Serial}', 'register_state' => 'false']);
        $action2->setDisplayCondition([$this,'displayAutuadosProcesso']);
        
        $action2->setLabel('Autuados');
        $action2->setImage('fa:hand-paper red');
        //$this->datagrid->addAction($action2, 'Autuados',   'fa:hand-paper red');

        $action3 = new TDataGridAction(['TimelineAIsProcessos', 'onSearch'], ['SerialProcesso'=>'{Serial}', 'register_state' => 'false']);
        $action3->setDisplayCondition([$this,'displayAIsProcesso']);
        
        $action3->setLabel('AIs');
        $action3->setImage('fa:bell brown');
        //$this->datagrid->addAction($action3, 'AIs',   'fa:bell brown');

        $action4 = new TDataGridAction(['FVTsFormView', 'FVTs'], ['SerialProcesso'=>'{Serial}', 'register_state' => 'false']);
        $action4->setDisplayCondition([$this,'displayFVTs']);
        
        $action4->setLabel('FVT');
        $action4->setImage('fa:file brown');
        //$this->datagrid->addAction($action4, 'AIs',   'fa:bell brown');

        $action_group = new TDataGridActionGroup('Ações','fa:th');
        $action_group->addAction($action1);
        $action_group->addAction($action2);
        $action_group->addAction($action3);
        $action_group->addAction($action4);
        
        $this->datagrid->addActionGroup($action_group);

        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    public function FVTs(){
    }
    
    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue(__CLASS__.'_filter_Processo',   NULL);
        TSession::setValue(__CLASS__.'_filter_ProcessoOrigem',   NULL);
        TSession::setValue(__CLASS__.'_filter_OficioOrigem',   NULL);
        TSession::setValue(__CLASS__.'_filter_ProcessoData',   NULL);
        TSession::setValue(__CLASS__.'_filter_Autuado',   NULL);
        TSession::setValue(__CLASS__.'_filter_EmpresaAerea',   NULL);

        if (isset($data->Processo) AND ($data->Processo)) {
            $filter = new TFilter('Processo', 'like', "%{$data->Processo}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_Processo',   $filter); // stores the filter in the session
        }


        if (isset($data->ProcessoOrigem) AND ($data->ProcessoOrigem)) {
            $filter = new TFilter('ProcessoOrigem', 'like', "%{$data->ProcessoOrigem}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_ProcessoOrigem',   $filter); // stores the filter in the session
        }

        if (isset($data->OficioOrigem) AND ($data->OficioOrigem)) {
            $filter = new TFilter('ProcessoOrigem', 'like', "%{$data->OficioOrigem}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_OficioOrigem',   $filter); // stores the filter in the session
        }


        if (isset($data->ProcessoData) AND ($data->ProcessoData)) {
            $filter = new TFilter('ProcessoData', '=', "{$data->ProcessoData}"); // create the filter
            TSession::setValue(__CLASS__.'_filter_ProcessoData',   $filter); // stores the filter in the session
        }


        if (isset($data->Autuado) AND ($data->Autuado)) {
            $filter = new TFilter('Autuado', 'like', "%{$data->Autuado}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_Autuado',   $filter); // stores the filter in the session
        }


        if (isset($data->EmpresaAerea) AND ($data->EmpresaAerea)) {
            $filter = new TFilter('EmpresaAerea', 'like', "%{$data->EmpresaAerea}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_EmpresaAerea',   $filter); // stores the filter in the session
        }

        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue(__CLASS__ . '_filter_data', $data);
        
        $param = array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
    }
    
    
    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            
            // creates a repository for Users
            $repository = new TRepository('Processos');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'Serial';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue(__CLASS__.'_filter_Processo')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Processo')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_ProcessoOrigem')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_ProcessoOrigem')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_OficioOrigem')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_OficioOrigem')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_ProcessoData')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_ProcessoData')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_Autuado')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Autuado')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_EmpresaAerea')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_EmpresaAerea')); // add the session filter
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            if (is_callable($this->transformCallback))
            {
                call_user_func($this->transformCallback, $objects, $param);
            }
            
            $this->datagrid->clear();
            
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }
            
            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);
            
            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit
            
            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }
    
    public function displaySituacoesProcesso($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            $obj = ProcessosSituacoes::where('SerialProcesso', '=', $object->Serial)->load();
            TTransaction::close(); // close the transaction
            if ($obj) return true;
            
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
            
        return false;
    }
    
    public function displayAutuadosProcesso($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            $obj = ProcessosAutuados::where('SerialProcesso', '=', $object->Serial)->load();
            TTransaction::close(); // close the transaction
            if ($obj) return true;
            
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
            
        return false;
    }

    public function displayAIsProcesso($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            $obj = ProcessosAIs::where('SerialProcesso', '=', $object->Serial)->load();
            TTransaction::close(); // close the transaction
            if ($obj) return true;
            
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
            
        return false;
    }

    public function displayFVTs($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            $obj = FVTs::where('SerialProcesso', '=', $object->Serial)->load();
            TTransaction::close(); // close the transaction
            if ($obj) return true;
            
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
            
        return false;
    }

}


