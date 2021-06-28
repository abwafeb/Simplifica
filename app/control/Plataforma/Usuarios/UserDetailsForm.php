<?php
/**
 * UserDetailsForm Form
 * @author  <your name here>
 */
class UserDetailsForm extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        parent::setTargetContainer('adianti_right_panel');

        // creates the form
        $this->form = new BootstrapFormBuilder('form_UserDetails');
        $this->form->setFormTitle('Detalhes do usuário');
        

        // create the form fields
        $id = new TEntry('id');
        $user_id = new TEntry('user_id');
        $CPF = new TEntry('CPF');
        $identidade = new TEntry('identidade');
        $identidade_orgao_emissor = new TEntry('identidade_orgao_emissor');
        $CEP = new TEntry('CEP');
        $pais = new TEntry('pais');
        $unidade_federativa = new TEntry('unidade_federativa');
        $cidade = new TEntry('cidade');
        $bairro = new TEntry('bairro');
        $logradouro = new TEntry('logradouro');
        $complemento = new TEntry('complemento');
        $numero = new TEntry('numero');
        $telefone_1 = new TEntry('telefone_1');
        $telefone_2 = new TEntry('telefone_2');
        $telefone_3 = new TEntry('telefone_3');
        //$observacaoRole = new TEntry('observacaoRole');
        $observacao = new TEntry('observacao');
        $concordancia = new TEntry('concordancia');
        $foto_identidade = new TEntry('foto_identidade');
        $foto_estatuto_social = new TEntry('foto_estatuto_social');
        $registro_comercial = new TEntry('registro_comercial');
        $role = new TEntry('role');
        $explicacaoRejeitado = new TText('explicacaoRejeitado');
        $rejeitado = new TCombo('rejeitado');
        $created_at = new TEntry('created_at');
        $updated_at = new TEntry('updated_at');
        $deleted_at = new TEntry('deleted_at');


        // add the fields
        $this->form->addFields( [ new TLabel('Id') ], [ $id ] );
        $this->form->addFields( [ new TLabel('User Id') ], [ $user_id ] );
        $this->form->addFields( [ new TLabel('CPF/CNPJ') ], [ $CPF ] );
        $this->form->addFields( [ new TLabel('Identidade') ], [ $identidade ] );
        $this->form->addFields( [ new TLabel('Identidade Orgao Emissor') ], [ $identidade_orgao_emissor ] );
        $this->form->addFields( [ new TLabel('Cep') ], [ $CEP ] );
        $this->form->addFields( [ new TLabel('Pais') ], [ $pais ] );
        $this->form->addFields( [ new TLabel('Unidade Federativa') ], [ $unidade_federativa ] );
        $this->form->addFields( [ new TLabel('Cidade') ], [ $cidade ] );
        $this->form->addFields( [ new TLabel('Bairro') ], [ $bairro ] );
        $this->form->addFields( [ new TLabel('Logradouro') ], [ $logradouro ] );
        $this->form->addFields( [ new TLabel('Numero') ], [ $numero ] );
        $this->form->addFields( [ new TLabel('Complemento') ], [ $complemento ] );
        $this->form->addFields( [ new TLabel('Telefone 1') ], [ $telefone_1 ] );
        $this->form->addFields( [ new TLabel('Telefone 2') ], [ $telefone_2 ] );
        $this->form->addFields( [ new TLabel('Telefone 3') ], [ $telefone_3 ] );
        //$this->form->addFields( [ new TLabel('Observacaorole') ], [ $observacaoRole ] );
        $this->form->addFields( [ new TLabel('Observacao') ], [ $observacao ] );
        $this->form->addFields( [ new TLabel('Concordancia') ], [ $concordancia ] );
        $this->form->addFields( [ new TLabel('Foto Identidade') ], [ $foto_identidade ] );
        $this->form->addFields( [ new TLabel('Foto Estatuto Social') ], [ $foto_estatuto_social ] );
        $this->form->addFields( [ new TLabel('Registro Comercial') ], [ $registro_comercial ] );
        $this->form->addFields( [ new TLabel('Role') ], [ $role ] );
        $this->form->addFields( [ new TLabel('Explicacao rejeição') ], [ $explicacaoRejeitado ] );
        $this->form->addFields( [ new TLabel('Rejeitado') ], [ $rejeitado ] );
        $this->form->addFields( [ new TLabel('Criado em') ], [ $created_at ] );
        $this->form->addFields( [ new TLabel('Alterado em') ], [ $updated_at ] );
        $this->form->addFields( [ new TLabel('Excluido em') ], [ $deleted_at ] );



        // set sizes
        $id->setSize('100%');
        $id->setEditable(FALSE);
        $user_id->setSize('100%');
        $user_id->setEditable(FALSE);
        $CPF->setSize('100%');
        $identidade->setSize('100%');
        $identidade_orgao_emissor->setSize('100%');
        $CEP->setSize('100%');
        $CEP->setMask('99999-999');
        $pais->setSize('100%');
        $unidade_federativa->setSize('100%');
        $cidade->setSize('100%');
        $bairro->setSize('100%');
        $logradouro->setSize('100%');
        $complemento->setSize('100%');
        $numero->setSize('100%');
        $telefone_1->setSize('100%');
        $telefone_2->setSize('100%');
        $telefone_3->setSize('100%');
        //$observacaoRole->setSize('100%');
        $observacao->setSize('100%');
        $concordancia->setSize('100%');
        $concordancia->setEditable(FALSE);
        $foto_identidade->setSize('100%');
        $foto_identidade->setEditable(FALSE);
        $foto_estatuto_social->setSize('100%');
        $foto_estatuto_social->setEditable(FALSE);
        $registro_comercial->setSize('100%');
        $registro_comercial->setEditable(FALSE);
        $role->setSize('100%');
        $role->setEditable(FALSE);
        $explicacaoRejeitado->setSize('100%');
        $rejeitado->setSize('100%');
        $created_at->setSize('100%');
        $created_at->setEditable(FALSE);
        $updated_at->setSize('100%');
        $updated_at->setEditable(FALSE);
        $deleted_at->setSize('100%');
        $deleted_at->setEditable(FALSE);

        $opcoes = ['0'=>'Não', '1'=>'Sim'];
        $rejeitado->addItems($opcoes);

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
        $this->form->addHeaderActionLink( _t('Close'), new TAction([$this, 'onClose']), 'fa:times red');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(['Classes', 'Usuários', 'Detalhes do Usuário']));
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
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
            //echo $data->id.'  -  '.$data->user_id;
            $object = new user_details;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated id
            //$data->id = $object->id;
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
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
                //$Oo = users::find($key)->hasMany('user_details','user_id','id');
                //echo '<pre>';var_dump($Oo);
                $obj = user_details::where('user_id', '=', $key)
                                  ->take(1)
                                  ->load();
                
                foreach ($obj as $ob){
                    //echo $ob->id . ' - ' . $ob->user_id . '<br>';
                }
                 
                if ( $ob instanceof user_details){          
                    $object = new user_details($ob->id); // instantiates the Active Record
                    $object->id = $ob->id;
                    $this->form->setData($object);
                } // fill the form;
                
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
 
    /**
     * Close side panel
     */
    public static function onClose($param)
    {
        TScript::create("Template.closeRightPanel()");
    }
    
}
