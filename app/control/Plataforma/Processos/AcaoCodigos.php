<?php

class AcaoCodigos
{

    private $tipoAcao;
    private $abrangenciaAcao;
    private $statusAcao;

    public function __construct()
    {
        $this->tipoAcao[0]  = '';
        $this->tipoAcao[1]  = 'Ação';
        $this->tipoAcao[2]  = 'Notificação';
        $this->tipoAcao[3]  = 'Petição';
        $this->tipoAcao[4]  = 'Defesa';
        $this->tipoAcao[5]  = 'Despacho Inicial';
        $this->tipoAcao[6]  = 'Recurso';
        $this->tipoAcao[7]  = 'Despacho Final';
        $this->tipoAcao[8]  = 'Diligências';
        $this->tipoAcao[9]  = 'Memoriais';
        $this->tipoAcao[10] = 'GRU';
        $this->tipoAcao[11] = 'Admissão Culpa';
        $this->tipoAcao[12] = 'Solicitação Vista Processual';
        $this->tipoAcao[13] = 'Alegações Finais';
        $this->tipoAcao[14] = 'Pedido de Devolução de Prazos';
        $this->tipoAcao[15] = 'Pedido de Juntada';
        $this->tipoAcao[16] = 'Pedido de Recálculo de GRU';
        $this->tipoAcao[17] = 'Notificação para Pagamento de GRU';
        $this->tipoAcao[18] = 'Respondendo Qtd de Parcelas';
        $this->tipoAcao[19] = 'Decisão de 1ª Instância';
        $this->tipoAcao[20] = 'Decisão de 2ª Instância';
        $this->tipoAcao[21] = 'Notificação para Apresentação de Memoriais';
        $this->tipoAcao[22] = 'Notificação para Apresentação de Alegações Finais';
        $this->tipoAcao[23] = 'Despacho Relator';
        
        $this->abrangenciaAcao[0] = '';
        $this->abrangenciaAcao[1] = 'Interno';
        $this->abrangenciaAcao[2] = 'Junta para Usuário';
        $this->abrangenciaAcao[3] = 'Usuário para Junta';
        
        $this->statusAcao[0] = '';
        $this->statusAcao[1] = 'Notificação de Autuação';
        $this->statusAcao[2] = '';
        $this->statusAcao[3] = '';
        $this->statusAcao[4] = '';
        $this->statusAcao[5] = '';
        $this->statusAcao[6] = 'Aguardando Defesa';
        
    }

    public function tipo($value = 0)
    {
        if ($value == null || $value == -1) $value = 0;
        return $this->tipoAcao[$value];
    }

    public function abrangencia($value = 0)
    {
        if ($value == null || $value == -1) $value = 0;
        return $this->abrangenciaAcao[$value];
    }

    public function status($value = 0)
    {
        if ($value == null || $value == -1) $value = 0;
        return $this->statusAcao[$value];
    }

}
?>
