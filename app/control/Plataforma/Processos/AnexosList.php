<?php
/**
 * anexosList Listing
 * @author  <your name here>
 */
class anexosList extends TPage
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
        $this->form = new BootstrapFormBuilder('form_search_anexos');
        $this->form->setFormTitle('Anexos');
        

        // create the form fields
        $id = new TEntry('id');
        $hash = new TEntry('hash');
        $extensao = new TEntry('extensao');
        $local = new TEntry('local');
        $notificacao_id = new TEntry('notificacao_id');
        $acao_id = new TEntry('acao_id');
        $processo_id = new TEntry('processo_id');
        $referenciado_id = new TEntry('referenciado_id');
        $user_id = new TEntry('user_id');
        $assuntoAnexo = new TEntry('assuntoAnexo');
        $descricaoAnexo = new TEntry('descricaoAnexo');
        $created_at = new TEntry('created_at');
        $updated_at = new TEntry('updated_at');
        $deleted_at = new TEntry('deleted_at');
        $internoExterno = new TEntry('internoExterno');
        $tipo = new TEntry('tipo');
        $sem_cadastro_autuado = new TEntry('sem_cadastro_autuado');
        $procuracao_id = new TEntry('procuracao_id');
        $pedidoVistaInteiroTeor = new TEntry('pedidoVistaInteiroTeor');
        $inteiroTeor = new TEntry('inteiroTeor');
        $publico = new TEntry('publico');


        // add the fields
        $this->form->addFields( [ new TLabel('Id') ], [ $id ] );
        $this->form->addFields( [ new TLabel('Hash') ], [ $hash ] );
        $this->form->addFields( [ new TLabel('Extensao') ], [ $extensao ] );
        $this->form->addFields( [ new TLabel('Local') ], [ $local ] );
        $this->form->addFields( [ new TLabel('Notificacao Id') ], [ $notificacao_id ] );
        $this->form->addFields( [ new TLabel('Acao Id') ], [ $acao_id ] );
        $this->form->addFields( [ new TLabel('Processo Id') ], [ $processo_id ] );
        $this->form->addFields( [ new TLabel('Referenciado Id') ], [ $referenciado_id ] );
        $this->form->addFields( [ new TLabel('User Id') ], [ $user_id ] );
        $this->form->addFields( [ new TLabel('Assuntoanexo') ], [ $assuntoAnexo ] );
        $this->form->addFields( [ new TLabel('Descricaoanexo') ], [ $descricaoAnexo ] );
        $this->form->addFields( [ new TLabel('Created At') ], [ $created_at ] );
        $this->form->addFields( [ new TLabel('Updated At') ], [ $updated_at ] );
        $this->form->addFields( [ new TLabel('Deleted At') ], [ $deleted_at ] );
        $this->form->addFields( [ new TLabel('Internoexterno') ], [ $internoExterno ] );
        $this->form->addFields( [ new TLabel('Tipo') ], [ $tipo ] );
        $this->form->addFields( [ new TLabel('Sem Cadastro Autuado') ], [ $sem_cadastro_autuado ] );
        $this->form->addFields( [ new TLabel('Procuracao Id') ], [ $procuracao_id ] );
        $this->form->addFields( [ new TLabel('Pedidovistainteiroteor') ], [ $pedidoVistaInteiroTeor ] );
        $this->form->addFields( [ new TLabel('Inteiroteor') ], [ $inteiroTeor ] );
        $this->form->addFields( [ new TLabel('Publico') ], [ $publico ] );


        // set sizes
        $id->setSize('100%');
        $hash->setSize('100%');
        $extensao->setSize('100%');
        $local->setSize('100%');
        $notificacao_id->setSize('100%');
        $acao_id->setSize('100%');
        $processo_id->setSize('100%');
        $referenciado_id->setSize('100%');
        $user_id->setSize('100%');
        $assuntoAnexo->setSize('100%');
        $descricaoAnexo->setSize('100%');
        $created_at->setSize('100%');
        $updated_at->setSize('100%');
        $deleted_at->setSize('100%');
        $internoExterno->setSize('100%');
        $tipo->setSize('100%');
        $sem_cadastro_autuado->setSize('100%');
        $procuracao_id->setSize('100%');
        $pedidoVistaInteiroTeor->setSize('100%');
        $inteiroTeor->setSize('100%');
        $publico->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        //$this->form->addActionLink(_t('New'), new TAction(['anexosForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'Id', 'right');
        $column_user_id = new TDataGridColumn('user_id', 'User Id', 'right');
        $column_assuntoAnexo = new TDataGridColumn('assuntoAnexo', 'Assuntoanexo', 'left');
        $column_descricaoAnexo = new TDataGridColumn('descricaoAnexo', 'Descricaoanexo', 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_user_id);
        $this->datagrid->addColumn($column_assuntoAnexo);
        $this->datagrid->addColumn($column_descricaoAnexo);


        //$action1 = new TDataGridAction(['anexosForm', 'onEdit'], ['id'=>'{id}']);
        //$action2 = new TDataGridAction([$this, 'onDelete'], ['id'=>'{id}']);
        
        //$this->datagrid->addAction($action1, _t('Edit'),   'far:edit blue');
        //$this->datagrid->addAction($action2 ,_t('Delete'), 'far:trash-alt red');
        
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
            $object = new anexos($key); // instantiates the Active Record
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
        TSession::setValue(__CLASS__.'_filter_id',   NULL);
        TSession::setValue(__CLASS__.'_filter_hash',   NULL);
        TSession::setValue(__CLASS__.'_filter_extensao',   NULL);
        TSession::setValue(__CLASS__.'_filter_local',   NULL);
        TSession::setValue(__CLASS__.'_filter_notificacao_id',   NULL);
        TSession::setValue(__CLASS__.'_filter_acao_id',   NULL);
        TSession::setValue(__CLASS__.'_filter_processo_id',   NULL);
        TSession::setValue(__CLASS__.'_filter_referenciado_id',   NULL);
        TSession::setValue(__CLASS__.'_filter_user_id',   NULL);
        TSession::setValue(__CLASS__.'_filter_assuntoAnexo',   NULL);
        TSession::setValue(__CLASS__.'_filter_descricaoAnexo',   NULL);
        TSession::setValue(__CLASS__.'_filter_created_at',   NULL);
        TSession::setValue(__CLASS__.'_filter_updated_at',   NULL);
        TSession::setValue(__CLASS__.'_filter_deleted_at',   NULL);
        TSession::setValue(__CLASS__.'_filter_internoExterno',   NULL);
        TSession::setValue(__CLASS__.'_filter_tipo',   NULL);
        TSession::setValue(__CLASS__.'_filter_sem_cadastro_autuado',   NULL);
        TSession::setValue(__CLASS__.'_filter_procuracao_id',   NULL);
        TSession::setValue(__CLASS__.'_filter_pedidoVistaInteiroTeor',   NULL);
        TSession::setValue(__CLASS__.'_filter_inteiroTeor',   NULL);
        TSession::setValue(__CLASS__.'_filter_publico',   NULL);

        if (isset($data->id) AND ($data->id)) {
            $filter = new TFilter('id', '=', $data->id); // create the filter
            TSession::setValue(__CLASS__.'_filter_id',   $filter); // stores the filter in the session
        }


        if (isset($data->hash) AND ($data->hash)) {
            $filter = new TFilter('hash', 'like', "%{$data->hash}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_hash',   $filter); // stores the filter in the session
        }


        if (isset($data->extensao) AND ($data->extensao)) {
            $filter = new TFilter('extensao', 'like', "%{$data->extensao}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_extensao',   $filter); // stores the filter in the session
        }


        if (isset($data->local) AND ($data->local)) {
            $filter = new TFilter('local', 'like', "%{$data->local}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_local',   $filter); // stores the filter in the session
        }


        if (isset($data->notificacao_id) AND ($data->notificacao_id)) {
            $filter = new TFilter('notificacao_id', 'like', "%{$data->notificacao_id}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_notificacao_id',   $filter); // stores the filter in the session
        }


        if (isset($data->acao_id) AND ($data->acao_id)) {
            $filter = new TFilter('acao_id', 'like', "%{$data->acao_id}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_acao_id',   $filter); // stores the filter in the session
        }


        if (isset($data->processo_id) AND ($data->processo_id)) {
            $filter = new TFilter('processo_id', 'like', "%{$data->processo_id}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_processo_id',   $filter); // stores the filter in the session
        }


        if (isset($data->referenciado_id) AND ($data->referenciado_id)) {
            $filter = new TFilter('referenciado_id', 'like', "%{$data->referenciado_id}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_referenciado_id',   $filter); // stores the filter in the session
        }


        if (isset($data->user_id) AND ($data->user_id)) {
            $filter = new TFilter('user_id', 'like', "%{$data->user_id}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_user_id',   $filter); // stores the filter in the session
        }


        if (isset($data->assuntoAnexo) AND ($data->assuntoAnexo)) {
            $filter = new TFilter('assuntoAnexo', 'like', "%{$data->assuntoAnexo}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_assuntoAnexo',   $filter); // stores the filter in the session
        }


        if (isset($data->descricaoAnexo) AND ($data->descricaoAnexo)) {
            $filter = new TFilter('descricaoAnexo', 'like', "%{$data->descricaoAnexo}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_descricaoAnexo',   $filter); // stores the filter in the session
        }


        if (isset($data->created_at) AND ($data->created_at)) {
            $filter = new TFilter('created_at', 'like', "%{$data->created_at}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_created_at',   $filter); // stores the filter in the session
        }


        if (isset($data->updated_at) AND ($data->updated_at)) {
            $filter = new TFilter('updated_at', 'like', "%{$data->updated_at}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_updated_at',   $filter); // stores the filter in the session
        }


        if (isset($data->deleted_at) AND ($data->deleted_at)) {
            $filter = new TFilter('deleted_at', 'like', "%{$data->deleted_at}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_deleted_at',   $filter); // stores the filter in the session
        }


        if (isset($data->internoExterno) AND ($data->internoExterno)) {
            $filter = new TFilter('internoExterno', 'like', "%{$data->internoExterno}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_internoExterno',   $filter); // stores the filter in the session
        }


        if (isset($data->tipo) AND ($data->tipo)) {
            $filter = new TFilter('tipo', 'like', "%{$data->tipo}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_tipo',   $filter); // stores the filter in the session
        }


        if (isset($data->sem_cadastro_autuado) AND ($data->sem_cadastro_autuado)) {
            $filter = new TFilter('sem_cadastro_autuado', 'like', "%{$data->sem_cadastro_autuado}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_sem_cadastro_autuado',   $filter); // stores the filter in the session
        }


        if (isset($data->procuracao_id) AND ($data->procuracao_id)) {
            $filter = new TFilter('procuracao_id', 'like', "%{$data->procuracao_id}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_procuracao_id',   $filter); // stores the filter in the session
        }


        if (isset($data->pedidoVistaInteiroTeor) AND ($data->pedidoVistaInteiroTeor)) {
            $filter = new TFilter('pedidoVistaInteiroTeor', 'like', "%{$data->pedidoVistaInteiroTeor}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_pedidoVistaInteiroTeor',   $filter); // stores the filter in the session
        }


        if (isset($data->inteiroTeor) AND ($data->inteiroTeor)) {
            $filter = new TFilter('inteiroTeor', 'like', "%{$data->inteiroTeor}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_inteiroTeor',   $filter); // stores the filter in the session
        }


        if (isset($data->publico) AND ($data->publico)) {
            $filter = new TFilter('publico', 'like', "%{$data->publico}%"); // create the filter
            TSession::setValue(__CLASS__.'_filter_publico',   $filter); // stores the filter in the session
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
            
            // creates a repository for anexos
            $repository = new TRepository('anexos');
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
            

            if (TSession::getValue(__CLASS__.'_filter_id')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_id')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_hash')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_hash')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_extensao')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_extensao')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_local')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_local')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_notificacao_id')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_notificacao_id')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_acao_id')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_acao_id')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_processo_id')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_processo_id')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_referenciado_id')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_referenciado_id')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_user_id')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_user_id')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_assuntoAnexo')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_assuntoAnexo')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_descricaoAnexo')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_descricaoAnexo')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_created_at')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_created_at')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_updated_at')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_updated_at')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_deleted_at')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_deleted_at')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_internoExterno')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_internoExterno')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_tipo')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_tipo')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_sem_cadastro_autuado')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_sem_cadastro_autuado')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_procuracao_id')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_procuracao_id')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_pedidoVistaInteiroTeor')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_pedidoVistaInteiroTeor')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_inteiroTeor')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_inteiroTeor')); // add the session filter
            }


            if (TSession::getValue(__CLASS__.'_filter_publico')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_publico')); // add the session filter
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
            $object = new anexos($key, FALSE); // instantiates the Active Record
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
}
