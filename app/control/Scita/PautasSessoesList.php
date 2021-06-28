<?php
/**
 * usersList Listing
 * @author  <your name here>
 */
class PautasSessoesList extends TWindow{
    private $datagrid; // listing
    private $pageNavigation;
    private $formgrid;
    private $loaded;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct(){
        parent::__construct();
        parent::removePadding();
        parent::setSize(0.8,null);
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
        // creates the datagrid columns
        $column_Processo  = new TDataGridColumn('Processo->Processo', 'Processo', 'left');
        $column_Autuado   = new TDataGridColumn('Processo->Autuado', 'Autuado', 'left');
        $column_AI        = new TDataGridColumn('Processo->AIDefesa', 'Nº do AI', 'left');
        $column_Relatoria = new TDataGridColumn('Relator', 'Relatoria', 'left');
        $column_Membro1   = new TDataGridColumn('Membro1', 'Membro 1', 'left');
        $column_Membro2   = new TDataGridColumn('Membro2', 'Membro2', 'left');

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_Processo);
        $this->datagrid->addColumn($column_Autuado);
        $this->datagrid->addColumn($column_AI);
        $this->datagrid->addColumn($column_Relatoria);
        $this->datagrid->addColumn($column_Membro1);
        $this->datagrid->addColumn($column_Membro2);

        // create some actions
        $action1 = new TDataGridAction(['DespachosList', 'onSearch'], ['SerialProcesso'=>'{SerialProcesso}', 'register_state' => 'false']);
        $action1->setDisplayCondition([$this,'displayDespachos']);
        $this->datagrid->addAction($action1, 'Despachos',   'fa:copy blue');

        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    /**
     * Register the filter in the session
     */
    public function onSearch($param){
        // clear session filters
        TSession::setValue(__CLASS__.'_filter_Pautas',   NULL);
        $filter = new TFilter('SerialSessao', '=', $param['SerialSessao']); // create the filter
        TSession::setValue(__CLASS__.'_filter_Pautas',   $filter); // stores the filter in the session
        
        $param = array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
    }
    
    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL){
        try{
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            
            // creates a repository for users
            $repository = new TRepository('Pautas');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $criteria->add(TSession::getValue(__CLASS__.'_filter_Pautas')); // add the session filter
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'Sessao';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            if (is_callable($this->transformCallback)){
                call_user_func($this->transformCallback, $objects, $param);
            }
            
            $this->datagrid->clear();
            if ($objects){
                // iterate the collection of active records
                foreach ($objects as $object){
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }
            
            if (isset($object->Sessao))
               parent::setTitle('Pautas da Sessão: --> '.$object->Sessao);
    
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
        catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * method show()
     * Shows the page
     */
    public function show(){
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) ){
            if (func_num_args() > 0){
                $this->onReload( func_get_arg(0) );
            }
            else{
                $this->onReload();
            }
        }
        parent::show();
    }

    public function displayDespachos($object){
        try{
            // open a transaction with database 'scita'
            TTransaction::open('scita');
            $obj = Despachos::where('SerialProcesso', '=', $object->SerialProcesso)->load();
            TTransaction::close(); // close the transaction
            if ($obj) return true;
        }
        catch (Exception $e){
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
            
        return false;
    }

}
