<?php
/**
 * Acaos Active Record
 * @author  <your-name-here>
 */
class Processos extends TRecord
{
    const TABLENAME = 'Processos';
    const PRIMARYKEY= 'Serial';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private $Situacao;

    /**
     * Constructor method
     */
    public function __construct($Serial = NULL, $callObjectLoad = TRUE)
    {
      parent::__construct($Serial, $callObjectLoad);
      parent::addAttribute('Processo');
      parent::addAttribute('ProcessoOrigem');
      parent::addAttribute('ProcessoData');
      parent::addAttribute('Oficio');
      parent::addAttribute('OficioOrigem');
      parent::addAttribute('OficioData');
      parent::addAttribute('Protocolo');
      parent::addAttribute('ProtocoloData');
      parent::addAttribute('MsgITA');
      parent::addAttribute('MsgITAData');
      parent::addAttribute('FCI');
      parent::addAttribute('FCIOrigem');
      parent::addAttribute('FCIData');
      parent::addAttribute('Autuado');
      parent::addAttribute('AutuadoCodANAC');
      parent::addAttribute('AutuadoCPFCNPJ');
      parent::addAttribute('AutuadoEndereco');
      parent::addAttribute('AutuadoBairro');
      parent::addAttribute('AutuadoCidade');
      parent::addAttribute('AutuadoUF');
      parent::addAttribute('AutuadoCEP');
      parent::addAttribute('AutuadoPais');
      parent::addAttribute('AutuadoEmail');
      parent::addAttribute('EmpresaAerea');
      parent::addAttribute('Aeronave');
      parent::addAttribute('AeronaveTipo');
      parent::addAttribute('TipoInfracao');
      parent::addAttribute('Infracao');
      parent::addAttribute('InfracaoData');
      parent::addAttribute('InfracaoLocal');
      parent::addAttribute('AerodromoPartida');
      parent::addAttribute('AerodromoDestino');
      parent::addAttribute('OrgaoInformante');
      parent::addAttribute('NivelVooRota');
      parent::addAttribute('Meteoro');
      parent::addAttribute('SerialSituacao');
      parent::addAttribute('SituacaoData');
      parent::addAttribute('PrimeiraInstanciaPlenario');
      parent::addAttribute('PrimeiraInstanciaRelator');
      parent::addAttribute('RecursalPlenario');
      parent::addAttribute('RecursalRelator');
      parent::addAttribute('DataLimiteRecurso');
      parent::addAttribute('Usuario');
      parent::addAttribute('Data');
      parent::addAttribute('Acao');
      parent::addAttribute('EntradaExpedicaoARDefesa');
      parent::addAttribute('SaidaCorreiosARDefesa');
      parent::addAttribute('EnvioARDefesa');
      parent::addAttribute('RecebimentoARDefesa');
      parent::addAttribute('FinalDefesa');
      parent::addAttribute('NumeroRastreioARDefesa');
      parent::addAttribute('AIDefesa');
      parent::addAttribute('ObsDefesa');
      parent::addAttribute('EntradaExpedicaoARRecursal');
      parent::addAttribute('SaidaCorreiosARRecursal');
      parent::addAttribute('EnvioARRecursal');
      parent::addAttribute('RecebimentoARRecursal');
      parent::addAttribute('FinalRecursal');
      parent::addAttribute('NumeroRastreioARRecursal');
      parent::addAttribute('NDRecursal');
      parent::addAttribute('ObsRecursal');
      parent::addAttribute('DefesaRecebida');
      parent::addAttribute('RecursalRecebida');
      parent::addAttribute('JulgadoJJ');
      parent::addAttribute('JulgadoJR');
      parent::addAttribute('AIEmitido');
      parent::addAttribute('ValorMulta');
      parent::addAttribute('SessaoPlenaria');
      parent::addAttribute('Relator');
      parent::addAttribute('Reconsideracao');
      parent::addAttribute('Recursal');
      parent::addAttribute('OrgaoATS');
      parent::addAttribute('LocalidadeOcorrencia');
      parent::addAttribute('DescricaoOcorrenciaAI');
      parent::addAttribute('EnquadramentoAI');
      parent::addAttribute('NumeroFVT');
      parent::addAttribute('DataFVT');
      parent::addAttribute('ObsFVT');
      parent::addAttribute('RegistroEm');
      parent::addAttribute('StatusFVT');
    }
    
    public function get_Situacao()
    {
        // loads the associated object
        if (empty($this->Situacao))
        
            $this->Situacao = new Situacoes($this->SerialSituacao);
    
        // returns the associated object
        return $this->Situacao;
    }

    
}