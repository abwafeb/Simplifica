<?php
/**
 * SessoesList Listing
 * @author  <your name here>
 */
class SessoesList extends TPage{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct(){
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Sessoes');
        $this->form->setFormTitle('Sessões Plenária');
        
        //$this->form->addExpandButton();
        
        $Sessao   = new TEntry('Sessao');
        $Ano      = new TNumeric('Ano',0,'','');
        
        $Aprovada = new TCombo('Aprovada');
        $opcoesAprovada = [ '0' => 'Não', '1' => 'Sim'];
        $Aprovada->addItems($opcoesAprovada);
        
        $Tipo     = new TCombo('Tipo');
        $opcoesTipo = [ 'JUNTA DE JULGAMENTO - JJ - 1ª INSTÂNCIA'=>'JUNTA DE JULGAMENTO - JJ - 1ª INSTÂNCIA', 'JUNTA RECURSAL - JR - 2ª INSTÂNCIA'=>'JUNTA RECURSAL - JR - 2ª INSTÂNCIA'];
        $Tipo->addItems($opcoesTipo);

        $this->form->addFields( [ new TLabel('Sessão') ], [ $Sessao ] );
        $this->form->addFields( [ new TLabel('Ano') ], [ $Ano ] );
        $this->form->addFields( [ new TLabel('Aprovada') ], [ $Aprovada ] );
        $this->form->addFields( [ new TLabel('Tipo') ], [ $Tipo ] );

        // set sizes
        $Sessao->setSize('30%');
        $Ano->setSize('7%');
        $Aprovada->setSize('7%');
        $Tipo->setSize('30%');
        
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
        $column_Sessao = new TDataGridColumn('Sessao', 'Sessão nº', 'right');
        $column_Tipo = new TDataGridColumn('Tipo', 'Tipo', 'left');
        $column_SessaoData = new TDataGridColumn('SessaoData', 'Data Sessão', 'left');
        $column_Aprovada = new TDataGridColumn('Aprovado_por->Nome', 'Aprovado por', 'right');
        $column_AprovadaEm = new TDataGridColumn('AprovadoEm', 'Aprovado em', 'right');

        $column_SessaoData->setTransformer( function ($SessaoData, $object, $row){
            if (!empty($SessaoData)){
                $date = new DateTime($SessaoData);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_AprovadaEm->setTransformer( function ($AprovadaEm, $object, $row){
            if (!empty($AprovadaEm)){
                $date = new DateTime($AprovadaEm);
                return $date->format('d/m/Y H:i:s');
            }
        });

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_Sessao);
        $this->datagrid->addColumn($column_Tipo);
        $this->datagrid->addColumn($column_SessaoData);
        $this->datagrid->addColumn($column_Aprovada);
        $this->datagrid->addColumn($column_AprovadaEm);

        // create some actions
        $action1 = new TDataGridAction(['PautasSessoesList', 'onSearch'], ['SerialSessao'=>'{Serial}', 'register_state' => 'false']);
        //$action1->setDisplayCondition([$this,'displayPautasSessoes']);
        //$action1->setLabel('Situações');
        //$action1->setImage('fa:copy blue');
        $this->datagrid->addAction($action1, 'Pautas',   'fa:copy blue');

        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        $this->pageNavigation->enableCounters();

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);

    }
    
    public function onSearch(){
    
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue(__CLASS__.'_filter_Sessao',   NULL);
        TSession::setValue(__CLASS__.'_filter_Tipo',   NULL);
        TSession::setValue(__CLASS__.'_filter_Ano',   NULL);
        TSession::setValue(__CLASS__.'_filter_Aprovada',   NULL);

        if (isset($data->Sessao) AND ($data->Sessao)) {
            $filter = new TFilter('Sessao', '=', $data->Sessao); // create the filter
            TSession::setValue(__CLASS__.'_filter_Sessao',   $filter); // stores the filter in the session
        }

        if (isset($data->Tipo) AND ($data->Tipo)) {
            $filter = new TFilter('Tipo', '=', $data->Tipo); // create the filter
            TSession::setValue(__CLASS__.'_filter_Tipo',   $filter); // stores the filter in the session
        }

        if (isset($data->Ano) AND ($data->Ano)) {
            $filter = new TFilter('SessaoData', 'like', "%{$data->Ano}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_Ano',   $filter); // stores the filter in the session
        }

        if (isset($data->Aprovada) AND ($data->Aprovada != '')) {
            $filter = new TFilter('Aprovada', '=', $data->Aprovada); // create the filter
            TSession::setValue(__CLASS__.'_filter_Aprovada',   $filter); // stores the filter in the session
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
            $repository = new TRepository('Sessoes');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'Sessao';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue(__CLASS__.'_filter_Sessao')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Sessao')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_Tipo')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Tipo')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_Aprovada')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Aprovada')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_Ano')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Ano')); // add the session filter
            }
            
            //echo $criteria->dump();
            
            // load the objects according to criteria
            $objects = $repository->load($criteria, true);
            
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
    
}
        

