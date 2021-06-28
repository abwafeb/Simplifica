<?php
/**
 * NotificacaosList Listing
 * @author  <your name here>
 */
class NotificacaosList extends TWindow
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
        parent::removePadding();
        //parent::removeTitleBar();
        
        parent::setSize(0.8,null);
        parent::setTitle('Notificações');


        // creates the form
        //$this->form = new BootstrapFormBuilder('form_search_Notificacaos');
        //$this->form->setFormTitle('Notificacaos');
        

        
        // keep the form filled during navigation with session data
        //$this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        // add the search form actions
        //$btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        //$btn->class = 'btn btn-sm btn-primary';
        //$this->form->addActionLink(_t('New'), new TAction(['', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'Id', 'right');
        $column_hash = new TDataGridColumn('hash', 'Hash', 'left');
        $column_id_solicitante = new TDataGridColumn('id_solicitante', 'Id Solicitante', 'right');
        $column_id_solicitado = new TDataGridColumn('id_solicitado', 'Id Solicitado', 'right');
        $column_id_respondente = new TDataGridColumn('id_respondente', 'Id Respondente', 'right');
        $column_id_processo = new TDataGridColumn('id_processo', 'Id Processo', 'right');
        $column_id_notificacao_origem = new TDataGridColumn('id_notificacao_origem', 'Id Notificacao Origem', 'right');
        $column_assunto = new TDataGridColumn('assunto', 'Assunto', 'left');
        $column_notificacao = new TDataGridColumn('notificacao', 'Notificacao', 'left');
        $column_resposta = new TDataGridColumn('resposta', 'Resposta', 'left');
        $column_dataEnvio = new TDataGridColumn('dataEnvio', 'Dataenvio', 'left');
        $column_dataLeitura = new TDataGridColumn('dataLeitura', 'Dataleitura', 'left');
        $column_dataResposta = new TDataGridColumn('dataResposta', 'Dataresposta', 'left');
        $column_status = new TDataGridColumn('status', 'Status', 'right');
        $column_dataLimiteLeitura = new TDataGridColumn('dataLimiteLeitura', 'Datalimiteleitura', 'left');
        $column_dataLimiteResposta = new TDataGridColumn('dataLimiteResposta', 'Datalimiteresposta', 'left');
        $column_observacao = new TDataGridColumn('observacao', 'Observacao', 'left');
        $column_deleted_at = new TDataGridColumn('deleted_at', 'Deleted At', 'left');
        $column_created_at = new TDataGridColumn('created_at', 'Created At', 'left');
        $column_updated_at = new TDataGridColumn('updated_at', 'Updated At', 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_hash);
        $this->datagrid->addColumn($column_id_solicitante);
        $this->datagrid->addColumn($column_id_solicitado);
        $this->datagrid->addColumn($column_id_respondente);
        $this->datagrid->addColumn($column_id_processo);
        $this->datagrid->addColumn($column_id_notificacao_origem);
        $this->datagrid->addColumn($column_assunto);
        $this->datagrid->addColumn($column_notificacao);
        $this->datagrid->addColumn($column_resposta);
        $this->datagrid->addColumn($column_dataEnvio);
        $this->datagrid->addColumn($column_dataLeitura);
        $this->datagrid->addColumn($column_dataResposta);
        $this->datagrid->addColumn($column_status);
        $this->datagrid->addColumn($column_dataLimiteLeitura);
        $this->datagrid->addColumn($column_dataLimiteResposta);
        $this->datagrid->addColumn($column_observacao);
        $this->datagrid->addColumn($column_deleted_at);
        $this->datagrid->addColumn($column_created_at);
        $this->datagrid->addColumn($column_updated_at);


        //$action1 = new TDataGridAction(['', 'onEdit'], ['id'=>'{id}']);
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
        //$container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    /**
     * Register the filter in the session
     */
    public function onSearch($param)
    {
            $filter = new TFilter('id_processo', '=', $param['key']);
            TSession::setValue('NotificacaosList_filter', $filter);
            TSession::setValue('id_filter', $param['key']);
        
        $this->onReload( [] );
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
            $repository = new TRepository('notificacaos');

            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'id';
                $param['direction'] = 'asc';
            }

            $limit = 10;
            
            // creates a criteria
            $criteria = new TCriteria;
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);

            if (TSession::getValue('NotificacaosList_filter'))
            {
                $criteria->add(TSession::getValue('NotificacaosList_filter'));
            }
            
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            $this->datagrid->clear();

            if ($objects)
            {
                // iterate the collection of active records

                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }

                //parent::setTitle('Anexos'.' do PROCESSO: ----> '.$object->jprocessos->processo_numero );

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
