<?php
/**
 * Users Active Record
 * @author  <your-name-here>
 */
class users extends TRecord
{
    const TABLENAME = 'users';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    const CREATEDAT = 'created_at';
    const UPDATEDAT = 'updated_at'; 
    
    private $detail;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('serial');
        parent::addAttribute('name');
        parent::addAttribute('hash');
        parent::addAttribute('email');
        parent::addAttribute('password');
        parent::addAttribute('activated');
        parent::addAttribute('ativado');
        parent::addAttribute('exigirTrocaSenha');
        parent::addAttribute('email_verified_at');
        parent::addAttribute('limiteSemDocumentacao');
        parent::addAttribute('remember_token');
        parent::addAttribute('deleted_at');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('tipo');
    }

    public function get_detail()
    {
        // loads the associated object
        if (empty($this->detail)){

            try{
                TTransaction::open('jjaer'); // open a transaction
                $obj = user_details::where('user_id', '=', $this->id)
                                  ->take(1)
                                  ->load();
                
                foreach ($obj as $ob){
                    //echo $ob->id . ' - ' . $ob->user_id . '<br>';
                }
                 
                if ( $ob instanceof user_details){          
                    $this->detail = new user_details($ob->id); // instantiates the Active Record
                } // fill the form;
                
                TTransaction::close(); // close the transaction
            }
            catch (Exception $e){ // in case of exception
                new TMessage('error', $e->getMessage()); // shows the exception error message
                TTransaction::rollback(); // undo all pending operations
            }
       }
       
       return $this->detail;
    }
    
}
