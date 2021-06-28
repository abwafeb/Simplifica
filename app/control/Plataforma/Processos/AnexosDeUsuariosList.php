<?php
/**
 * anexosList Listing
 * @author  <your name here>
 */
class anexosDeUsuariosList extends TWindow
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
        parent::setSize(0.8,null);
        //parent::removeTitleBar();

        
        // creates the form
        //$this->form = new BootstrapFormBuilder('form_search_anexos');
        //$this->form->setFormTitle('anexos');
        
        
        // keep the form filled during navigation with session data
        //$this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'Id', 'right');
        $column_extensao = new TDataGridColumn('extensao', 'Extensao', 'left');
        $column_local = new TDataGridColumn('local', 'Local', 'left');
        $column_notificacao_id = new TDataGridColumn('notificacao_id', 'Notificacao Id', 'right');
        $column_acao_id = new TDataGridColumn('acao_id', 'Acao Id', 'right');
        $column_processo_id = new TDataGridColumn('jprocessos->processo_numero', 'Processo Id', 'right');
        $column_referenciado_id = new TDataGridColumn('referenciado->name', 'Referenciado', 'right');
        $column_user_id = new TDataGridColumn('user->name', 'Usuário', 'right');
        $column_assuntoAnexo = new TDataGridColumn('assuntoAnexo', 'Assunto', 'left');
        $column_descricaoAnexo = new TDataGridColumn('descricaoAnexo', 'Descricao', 'left');
        $column_created_at = new TDataGridColumn('created_at', 'Criado em', 'left');
        $column_updated_at = new TDataGridColumn('updated_at', 'Atualizado em', 'left');
        $column_tipo = new TDataGridColumn('tipo', 'Tipo', 'left');
        $column_procuracao_id = new TDataGridColumn('procuracao_id', 'Procuracao Id', 'center');

        $column_created_at->setTransformer( function ($created_at, $object, $row){
            if (!empty($created_at)){
                $date = new DateTime($created_at);
                return $date->format('d/m/Y h:i:s');
            }
        });

        $column_updated_at->setTransformer( function ($updated_at, $object, $row){
            if (!empty($updated_at)){
                $date = new DateTime($updated_at);
                return $date->format('d/m/Y h:i:s');
            }
        });

        $column_procuracao_id->setVisibility(false);

        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_extensao);
        $this->datagrid->addColumn($column_local);
        $this->datagrid->addColumn($column_notificacao_id);
        $this->datagrid->addColumn($column_acao_id);
        $this->datagrid->addColumn($column_processo_id);
        $this->datagrid->addColumn($column_referenciado_id);
        $this->datagrid->addColumn($column_user_id);
        $this->datagrid->addColumn($column_assuntoAnexo);
        $this->datagrid->addColumn($column_descricaoAnexo);
        $this->datagrid->addColumn($column_created_at);
        $this->datagrid->addColumn($column_updated_at);
        $this->datagrid->addColumn($column_tipo);
        $this->datagrid->addColumn($column_procuracao_id);


        $action1 = new TDataGridAction(['ProcuracaosFormView', 'onEdit'], ['key'=>'{id}', 'proc' => '{procuracao_id}']);
        $action1->setDisplayCondition([$this,'displayProc']);
        $this->datagrid->addAction($action1, 'Ver Dados Procuração',   'fa:theater-masks blue');

        $action2 = new TDataGridAction(['AcaosFormView', 'onEdit'], ['key'=>'{id}', 'acao_id' => '{acao_id}']);
        $action2->setDisplayCondition([$this,'displayAcaos']);
        $this->datagrid->addAction($action2, 'Ver Dados Ação',   'fa:pen-fancy green');

        //$action2 = new TDataGridAction([$this, 'onDelete'], ['id'=>'{id}']);
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
    
    public function onSearchUser($param)
    {
        TSession::setValue('userRefer_filter',null);
        TSession::setValue('AnexosUsuariosList_filter',null);
        TSession::setValue('id_filter',null);
       
            $filter = new TFilter('user_id', '=', $param['key']);
            $filter1 = new TFilter('processo_id', 'IS', null);
            TSession::setValue('AnexosUsuariosList_filter', $filter);
            TSession::setValue('id_filter', $param['key']);
            TSession::setValue('AnexosUsuariosList_filter1', $filter1);
            TSession::setValue('userRefer_filter','Usuário');
        
        $this->onReload( [] );
    }
    
    public function onSearchReferenciado($param)
    {
        TSession::setValue('userRefer_filter',null);
        TSession::setValue('AnexosUsuariosList_filter',null);
        TSession::setValue('id_filter',null);
       
            $filter  = new TFilter('referenciado_id', '=', $param['key']);
            $filter1 = new TFilter('processo_id', 'IS', null);
            TSession::setValue('AnexosUsuariosList_filter', $filter);
            TSession::setValue('id_filter', $param['key']);
            TSession::setValue('AnexosUsuariosList_filter1', $filter1);
            TSession::setValue('userRefer_filter','Referenciado');

        
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
            $repository = new TRepository('anexos');

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

            if (TSession::getValue('AnexosUsuariosList_filter'))
            {
                $criteria->add(TSession::getValue('AnexosUsuariosList_filter'));
            }
            
            if (TSession::getValue('AnexosUsuariosList_filter1'))
            {
                $criteria->add(TSession::getValue('AnexosUsuariosList_filter1'));
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

                if (TSession::getValue('userRefer_filter') == 'Referenciado')
                {
                   parent::setTitle('Anexos'.' do Referenciado: ----> '.$object->referenciado->name );
                }else if (TSession::getValue('userRefer_filter') == 'Usuário')
                {
                   parent::setTitle('Anexos'.' do Usuário: ----> '.$object->user->name );
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
    
    public function displayProc($object){
        if ($object->procuracao_id == ''){
            return false;
        }
        return true;
    }

    public function displayAcaos($object){
        if ($object->acao_id == ''){
            return false;
        }
        return true;
    }
}
