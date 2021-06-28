<?php
/**
 * UsersList Listing
 * @author  <your name here>
 */
class SituacoesList extends TPage
{
    protected $form; // form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    //use Adianti\base\AdiantiStandardListTrait;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_search_Situacoes');
        $this->form->setFormTitle('Situações');
        
        $this->form->addExpandButton();
        
        // create the form fields
        $Serial = new TEntry('Serial');
        $Situacao = new TEntry('Situacao');

        // add the fields
        $this->form->addFields( [ new TLabel('Id') ], [ $Serial ] );
        $this->form->addFields( [ new TLabel('Situação') ], [ $Situacao ] );

        // set sizes
        $Serial->setSize('100%');
        $Situacao->setSize('100%');
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';

        // creates the datagrid columns
        $column_serial   = new TDataGridColumn('Serial', 'Id', 'left');
        $column_situacao = new TDataGridColumn('Situacao', 'Situação', 'left');
        $column_ordem    = new TDataGridColumn('Ordem', 'Ordem', 'left');
        $column_red      = new TDataGridColumn('Red', 'Red', 'left');

        $this->datagrid->addColumn($column_serial);
        $this->datagrid->addColumn($column_situacao);
        $this->datagrid->addColumn($column_ordem);
        $this->datagrid->addColumn($column_red);

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
    
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue(__CLASS__.'_filter_Serial',   NULL);
        TSession::setValue(__CLASS__.'_filter_Situacao',   NULL);

        if (isset($data->Serial) AND ($data->Serial)) {
            $filter = new TFilter('Serial', '=', $data->Serial); // create the filter
            TSession::setValue(__CLASS__.'_filter_Serial',   $filter); // stores the filter in the session
        }


        if (isset($data->Situacao) AND ($data->Situacao)) {
            $filter = new TFilter('Situacao', 'like', '%'.$data->Situacao.'%'); // create the filter
            TSession::setValue(__CLASS__.'_filter_Situacao',   $filter); // stores the filter in the session
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
            $repository = new TRepository('Situacoes');
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
            

            if (TSession::getValue(__CLASS__.'_filter_Serial')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Serial')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_Situacao')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Situacao')); // add the session filter
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
    
    
}    