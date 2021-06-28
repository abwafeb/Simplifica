<?php
/**
 * ProcuracaosFormView Form
 * @author  <your name here>
 */
class AcaosFormView extends TWindow
{
    protected $form; // form
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_Acaos_View');
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
            $acaoCodigo = new AcaoCodigos;

            TTransaction::open('jjaer');
        
            $object = new Acaos($param['acao_id']);
            
            if (!empty($object->created_at)){
                $date_cre = new DateTime($object->created_at);
                $date_cre = $date_cre->format('d/m/Y h:i:s');
            }else{
                $date_cre = '';
            }
            
            if (!empty($object->updated_at)){
                $date_upd = new DateTime($object->updated_at);
                $date_upd = $date_upd->format('d/m/Y h:i:s');
            }else{
                $date_upd = '';
            }

            if (!empty($object->dataResposta)){
                $date_res = new DateTime($object->dataResposta);
                $date_res = $date_res->format('d/m/Y h:i:s');
            }else{
                $date_res = '';
            }
            
            if (!empty($object->dataLimite)){
                $date_lim = new DateTime($object->dataLimite);
                $date_lim = $date_lim->format('d/m/Y h:i:s');
            }else{
                $date_lim = '';
            }
            
            if (!empty($object->dataLimiteCiencia)){
                $date_lim_cie = new DateTime($object->dataLimiteCiencia);
                $date_lim_cie = $date_lim_cie->format('d/m/Y h:i:s');
            }else{
                $date_lim_cie = '';
            }

            if (!empty($object->dataCiencia)){
                $date_cie = new DateTime($object->dataCiencia);
                $date_cie = $date_cie->format('d/m/Y h:i:s');
            }else{
                $date_cie = '';
            }

            $label_id = new TLabel('Id:', '#333333', '', 'B');
            $label_id_solicitante = new TLabel('Solicitante:', '#333333', '', 'B');
            $label_id_solicitado = new TLabel('Solicitado:', '#333333', '', 'B');
            $label_id_respondente = new TLabel('Respondente:', '#333333', '', 'B');
            $label_title = new TLabel('Título:', '#333333', '', 'B');
            //$label_processo = new TLabel('Processo:', '#333333', '', 'B');
            $label_solicitacao = new TLabel('Solicitação:', '#333333', '', 'B');
            $label_resposta = new TLabel('Resposta:', '#333333', '', 'B');
            $label_observacao = new TLabel('Observação:', '#333333', '', 'B');
            $label_status = new TLabel('Status:', '#333333', '', 'B');
            $label_tipo = new TLabel('Tipo:', '#333333', '', 'B');
            $label_dataResposta = new TLabel('Data resposta:', '#333333', '', 'B');
            $label_dataLimite = new TLabel('Data limite:', '#333333', '', 'B');
            $label_dataLimiteCiencia = new TLabel('Data limite ciencia:', '#333333', '', 'B');
            $label_created_at = new TLabel('Criado em:', '#333333', '', 'B');
            $label_updated_at = new TLabel('Atualizado em:', '#333333', '', 'B');
            $label_dataCiencia = new TLabel('Data ciencia:', '#333333', '', 'B');
            $label_ciente_id = new TLabel('Ciente Id:', '#333333', '', 'B');
            //$label_processo_id = new TLabel('Processo Id:', '#333333', '', 'B');
            $label_processo_numero = new TLabel('Processo Numero:', '#333333', '', 'B');
            $label_opcoes = new TLabel('Opções:', '#333333', '', 'B');
            $label_abrangencia = new TLabel('Abrangência:', '#333333', '', 'B');

            $text_id  = new TTextDisplay($object->id, '#333333', '', '');
            $text_id_solicitante  = new TTextDisplay($object->solicitante->name, '#333333', '', '');
            $text_id_solicitado  = new TTextDisplay($object->solicitado->name, '#333333', '', '');
            $text_id_respondente  = new TTextDisplay($object->respondente->name, '#333333', '', '');
            $text_title  = new TTextDisplay($object->title, '#333333', '', '');
            //$text_processo  = new TTextDisplay($object->processo, '#333333', '', '');
            $text_solicitacao  = new TTextDisplay($object->solicitacao, '#333333', '', '');
            $text_resposta  = new TTextDisplay($object->resposta, '#333333', '', '');
            $text_observacao  = new TTextDisplay($object->observacao, '#333333', '', '');
            $text_status  = new TTextDisplay($acaoCodigo->status($object->status), '#333333', '', '');
            $text_tipo  = new TTextDisplay($acaoCodigo->tipo($object->tipo), '#333333', '', '');

            $text_dataResposta  = new TTextDisplay($date_res, '#333333', '', '');
            $text_dataLimite  = new TTextDisplay($date_lim, '#333333', '', '');
            $text_dataLimiteCiencia  = new TTextDisplay($date_lim_cie, '#333333', '', '');

            $text_created_at  = new TTextDisplay($date_cre, '#333333', '', '');
            $text_updated_at  = new TTextDisplay($date_upd, '#333333', '', '');

            $text_dataCiencia  = new TTextDisplay($date_cie, '#333333', '', '');
            
            $text_ciente_id  = new TTextDisplay($object->ciente_id, '#333333', '', '');
            //$text_processo_id  = new TTextDisplay($object->processo_id, '#333333', '', '');
            $text_processo_numero  = new TTextDisplay($object->processo_numero, '#333333', '', '');
            $text_opcoes  = new TTextDisplay($object->opcoes, '#333333', '', '');
            $text_abrangencia  = new TTextDisplay($acaoCodigo->abrangencia($object->abrangencia), '#333333', '', '');

            $this->form->addFields([$label_id],[$text_id]);
            $this->form->addFields([$label_id_solicitante],[$text_id_solicitante]);
            $this->form->addFields([$label_id_solicitado],[$text_id_solicitado]);
            $this->form->addFields([$label_id_respondente],[$text_id_respondente]);
            $this->form->addFields([$label_title],[$text_title]);
            //$this->form->addFields([$label_processo],[$text_processo]);
            $this->form->addFields([$label_solicitacao],[$text_solicitacao]);
            $this->form->addFields([$label_resposta],[$text_resposta]);
            $this->form->addFields([$label_observacao],[$text_observacao]);
            $this->form->addFields([$label_status],[$text_status]);
            $this->form->addFields([$label_tipo],[$text_tipo]);
            $this->form->addFields([$label_dataResposta],[$text_dataResposta]);
            $this->form->addFields([$label_dataLimite],[$text_dataLimite]);
            $this->form->addFields([$label_dataLimiteCiencia],[$text_dataLimiteCiencia]);
            $this->form->addFields([$label_created_at],[$text_created_at]);
            $this->form->addFields([$label_updated_at],[$text_updated_at]);
            $this->form->addFields([$label_dataCiencia],[$text_dataCiencia]);
            $this->form->addFields([$label_ciente_id],[$text_ciente_id]);
            //$this->form->addFields([$label_processo_id],[$text_processo_id]);
            $this->form->addFields([$label_processo_numero],[$text_processo_numero]);
            $this->form->addFields([$label_opcoes],[$text_opcoes]);
            $this->form->addFields([$label_abrangencia],[$text_abrangencia]);

            parent::setTitle('Ação'.' do PROCESSO: ----> '.$object->processoNumero->processo_numero);
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}