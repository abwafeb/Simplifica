<?php
/**
 * ProcuracaosFormView Form
 * @author  <your name here>
 */
class FVTsFormView extends TWindow
{
    private $form; // form
    private $datagrid; // listing
    //private $pageNavigation;
    private $loaded;
    
    public function __construct( $param )
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_FVTs_View');
        parent::setSize(0.8,null);

        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');

        // creates the datagrid columns
        $column_Numero = new TDataGridColumn('Numero', 'Número', 'right');
        $column_Pergunta = new TDataGridColumn('Pergunta', 'Documento  instruído no processo', 'left');
        $column_Instruido = new TDataGridColumn('Instruido', ' ', 'left');
        $column_FolhaInicial = new TDataGridColumn('FolhaInicial', 'Folha inicial', 'right');
        $column_A = new TDataGridColumn('a', '', 'center');
        $column_FolhaFinal= new TDataGridColumn('FolhaFinal', 'Folha final', 'left');

        $column_Instruido->setTransformer( function ($Instruido, $object, $row){
            if (is_numeric($Instruido)){
                $instr = ($Instruido==0?'Sim':'Não');
                return $instr;
            }
        });
        
        $column_A->setTransformer( function ($a, $object, $row){
                return 'a';
        });
        
        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_Numero);
        $this->datagrid->addColumn($column_Pergunta);
        $this->datagrid->addColumn($column_Instruido);
        $this->datagrid->addColumn($column_FolhaInicial);
        $this->datagrid->addColumn($column_A);
        $this->datagrid->addColumn($column_FolhaFinal);

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
        $container->add($this->datagrid);
        
        parent::add($container);
    }
    
    public function FVTs($param){

        TSession::setValue(__CLASS__.'_filter_SerialProcesso',   NULL);
        $filter = new TFilter('SerialProcesso', '=', $param['SerialProcesso']);
        TSession::setValue(__CLASS__.'_filter_SerialProcesso',   $filter); // stores the filter in the session

        try{
            TTransaction::open('scita');
        
            $object = new Processos($param['SerialProcesso']);
            
            $label_NumeroFVT = new TLabel('Número FVT:', '#333333', 'right', 'B');
            $label_DataFVT = new TLabel('Data FVT:', '#333333', 'left', 'B');
            $label_Infracao = new TLabel('Infração:', '#333333', '', 'B');
            $label_EnquadramentoAI = new TLabel('Enquadramento:', '#333333', '', 'B');
            $label_ObsFVT = new TLabel('Observação:', '#333333', '', 'B');
            
            $text_NumeroFVT  = new TTextDisplay($object->NumeroFVT, '#333333', '', '');
            $text_DataFVT  = new TTextDisplay($object->DataFVT, '#333333', '', '');
            $text_Infracao  = new TTextDisplay($object->Infracao, '#333333', '', '');
            $text_EnquadramentoAI  = new TTextDisplay($object->EnquadramentoAI, '#333333', '', '');
            $text_ObsFVT  = new TTextDisplay($object->ObsFVT, '#333333', '', '');
            
            $this->form->addFields([$label_NumeroFVT],[$text_NumeroFVT]);
            $this->form->addFields([$label_DataFVT],[$text_DataFVT]);
            $this->form->addFields([$label_Infracao],[$text_Infracao]);
            $this->form->addFields([$label_EnquadramentoAI],[$text_EnquadramentoAI]);
            $this->form->addFields([$label_ObsFVT],[$text_ObsFVT]);

            parent::setTitle('FVT'.' do Processo: --------> '.$object->Processo);
            TTransaction::close();
            $this->onReload($param);
        }
        catch (Exception $e){
            new TMessage('error', $e->getMessage());
        }
            
    }

    public function onReload($param = NULL){
        try{
            // open a transaction with database 'jjaer'
            TTransaction::open('scita');
            
            // creates a repository for anexos
            $repository = new TRepository('FVTs');
            $limit = 13;
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order'])){
                $param['order'] = 'Numero';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            
            if (TSession::getValue(__CLASS__.'_filter_SerialProcesso')){
                $criteria->add(TSession::getValue(__CLASS__.'_filter_SerialProcesso'));
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


}
