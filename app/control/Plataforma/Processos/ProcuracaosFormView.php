<?php
/**
 * ProcuracaosFormView Form
 * @author  <your name here>
 */
class ProcuracaosFormView extends TWindow
{
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_Procuracaos_View');
        parent::setSize(0.8,null);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    /**
     * Show data
     */
    public function onEdit( $param )
    {
        try
        {
            TTransaction::open('jjaer');
        
            $object = new Procuracaos($param['proc']);
            
            if (!empty($object->created_at)){
                $date_cre = new DateTime($object->created_at);
            }else{
                $date_cre = new DateTime($object->created_at);
            }
            
            if (!empty($object->updated_at)){
                $date_upd = new DateTime($object->updated_at);
            }else{
                $date_upd = new DateTime($object->updated_at);
            }

            if (!empty($object->validade_inicio)){
                $date_vi = new DateTime($object->validade_inicio);
            }else{
                $date_vi = '';
            }
            
            if (!empty($object->validade_final)){
                $date_vf = new DateTime($object->validade_final);
            }else{
                $date_vf = '  /  /  ';
            }
            
            $label_sem_cadastro_autuado = new TLabel('Sem Cadastro Autuado:', '#333333', '', 'B');
            $label_sem_cadastro_procurador = new TLabel('Sem Cadastro Procurador:', '#333333', '', 'B');
            $label_autuado_id = new TLabel('Autuado:', '#333333', '', 'B');
            $label_procurador_id = new TLabel('Procurador:', '#333333', '', 'B');
            $label_tipo = new TLabel('Tipo:', '#333333', '', 'B');
            $label_todos = new TLabel('Todos:', '#333333', '', 'B');
            $label_verificado = new TLabel('Verificado:', '#333333', '', 'B');
            $label_validade_inicio = new TLabel('Validade Inicio:', '#333333', '', 'B');
            $label_validade_final = new TLabel('Validade Final:', '#333333', '', 'B');
            $label_created_at = new TLabel('Criado em:', '#333333', '', 'B');
            $label_updated_at = new TLabel('Atualizado em:', '#333333', '', 'B');
            $label_requererConceder = new TLabel('Requerer/Conceder:', '#333333', '', 'B');
            $label_numero = new TLabel('Numero:', '#333333', '', 'B');
            $label_poderes = new TLabel('Poderes:', '#333333', '', 'B');
            $label_explicacaoRejeicao = new TLabel('Explicacao da rejeição:', '#333333', '', 'B');

                $text_sem_cadastro_autuado  = new TTextDisplay($object->sem_cadastro_autuado, '#333333', '', '');
                $text_sem_cadastro_procurador  = new TTextDisplay($object->sem_cadastro_procurador, '#333333', '', '');
                $text_autuado_id  = new TTextDisplay($object->autuado->name, '#333333', '', '');
                $text_procurador_id  = new TTextDisplay($object->procurador->name, '#333333', '', '');
                $text_tipo  = new TTextDisplay($object->tipo, '#333333', '', '');
                $text_todos  = new TTextDisplay($object->todos, '#333333', '', '');
                $text_verificado  = new TTextDisplay($object->verificado, '#333333', '', '');

                if (!empty($object->validade_inicio)){
                    $text_validade_inicio  = new TTextDisplay($date_vi->format('d/m/Y h:i:s'), '#333333', '', '');
                }else{
                    $text_validade_inicio  = new TTextDisplay($object->validade_inicio, '#333333', '', '');
                }
                
                if (!empty($object->validade_final)){
                    $text_validade_final  = new TTextDisplay($date_vf->format('d/m/Y h:i:s'), '#333333', '', '');
                }else{
                    $text_validade_final  = new TTextDisplay($object->validade_final, '#333333', '', '');
                }
                
                $text_created_at  = new TTextDisplay($date_cre->format('d/m/Y h:i:s'), '#333333', '', '');
                $text_updated_at  = new TTextDisplay($date_upd->format('d/m/Y h:i:s'), '#333333', '', '');
                $text_requererConceder  = new TTextDisplay($object->requererConceder, '#333333', '', '');
                $text_numero  = new TTextDisplay($object->numero, '#333333', '', '');
                $text_poderes  = new TTextDisplay($object->poderes, '#333333', '', '');
                $text_explicacaoRejeicao  = new TTextDisplay($object->explicacaoRejeicao, '#333333', '', '');

            //$text_validade_inicio->setMask('dd/mm/yyyy');
            //$text_validade_inicio->setDatabaseMask('yyyy-mm-dd');
           
            //$text_created_at->setMask('dd/mm/yyyy');
            //$text_created_at->setDatabaseMask('yyyy-mm-dd');
            //$text_created_at->setEditable(false);

            //$text_updated_at->setMask('dd/mm/yyyy');
            //$text_updated_at->setDatabaseMask('yyyy-mm-dd');
            //$text_updated_at->setEditable(false);


            $this->form->addFields([$label_sem_cadastro_autuado],[$text_sem_cadastro_autuado]);
            $this->form->addFields([$label_sem_cadastro_procurador],[$text_sem_cadastro_procurador]);
            $this->form->addFields([$label_autuado_id],[$text_autuado_id]);
            $this->form->addFields([$label_procurador_id],[$text_procurador_id]);
            $this->form->addFields([$label_tipo],[$text_tipo]);
            $this->form->addFields([$label_todos],[$text_todos]);
            $this->form->addFields([$label_verificado],[$text_verificado]);
            $this->form->addFields([$label_validade_inicio],[$text_validade_inicio]);
            $this->form->addFields([$label_validade_final],[$text_validade_final]);
            $this->form->addFields([$label_created_at],[$text_created_at]);
            $this->form->addFields([$label_updated_at],[$text_updated_at]);
            $this->form->addFields([$label_requererConceder],[$text_requererConceder]);
            $this->form->addFields([$label_numero],[$text_numero]);
            $this->form->addFields([$label_poderes],[$text_poderes]);
            $this->form->addFields([$label_explicacaoRejeicao],[$text_explicacaoRejeicao]);

            parent::setTitle('Procuração'.' do Processo: --------> '.$object->jprocessos->processo_numero);
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    /**
     * Print view
     */
    public function onPrint($param)
    {
        try
        {
            $this->onEdit($param);
            
            // string with HTML contents
            $html = clone $this->form;
            $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();
            
            // converts the HTML template into PDF
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($contents);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            $file = 'app/output/Procuracaos-export.pdf';
            
            // write and open file
            file_put_contents($file, $dompdf->output());
            
            $window = TWindow::create('Export', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $file.'?rndval='.uniqid();
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}
