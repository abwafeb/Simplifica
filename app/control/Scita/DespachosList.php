<?php
/**
 * UsersList Listing
 * @author  <your name here>
 */
class DespachosList extends TWindow
{
    protected $form; // form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    //use Adianti\base\AdiantiStandardListTrait;
    
    
    public function __construct()
    {
        parent::__construct();
        parent::removePadding();
        parent::setSize(0.85,null);
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';

        // creates the datagrid columns
        $column_Numero       = new TDataGridColumn('Numero', 'Número', 'left');
        $column_ElaboradoEm  = new TDataGridColumn('ElaboradoEm', 'Elaborada em', 'left');
        $column_ElaboradoPor = new TDataGridColumn('Usuario->Nome', 'Elaborada por', 'left');
        $column_Despacho     = new TDataGridColumn('Despacho', 'Despacho', 'left');
        $column_Data         = new TDataGridColumn('Data', 'Data', 'left');
        $column_Acao         = new TDataGridColumn('Acao', 'Ação', 'left');

        $this->datagrid->addColumn($column_Numero);
        $this->datagrid->addColumn($column_ElaboradoEm);
        $this->datagrid->addColumn($column_ElaboradoPor);
        $this->datagrid->addColumn($column_Despacho);
        $this->datagrid->addColumn($column_Data);
        $this->datagrid->addColumn($column_Acao);

        $column_Despacho->setTransformer( function ($Despacho, $object, $row){
            if (!empty($Despacho)){
                return $Despacho;
            }
        });

        $column_ElaboradoEm->setTransformer( function ($ElaboradoEm, $object, $row){
            if (!empty($ElaboradoEm)){
                $date = new DateTime($ElaboradoEm);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_Data->setTransformer( function ($Data, $object, $row){
            if (!empty($Data)){
                $date = new DateTime($Data);
                return $date->format('d/m/Y H:i:s');
            }
        });



        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
        
    }
    
    public function onSearch($param)
    {
        // clear session filters
        TSession::setValue(__CLASS__.'_filter_SerialProcesso',   NULL);
        $filter = new TFilter('SerialProcesso', '=', $param['SerialProcesso']); // create the filter
        TSession::setValue(__CLASS__.'_filter_SerialProcesso',   $filter); // stores the filter in the session

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
            $repository = new TRepository('Despachos');
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
            

            if (TSession::getValue(__CLASS__.'_filter_SerialProcesso')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_SerialProcesso')); // add the session filter
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

            parent::setTitle('Despachos');
            
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