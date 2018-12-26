<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2017
 * @author Grupo Grow - www.grupogrow.com.br
 * InvoicesController Controller
 *
 * @property PaginatorComponent $Paginator
 */
class InvoicesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
        public $components = array('Paginator');


    /**
    * manager_index method
    *
    * @return void
    */

    public function manager_index() 
    {
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Invoice.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter_rps' => array(
                    'Invoice.rps_number' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%',
                            'after'  => '%'
                        )
                    )
                ),
                'filter_invoice' => array(
                    'Invoice.invoice_number' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%',
                            'after'  => '%'
                        )
                    )
                ),
                'filter_client' => array(
                    'Invoice.name' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%',
                            'after'  => '%'
                        )
                    )
                ),
                'filter_cpf' => array(
                    'Invoice.cpf' => array(
                        'operator' => 'LIKE',
                        'value' => array(
                            'before' => '%',
                            'after'  => '%'
                        )
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Invoice.invoice_number DESC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Invoice->recursive = 0;
        $this->set('invoices', $this->Paginator->paginate());
    }

    /**
    * get_rpss method
    *
    * @return void
    */
    public function get_rpss() {
        $url = Configure::read('Bling.url_notas_servico') . Configure::read('Bling.output_type');
        $fullUrl = $url . '&apikey=' . Configure::read('Bling.api_key');
        
        $response = $this->curlGetFiscalDocuments($fullUrl);

        $response = json_decode($response, true);

        echo '<pre>';
        print_r($response);
        echo '</pre>';
        die;
    }

    public function getRps($rpsNumber) {
        
        $url = Configure::read('Bling.url_nota_servico') . $rpsNumber . '/' . Configure::read('Bling.output_type');

        $response = $this->curlGetFiscalDocument($url);
        $response = json_decode($response, true);
        
        return $response;
    }

    public function buildXmlRps($order, $services) {
        
        $arrPagarMe = $this->buildArrPagarMe($order['User'], $services, $order['Order']['value']);

        $arrPagarMeJson = json_encode($arrPagarMe);

        $this->log('NFSe - arrPagarMe: ' . $arrPagarMeJson, 'nfse');

        $xml = $this->buildXmlPagarMe(date('d/m/Y'), $arrPagarMe['client'], $arrPagarMe['services'], $arrPagarMe['parcels']);

        $this->log('NFSe XML: ' . $xml, 'nfse');

        return $xml;
    }

    public function sendRps($xml) {

        $url = Configure::read('Bling.url_nota_servico') . Configure::read('Bling.output_type');

        $posts = array (
            "apikey" => Configure::read('Bling.api_key'),
            "xml" => rawurlencode($xml)
        );
        $notasPendentes = $this->curlSendRps($url, $posts);

        $this->log('NFSe notasPendentes: ' . $notasPendentes, 'nfse');

        if (empty($notasPendentes)) { return false; }

        $notasPendentes = json_decode($notasPendentes, true);

        $notasPendentes = $notasPendentes['retorno']['notasservico'];

        return $notasPendentes;
    }

    public function sendFiscalDocument($notasPendentes) {

        $url = Configure::read('Bling.url_nota_servico') . Configure::read('Bling.output_type');

        foreach ($notasPendentes as $nota) {

            $posts = array(
                "apikey"    => Configure::read('Bling.api_key'),
                "number"    => $nota['notaservico']['numero_rps'],
                "serie"     => $nota['notaservico']['serie']
            );

            $retornoSend = $this->curlSendFiscalDocument($url, $posts);

            $this->log('NFSe sendFiscalDocument: ' . $retornoSend, 'nfse');
            
            $notasEmitidas[] = json_decode($retornoSend, true);
        }

        if (empty($notasEmitidas)) { return false; }

        $i = 0;

        foreach ($notasEmitidas as $nota) {
            $notasServico[] = $nota['retorno']['notasservico'][$i];
            $i++;
        }

        if (empty($notasServico)) { return false; }

        return $notasServico;
    }

    public function createNfse($notasEmitidas) {
        
        $this->loadModel('Invoice');
        
        $this->Invoice->create();

        $response = false;

        foreach ($notasEmitidas as $nota) {

            $infoServico['rps_number']      = $nota['notaservico']['numero'];
            $infoServico['invoice_number']  = $nota['notaservico']['numeroNFSe'];
            $infoServico['situation']       = $nota['notaservico']['situacao'];
            $infoServico['value']           = $nota['notaservico']['valorNota'];
            $infoServico['invoice_link']    = $nota['notaservico']['linkNFSe'];
            $infoServico['name']            = $nota['notaservico']['cliente']['nome'];
            $infoServico['cpf']             = $nota['notaservico']['cliente']['cnpj'];
            $infoServico['email']           = $nota['notaservico']['cliente']['email'];

            if ($this->Invoice->save($infoServico)) {
                $response = $infoServico;
            }
        }

        return $response;
    }

    private function buildArrPagarMe($client, $services, $order_value) {

        $student = $client['Student'][0];

        $infoClient = [
            'nome' => $client['name'],
            'cnpj' => $client['cpf'],
            'endereco' => $student['address'],
            'numero' => $student['number'],
            'complemento' => $student['complement'],
            'bairro' => $student['neighborhood'],
            'cep' => $student['zipcode'],
            'cidade' => $student['City']['name'],
            'uf' => $student['State']['abbreviation'],
            'fone' => $student['cellphone'],
            'email' => $client['email']
        ];

        $result['client'] = $infoClient;

        foreach ($services as $service) {

            $order_value = str_replace('.', ',', $order_value);

            $infoServices[] = [
                'codigo' => Configure::read('Bling.codigo_servico'),
                'descricao' => $service['Course']['name'],
                'valor' => $order_value
            ];
        }

        $result['services'] = $infoServices;

        $date = date('d/m/Y');

        $order_value = str_replace('.', ',', $order_value);

        $infoParcels[] = [
            'data' => $date,
            'vlr' => $order_value,
            'obs' => 'Parcela 1',
        ];

        $result['parcels'] = $infoParcels;

        return $result;
    }

    private function buildXmlPagarMe($date, $infoClient, $infoServices, $infoParcels) {
        
        $xml = new DOMDocument();
        $xml->formatOutput = true;
        
        $order = $xml->createElement('pedido');
        $xml->appendChild( $order );

        $date = $date;

        $date = $xml->createElement('data', $date);
        $order->appendChild($date);

        $client = $xml->createElement('cliente');
        $order->appendChild($client);

        $services = $xml->createElement('servicos');
        $order->appendChild($services);

        $parcels = $xml->createElement('parcelas');
        $order->appendChild($parcels);
        
        foreach ($infoClient as $key => $value) {
            $child = $xml->createElement($key, $value);
            $client->appendChild($child);
        }

        foreach ($infoServices as $infoService) {
            $service = $xml->createElement('servico');

            foreach ($infoService as $key => $value) {
                $child = $xml->createElement($key, $value);
                $service->appendChild($child);
            }

            $services->appendChild($service);
        }

        foreach ($infoParcels as $infoParcel) {
            $parcel = $xml->createElement('parcela');

            foreach ($infoParcel as $key => $value) {
                $child = $xml->createElement($key, $value);
                $parcel->appendChild($child);
            }

            $parcels->appendChild($parcel);
        }

        return $xml->saveXML();
    }

    private function curlGetFiscalDocuments($fullUrl){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $fullUrl);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $response;
    }

    private function curlGetFiscalDocument($url){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url . '&apikey=' . Configure::read('Bling.api_key'));
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $response;
    }

    private function curlSendRps($url, $data){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_POST, count($data));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $response;
    }

    private function curlSendFiscalDocument($url, $data) {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_POST, count($data));
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $response;
    }
}