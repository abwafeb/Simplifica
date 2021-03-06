<?php
/**
 * UsersList Listing
 * @author  <your name here>
 */
class UsersList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $formgrid;
    private $loaded;
    private $deleteButton;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Users');
        $this->form->setFormTitle('Usuários');
        
        $this->form->addExpandButton();
        
        // create the form fields
        $name = new TEntry('name');
        $email = new TEntry('email');
        $activated = new TEntry('activated');
        $ativado = new TEntry('ativado');
        $limiteSemDocumentacao = new TEntry('limiteSemDocumentacao');
        $tipo = new TEntry('tipo');
        $cpfCnpj = new TDBUniqueSearch('cpfCnpj','jjaer','user_details','user_id','CPF');


        // add the fields
        $this->form->addFields( [ new TLabel('Nome') ], [ $name ] );
        $this->form->addFields( [ new TLabel('E-mail') ], [ $email ] );
        //$this->form->addFields( [ new TLabel('Activated') ], [ $activated ] );
        //$this->form->addFields( [ new TLabel('Ativado') ], [ $ativado ] );
        //$this->form->addFields( [ new TLabel('Acesso sem documentacao') ], [ $limiteSemDocumentacao ] );
        $this->form->addFields( [ new TLabel('Tipo') ], [ $tipo ] );
        $this->form->addFields( [ new TLabel('CPF/CNPJ') ], [ $cpfCnpj ] );


        // set sizes
        $name->setSize('100%');
        $email->setSize('100%');
        //$activated->setSize('100%');
        //$ativado->setSize('100%');
        //$limiteSemDocumentacao->setSize('100%');
        $tipo->setSize('100%');
        $cpfCnpj->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        //$this->form->addActionLink(_t('New'), new TAction(['UserDetailsForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_name = new TDataGridColumn('name', 'Nome', 'left');
        $column_email = new TDataGridColumn('email', 'E-mail', 'left');
        $column_activated = new TDataGridColumn('activated', 'Ativado 1', 'right');
        $column_ativado = new TDataGridColumn('ativado', 'Ativado 2', 'right');
        $column_limiteSemDocumentacao = new TDataGridColumn('limiteSemDocumentacao', 'Acesso sem documentacao', 'left');
        $column_tipo = new TDataGridColumn('tipo', 'Tipo', 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_name);
        $this->datagrid->addColumn($column_email);
        $this->datagrid->addColumn($column_activated);
        $this->datagrid->addColumn($column_ativado);
        $this->datagrid->addColumn($column_limiteSemDocumentacao);
        $this->datagrid->addColumn($column_tipo);


        $action1 = new TDataGridAction(['UserDetailsForm', 'onEdit'], ['id'=>'{id}', 'register_state' => 'false']);
        $this->datagrid->addAction($action1, 'Editar Detalhes',   'far:edit blue');

        $action3 = new TDataGridAction(['UsersForm', 'onEdit'], ['id'=>'{id}']);
        $this->datagrid->addAction($action3, 'Editar Usuário',   'far:edit green');

        $action2 = new TDataGridAction(['anexosDeUsuariosList', 'onSearchUser'], ['id'=>'{id}', 'register_state' => 'false']);
        $action2->setDisplayCondition([$this,'displayAnexoUser']);
        $this->datagrid->addAction($action2, 'Anexos Credenciamento Usuário',   'fa:copy blue');
        
        $action3 = new TDataGridAction(['anexosDeUsuariosList', 'onSearchReferenciado'], ['id'=>'{id}', 'register_state' => 'false']);
        $action3->setDisplayCondition([$this,'displayAnexoReferenciado']);
        $this->datagrid->addAction($action3, 'Anexos Credenciamento Referenciado',   'fa:copy red');

        
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
    
    /**
     * Inline record editing
     * @param $param Array containing:
     *              key: object ID value
     *              field name: object attribute to be updated
     *              value: new attribute content 
     */
    public function onInlineEdit($param)
    {
        try
        {
            // get the parameter $key
            $field = $param['field'];
            $key   = $param['key'];
            $value = $param['value'];
            
            TTransaction::open('jjaer'); // open a transaction with database
            $object = new Users($key); // instantiates the Active Record
            $object->{$field} = $value;
            $object->store(); // update the object in the database
            TTransaction::close(); // close the transaction
            
            $this->onReload($param); // reload the listing
            new TMessage('info', "Record Updated");
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
        TSession::setValue(__CLASS__.'_filter_name',   NULL);
        TSession::setValue(__CLASS__.'_filter_email',   NULL);
        TSession::setValue(__CLASS__.'_filter_activated',   NULL);
        TSession::setValue(__CLASS__.'_filter_ativado',   NULL);
        TSession::setValue(__CLASS__.'_filter_limiteSemDocumentacao',   NULL);
        TSession::setValue(__CLASS__.'_filter_tipo',   NULL);
        TSession::setValue(__CLASS__.'_filter_cpfCnpj',   NULL);

        if (isset($data->name) AND ($data->name)) {
            $filter = new TFilter('name', 'like', "%{$data->name}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_name',   $filter); // stores the filter in the session
        }


        if (isset($data->email) AND ($data->email)) {
            $filter = new TFilter('email', 'like', "%{$data->email}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_email',   $filter); // stores the filter in the session
        }


        if (isset($data->activated) AND ($data->activated)) {
            $filter = new TFilter('activated', 'like', "%{$data->activated}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_activated',   $filter); // stores the filter in the session
        }


        if (isset($data->ativado) AND ($data->ativado)) {
            $filter = new TFilter('ativado', 'like', "%{$data->ativado}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_ativado',   $filter); // stores the filter in the session
        }


        if (isset($data->limiteSemDocumentacao) AND ($data->limiteSemDocumentacao)) {
            $filter = new TFilter('limiteSemDocumentacao', 'like', "%{$data->limiteSemDocumentacao}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_limiteSemDocumentacao',   $filter); // stores the filter in the session
        }


        if (isset($data->tipo) AND ($data->tipo)) {
            $filter = new TFilter('tipo', 'like', "%{$data->tipo}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_tipo',   $filter); // stores the filter in the session
        }

        if (isset($data->cpfCnpj) AND ($data->cpfCnpj)) {
            $filter = new TFilter('id', '=', $data->cpfCnpj); // create the filter
            TSession::setValue(__CLASS__.'_filter_cpfCnpj',   $filter); // stores the filter in the session
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
            TTransaction::open('jjaer');
            
            // creates a repository for Users
            $repository = new TRepository('Users');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'id';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue(__CLASS__.'_filter_name')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_name')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_email')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_email')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_activated')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_activated')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_ativado')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_ativado')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_limiteSemDocumentacao')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_limiteSemDocumentacao')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_tipo')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_tipo')); // add the session filter
            }

            if (TSession::getValue(__CLASS__.'_filter_cpfCnpj')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_cpfCnpj')); // add the session filter
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
     * Ask before deletion
     */
    public static function onDelete($param)
    {
        // define the delete action
        $action = new TAction([__CLASS__, 'Delete']);
        $action->setParameters($param); // pass the key parameter ahead
        
        // shows a dialog to the user
        new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);
    }
    
    /**
     * Delete a record
     */
    public static function Delete($param)
    {
        try
        {
            $key=$param['key']; // get the parameter $key
            TTransaction::open('jjaer'); // open a transaction with database
            $object = new Users($key, FALSE); // instantiates the Active Record
            $object->delete(); // deletes the object from the database
            TTransaction::close(); // close the transaction
            
            $pos_action = new TAction([__CLASS__, 'onReload']);
            new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'), $pos_action); // success message
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
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
    
    public function displayAnexoUser($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('jjaer');
            $obj = anexos::where('processo_id', 'IS', null)
                         ->where('user_id','=',$object->id)
                         ->load();
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

    public function displayAnexoReferenciado($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('jjaer');
            $obj = anexos::where('processo_id', 'IS', null)
                         ->where('referenciado_id','=',$object->id)
                         ->load();
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
