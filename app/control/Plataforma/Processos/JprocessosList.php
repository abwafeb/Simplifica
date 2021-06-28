<?php
/**
 * JprocessosList Listing
 * @author  <your name here>
 */
class JprocessosList extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    
    use Adianti\base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('jjaer');            // defines the database
        $this->setActiveRecord('Jprocessos');   // defines the active record
        $this->setDefaultOrder('id', 'asc');         // defines the default order
        $this->setLimit(10);
        // $this->setCriteria($criteria) // define a standard filter

        $this->addFilterField('id', '=', 'id'); // filterField, operator, formField
        $this->addFilterField('autuado_id', '=', 'autuado_id');
        $this->addFilterField('dataLimite', 'like', 'dataLimite'); // filterField, operator, formField
        $this->addFilterField('processo_numero', 'like', 'processo_numero'); // filterField, operator, formField
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Jprocessos');
        $this->form->setFormTitle('Pesquisa de processos');

        $this->form->addExpandButton();
        
        //$this->form->generateAria(); // automatic aria-label
        //$this->form->appendPage('Basic');        

        // create the form fields
        $id = new TEntry('id');
        $autuado_id = new TDBUniqueSearch('autuado_id','jjaer','users','id','name');
        $dataLimite = new TDate('dataLimite');
        $dataLimite->setMask('dd/mm/yyyy');
        $dataLimite->setDatabaseMask('yyyy-mm-dd');
        $processo_numero = new TEntry('processo_numero');


        // add the fields
        $this->form->addFields( [ new TLabel('Id') ], [ $id ] );
        $this->form->addFields( [ new TLabel('Autuado') ], [ $autuado_id ] );
        $this->form->addFields( [ new TLabel('Data limite') ], [ $dataLimite ] );
        $this->form->addFields( [ new TLabel('Processo Numero') ], [ $processo_numero ] );


        // set sizes
        $id->setSize('100%');
        $autuado_id->setSize('100%');
        $dataLimite->setSize('100%');
        $processo_numero->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        //$this->form->addActionLink(_t('New'), new TAction(['', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->disableDefaultClick();
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id                         = new TDataGridColumn('id', 'Id', 'right');
        $column_autuado_id                 = new TDataGridColumn('autuado->name', 'Nome/Razão', 'right','10%');
        $column_processo_numero            = new TDataGridColumn('processo_numero', 'Processo Numero', 'left');
        $column_dataLimite                 = new TDataGridColumn('dataLimite', 'Data limite', 'left');
        $column_observacao                 = new TDataGridColumn('observacao', 'Observacao', 'left');
        $column_created_at                 = new TDataGridColumn('created_at', 'Criado em', 'left');
        $column_updated_at                 = new TDataGridColumn('updated_at', 'Atualizado em', 'left');
        $column_sem_cadastro_autuado       = new TDataGridColumn('sem_cadastro_autuado', 'Sem Cadastro Autuado', 'left');
        $column_sem_cadastro_autuado_email = new TDataGridColumn('sem_cadastro_autuado_email', 'Sem Cadastro Autuado Email', 'left');
        $column_antigo                     = new TDataGridColumn('antigo', 'Antigo', 'right');
        $column_podeVer                    = new TDataGridColumn('podeVer', 'Pode ver?', 'right');

        $column_dataLimite->setTransformer( function ($dataLimite, $object, $row){
            if (!empty($dataLimite)){
                $date = new DateTime($dataLimite);
                return $date->format('d/m/Y h:i:s');
            }
        });
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
        
        $column_podeVer->setTransformer( function ($podeVer, $object, $row){
            if ($podeVer == 0){
                return 'Não';
            }else{
                return 'Sim';
            }
            
        });
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_autuado_id);
        $this->datagrid->addColumn($column_processo_numero);
        $this->datagrid->addColumn($column_dataLimite);
        $this->datagrid->addColumn($column_observacao);
        $this->datagrid->addColumn($column_created_at);
        $this->datagrid->addColumn($column_updated_at);
        $this->datagrid->addColumn($column_sem_cadastro_autuado);
        $this->datagrid->addColumn($column_sem_cadastro_autuado_email);
        $this->datagrid->addColumn($column_antigo);
        $this->datagrid->addColumn($column_podeVer);

        
        $action1 = new TDataGridAction(['anexosDeProcessosList', 'onSearch'], ['id'=>'{id}', 'register_state' => 'false']);
        $action1->setDisplayCondition([$this,'displayAnexo']);
        $this->datagrid->addAction($action1, 'Anexos',   'fa:copy blue');
        
        $action2 = new TDataGridAction(['NotificacaosList'     , 'onSearch'], ['id'=>'{id}', 'register_state' => 'false']);
        $action2->setDisplayCondition([$this,'displayNotific']);
        $this->datagrid->addAction($action2, 'Notificações',   'fa:pen-alt red');

        //$action2 = new TDataGridAction([$this, 'onDelete'], ['id'=>'{id}', 'register_state' => 'false']);
        //$this->datagrid->addAction($action2 ,_t('Delete'), 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        $panel = new TPanelGroup('', 'white');
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        // header actions
        $dropdown = new TDropDown('Download', 'fa:list');
        $dropdown->setPullSide('right');
        $dropdown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown->addAction( 'CSV', new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static'=>'1']), 'fa:table blue' );
        $dropdown->addAction( 'PDF', new TAction([$this, 'onExportPDF'], ['register_state' => 'false', 'static'=>'1']), 'far:file-pdf red' );
        $panel->addHeaderWidget( $dropdown );
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
    
    public function onEdit($param){
    
    }
    
    public function displayAnexo($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('jjaer');
            $obj = anexos::where('processo_id', '=', $object->id)->load();
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

    public function displayNotific($object)
    {
        try
        {
            // open a transaction with database 'jjaer'
            TTransaction::open('jjaer');
            $obj = Notificacaos::where('id_processo', '=', $object->id)->load();
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
