<?php
/**
 * DemonstrativosList Listing
 * @author  <your name here>
 */
class DemonstrativosList extends TPage
{
    protected $form; // form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    //use Adianti\base\AdiantiStandardListTrait;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_search_Demosntrativos');
        $this->form->setFormTitle('Demonstrativos');
        //$this->form->addExpandButton();
        
        // create the form fields
        $Ano = new TCombo('Ano');
        $opcoesAno   = ['2014'=>'2014',
                        '2015'=>'2015',
                        '2016'=>'2016',
                        '2017'=>'2017',
                        '2018'=>'2018',
                        '2019'=>'2019',
                        '2020'=>'2020',
                        '2021'=>'2021',
                        '2022'=>'2022',
                        '2023'=>'2023',
                        '2024'=>'2024',
                        '2025'=>'2025',
                        '2026'=>'2026',
                        '2027'=>'2027',
                        '2028'=>'2028',
                        '2029'=>'2029',
                        '2030'=>'2030',
                        '2031'=>'2031',
                        '2032'=>'2032',
                        '2033'=>'2033',
                        '2034'=>'2034',
                        '2035'=>'2035',
                        '2036'=>'2036',
                        '2037'=>'2037',
                        '2038'=>'2038'];

        $Ano->addItems($opcoesAno);
        
        $Mes = new TCombo('Mes');
        $opcoesMes = [ '1'=>'1',
                       '2'=>'2',
                       '3'=>'3',
                       '4'=>'4',
                       '5'=>'5',
                       '6'=>'6',
                       '7'=>'7',
                       '8'=>'8',
                       '9'=>'9',
                       '10'=>'10',
                       '11'=>'11',
                       '12'=>'12' ];
                       
        $Mes->addItems($opcoesMes);
        
        $Responsavel    = new TEntry('Responsavel');
        $ACI            = new TEntry('ACI');
        $GestorFinancas = new TEntry('GestorFinancas');

        // add the fields
        $this->form->addFields( [ new TLabel('Ano') ], [ $Ano ] );
        $this->form->addFields( [ new TLabel('Mes') ], [ $Mes ] );
        $this->form->addFields( [ new TLabel('Responsavel') ], [ $Responsavel ] );
        $this->form->addFields( [ new TLabel('ACI') ], [ $ACI ] );
        $this->form->addFields( [ new TLabel('Gestor de Finanças') ], [ $GestorFinancas ] );

        // set sizes
        $Ano->setSize('40%');
        $Mes->setSize('40%');
        $Responsavel->setSize('100%');
        $ACI->setSize('100%');
        $GestorFinancas->setSize('100%');
        
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
        $column_Ano            = new TDataGridColumn('Ano', 'Ano', 'left');
        $column_Mes            = new TDataGridColumn('Mes', 'Mes', 'left');
        $column_Responsavel    = new TDataGridColumn('Responsavel', 'Responsavel', 'left');
        $column_ACI            = new TDataGridColumn('ACI', 'ACI', 'left');
        $column_GestorFinancas = new TDataGridColumn('GestorFinancas', 'Gestor de Finanças', 'left');
        $column_DataDR         = new TDataGridColumn('DataDR', 'Data DR', 'left');
        $column_ObsDR          = new TDataGridColumn('ObsDR', 'Obs DR', 'left');
        $column_DataDRA        = new TDataGridColumn('DataDRA', 'Data DRA', 'left');
        $column_ObsDRA         = new TDataGridColumn('ObsDRA', 'Obs DRA', 'left');
        $column_DataGRN        = new TDataGridColumn('DataGRN', 'Data GRN', 'left');
        $column_GRN            = new TDataGridColumn('GRN', 'GRN', 'left');
        $column_OD             = new TDataGridColumn('OD', 'OD', 'left');
        $column_ContaUnica     = new TDataGridColumn('ContaUnica', 'Conta Única', 'left');

        $column_DataDR->setTransformer( function ($DataDR, $object, $row){
            if (!empty($DataDR)){
                $date = new DateTime($DataDR);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_DataDRA->setTransformer( function ($DataDRA, $object, $row){
            if (!empty($DataDRA)){
                $date = new DateTime($DataDRA);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $column_DataGRN->setTransformer( function ($DataGRN, $object, $row){
            if (!empty($DataGRN)){
                $date = new DateTime($DataGRN);
                return $date->format('d/m/Y H:i:s');
            }
        });

        $this->datagrid->addColumn($column_Ano);
        $this->datagrid->addColumn($column_Mes);
        $this->datagrid->addColumn($column_Responsavel);
        $this->datagrid->addColumn($column_ACI);
        $this->datagrid->addColumn($column_GestorFinancas);
        $this->datagrid->addColumn($column_DataDR);
        $this->datagrid->addColumn($column_ObsDR);
        $this->datagrid->addColumn($column_DataDRA);
        $this->datagrid->addColumn($column_ObsDRA);
        $this->datagrid->addColumn($column_DataGRN);
        $this->datagrid->addColumn($column_GRN);
        $this->datagrid->addColumn($column_OD);
        $this->datagrid->addColumn($column_ContaUnica);

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
        TSession::setValue(__CLASS__.'_filter_Ano',   NULL);
        TSession::setValue(__CLASS__.'_filter_Mes',   NULL);
        TSession::setValue(__CLASS__.'_filter_Responsavel',   NULL);
        TSession::setValue(__CLASS__.'_filter_ACI',   NULL);
        TSession::setValue(__CLASS__.'_filter_GestorFinancas',   NULL);

        if (isset($data->Ano) AND ($data->Ano)) {
            $filter = new TFilter('Ano', '=', $data->Ano); // create the filter
            TSession::setValue(__CLASS__.'_filter_Ano',   $filter); // stores the filter in the session
        }

        if (isset($data->Mes) AND ($data->Mes)) {
            $filter = new TFilter('Mes', '=', $data->Mes); // create the filter
            TSession::setValue(__CLASS__.'_filter_Mes',   $filter); // stores the filter in the session
        }

        if (isset($data->Responsavel) AND ($data->Responsavel)) {
            $filter = new TFilter('Responsavel', 'like',  '%'.$data->Responsavel. '%'); // create the filter
            TSession::setValue(__CLASS__.'_filter_Responsavel',   $filter); // stores the filter in the session
        }

        if (isset($data->ACI) AND ($data->ACI)) {
            $filter = new TFilter('ACI', 'like',  '%'.$data->ACI. '%'); // create the filter
            TSession::setValue(__CLASS__.'_filter_ACI',   $filter); // stores the filter in the session
        }

        if (isset($data->GestorFinancas) AND ($data->GestorFinancas)) {
            $filter = new TFilter('GestorFinancas', 'like',  '%'.$data->GestorFinancas. '%'); // create the filter
            TSession::setValue(__CLASS__.'_filter_GestorFinancas',   $filter); // stores the filter in the session
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
            $repository = new TRepository('Demonstrativos');
            $limit = 5;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = 'Ano';
                $param['direction'] = 'desc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            

            if (TSession::getValue(__CLASS__.'_filter_Ano')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Ano')); // add the session filter
            }

            if (TSession::getValue(__CLASS__.'_filter_Mes')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Mes')); // add the session filter
            }
            
            if (TSession::getValue(__CLASS__.'_filter_Responsavel')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_Responsavel')); // add the session filter
            }

            if (TSession::getValue(__CLASS__.'_filter_ACI')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_ACI')); // add the session filter
            }
            
            if (TSession::getValue(__CLASS__.'_filter_GestorFinancas')) {
                $criteria->add(TSession::getValue(__CLASS__.'_filter_GestorFinancas')); // add the session filter
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
