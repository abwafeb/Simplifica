<?php
/**
 * usersForm Form
 * @author  <your name here>
 */
class UsersForm extends TWindow
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::removePadding();
        //parent::removeTitleBar();
        
        parent::setSize(800,null);
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_users');
        $this->form->setFormTitle('Usuários');
        

        // create the form fields
        $id = new TEntry('id');
        $name = new TEntry('name');
        $email = new TEntry('email');
        $exigirTrocaSenha = new TRadioGroup('exigirTrocaSenha');
        $limiteSemDocumentacao = new TDate('limiteSemDocumentacao');
        $tipo = new TCombo('tipo');
        $created_at = new TDate('created_at');
        $updated_at = new TDate('updated_at');
              
        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $id ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $name ] );
        $this->form->addFields( [ new TLabel('E-mail') ], [ $email ] );
        $this->form->addFields( [ new TLabel('Exigir troca de senha') ], [ $exigirTrocaSenha ] );
        $this->form->addFields( [ new TLabel('Limite sem documentacao') ], [ $limiteSemDocumentacao ] );
        $this->form->addFields( [ new TLabel('Tipo') ], [ $tipo ] );
        $this->form->addFields( [ new TLabel('Criado em') ], [ $created_at ] );
        $this->form->addFields( [ new TLabel('Atualizado em') ], [ $updated_at ] );

        $tipo->addValidation('Tipo', new TRequiredValidator);


        // set sizes
        $id->setSize('100%');
        $name->setSize('100%');
        $email->setSize('100%');
        $exigirTrocaSenha->setSize('100%');
        $limiteSemDocumentacao->setSize('100%');
        $tipo->setSize('100%');
        
        $created_at->setEditable(FALSE);
        $updated_at->setEditable(FALSE);
        
        $opcoes = ['cpf'=>'cpf','cnpj'=>'cnpj'];
        $tipo->addItems($opcoes);

        $opcoesTrocaSenha = ['0'=>'Não', '1'=>'Sim'];
        $exigirTrocaSenha->addItems($opcoesTrocaSenha);
        $exigirTrocaSenha->setLayout('horizontal');
        
        if (!empty($id))
        {
            $id->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:save');
        $btn->class = 'btn btn-sm btn-primary';
        //$this->form->addActionLink(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        //$this->form->addHeaderActionLink( _t('Close'), new TAction([$this, 'onClose']), 'fa:times red');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(TBreadCrumb::create(['Classes', 'Usuários', 'Dados do Usuário']));
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
        try
        {
            TTransaction::open('jjaer'); // open a transaction
            
            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/
            $this->form->validate(); // validate form data
            $data = $this->form->getData(); // get form data as array
            
            $object = new users;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated id
            $data->id = $object->id;
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
            TApplication::executeMethod('UsersList', 'onReload');
            
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(TRUE);
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('jjaer'); // open a transaction
                $object = new users($key); // instantiates the Active Record
                
                //TForm::sendData('form_users', $object);
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    public function onClose()
    {
    
    }

}
