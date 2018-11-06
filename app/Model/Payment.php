<?php
App::uses('AppModel', 'Model');

/**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Payment Model
 *
 */

class Payment extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    const PENDENTE = 0;//uso interno
    const AGUARDANDO_PAGTO = 1;//Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
    const EM_ANALISE  = 2;//Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
    const APROVADO    = 3;//Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
    const DISPONIVEL  = 4;//Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
    const EM_DISPUTA  = 5;//Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
    const DEVOLVIDO   = 6;//Devolvida: o valor da transação foi devolvido para o comprador.
    const CANCELADO   = 7;//Cancelada: a transação foi cancelada sem ter sido finalizada.

    var $belongsTo = array(
        'Order' => array(
            'className' => 'Order'
        ),
    );

    public function getStatusPendente(){
        return self::PENDENTE;
    }
    public function getStatusAguardandoPagamento(){
        return self::AGUARDANDO_PAGTO;
    }
    public function getStatusEmAnalise(){
        return self::EM_ANALISE;
    }
    public function getStatusAprovado(){
        return self::APROVADO;
    }
    public function getStatusDisponivel(){
        return self::DISPONIVEL;
    }
    public function getStatusEmDisputa(){
        return self::EM_DISPUTA;
    }
    public function getStatusDevolvido(){
        return self::DEVOLVIDO;
    }
    public function getStatusCancelado(){
        return self::CANCELADO;
    }

    function getStatusListForFilter(){
        return array(
            self::PENDENTE          => "Pendente",
            self::AGUARDANDO_PAGTO  => "Aguardando Pagamento",
            self::APROVADO          => "Aprovado",
            self::CANCELADO         => "Cancelado",
            self::EM_DISPUTA        => "Em Disputa",
            self::DEVOLVIDO         => "Devolvido",
            self::EM_ANALISE        => "Em Análise",
            //self::DISPONIVEL=> "Disponível",
        );
    }

    function getStatusList(){
        return array(
            self::PENDENTE          => "Pendente",
            self::AGUARDANDO_PAGTO  => "Aguardando Pagamento",
            self::APROVADO          => "Aprovado",
            self::CANCELADO         => "Cancelado",
            self::EM_DISPUTA        => "Em Disputa",
            self::DEVOLVIDO         => "Devolvido",
            self::EM_ANALISE        => "Em Análise",
            self::DISPONIVEL        => "Disponível",
        );
    }

    function getStatusByCode($code){
        switch ($code){
            case self::PENDENTE:         return "Pendente";
            case self::AGUARDANDO_PAGTO: return "Aguardando Pagamento";
            case self::APROVADO:         return "Aprovado";
            case self::CANCELADO:        return "Cancelado";
            case self::EM_DISPUTA:       return "Em Disputa";
            case self::DEVOLVIDO:        return "Devolvido";
            case self::EM_ANALISE:       return "Em Análise";
            case self::DISPONIVEL:       return "Disponível";
            default :                    return "Não Identificado";
        }
    }

    function getStatusByText($text){
        switch ($text){
            case "Pendente"             : return self::PENDENTE;
            case "Aguardando Pagamento" : return self::AGUARDANDO_PAGTO;
            case "Aprovado"             : return self::APROVADO;
            case "Cancelado"            : return self::CANCELADO;
            case "Em Disputa"           : return self::EM_DISPUTA;
            case "Devolvido"            : return self::DEVOLVIDO;
            case "Em Análise"           : return self::EM_ANALISE;
            case "Disponível"           : return self::DISPONIVEL;
            default                     : return 0;
        }
    }

    function getStatusByPagarmeStatus($code){
        switch($code){
            case "waiting_payment" : return self::AGUARDANDO_PAGTO;
            //Transação aguardando pagamento (status válido para Boleto bancário).
            case "pending_refund"  : return self::EM_DISPUTA;
            //Transação do tipo Boleto e que está aguardando confirmação do estorno solicitado.
            case "refunded"        : return self::DEVOLVIDO;
            //Transação estornada completamente.
            case "processing"      : return self::EM_ANALISE;
            //case "authorized"      : return self::PENDENTE:
            case "authorized"      : return self::APROVADO;
            //Transação foi autorizada. Cliente possui saldo na conta e este valor foi reservado para futura captura, que deve acontecer em até 5 dias para transações criadas com api_key. Caso não seja capturada, a autorização é cancelada automaticamente pelo banco emissor, e o status dela permanece como authorized.
            case "refused"         : return self::CANCELADO;
            //Transação recusada, não autorizada.
            case "paid"            : return self::APROVADO;
            //Transação paga. Foi autorizada e capturada com sucesso. Para Boleto, significa que nossa API já identificou o pagamento de seu cliente.
            case "chargedback"     : return self::CANCELADO;
            //Chargeback é a contestação de uma compra, feita pelo portador junto ao emissor do cartão. Na prática, significa que um problema aconteceu no meio do caminho e o comprador pediu ao banco o seu dinheiro de volta.
            default                : return self::AGUARDANDO_PAGTO;
        }
    }

    function getPagarmeStatusByStatus($pagarme_status){
        switch($pagarme_status){
            case self::AGUARDANDO_PAGTO : return "waiting_payment";
            case self::EM_DISPUTA       : return "pending_refund";
            case self::DEVOLVIDO        : return "refunded";
            case self::EM_ANALISE       : return "processing";            
            case self::APROVADO         : return "authorized";
            case self::CANCELADO        : return "refused";
            case self::APROVADO         : return "paid";            
            //case self::DISPONIVEL       : return "paid"; //não usaremos o disponivel        
            default : return "Não Identificado";
        }
    }

    /**
     * Função para tratar transactionId de consulta ao pagseguro
     * Ori: BA2BD7675EE14448A76B49FD620461D0
     * Mod: BA2BD767-5EE1-4448-A76B-49FD620461D0
     */
    function transactionIdPagseguro($data) {

        $dat1 = substr($data, 0, 8);
        $dat2 = substr($data, 8, 4);
        $dat3 = substr($data, 12, 4);
        $dat4 = substr($data, 16, 4);
        $dat5 = substr($data, 20, 12);

        return $dat1 . '-' . $dat2 . '-' . $dat3 . '-' . $dat4 . '-' . $dat5;
    }

    public function insertPayment($order, $postback){
        $payment['Payment']['order_id']         = $order['Order']['id'];
        $payment['Payment']['TransacaoID']      = $postback['transaction']['id'];
        $payment['Payment']['DataTransacao']    = strftime("%Y-%m-%d %H:%M:%S",strtotime($postback['transaction']['date_updated']));
        $payment['Payment']['StatusTransacao']  = $this->getStatusByCode($this->getStatusByPagarmeStatus($postback['current_status']));
        $payment['Payment']['Parcelas']         = isset($postback['installments']) ? $postback['installments'] : 1;
        $payment['Payment']['TipoPagamento']    = $order['Method']['name'];
        $payment['Payment']['NumItens']         = count($order['OrderCourse']);
        $this->create();
        return $this->save( $payment );
    }
}