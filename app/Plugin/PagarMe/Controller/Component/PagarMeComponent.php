<?php

/**
 * CakePHP PagarmeComponent
 */
App::import('Vendor', 'autoload');
class PagarMeComponent extends Component {

    public $PagarMe = null;    

    public function __construct(){        
        $this->PagarMe = new \PagarMe\Sdk\PagarMe(Configure::read('Pagarme.apikey'));        
    }

    public function createTransaction($cart_informations){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://api.pagar.me/1/transactions");
        //curl_setopt($curl, CURLOPT_PORT, 80);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                                            ));        
        $params = $cart_informations;        

        $params['payment_method'] = $cart_informations['payment_method'];        
        $params['api_key'] = Configure::read('Pagarme.api_key');                
        
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($params));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($curl);        
        
        curl_close ($curl);

        $return = json_decode($server_output,true);        

        return $return;
    }

    public function transactionSuccess($transaction){
        if(empty($transaction['errors']) && $transaction['status'] != 'refused'){
            return true;
        }
        return false;
    }

    public function captureTransaction($transaction_id, $price){        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://api.pagar.me/1/transactions/{$transaction_id}/capture");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                                            ));        
        $params = [];
        $params['amount'] = number_format($price,2,'','');
        $params['api_key'] = Configure::read('Pagarme.api_key');                
        
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($params));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($curl);        
        
        curl_close ($curl);

        $return = json_decode($server_output,true);        

        return $return;

    }

    //Estornar transação
    public function refundTransaction($transaction_id, $refund_informations = array()){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://api.pagar.me/1/transactions/{$transaction_id}/refund");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                                            ));        
        $params = $refund_informations;        

        $params['api_key'] = Configure::read('Pagarme.api_key');                
        
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($params));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($curl);        
        
        curl_close ($curl);

        $return = json_decode($server_output,true);                

        return $return;

    }

    //Validar Postback
    public function validatePostback($postback_body, $signature){         

        $parts = explode("=", $signature, 2);

        if (count($parts) != 2) {
            return false;
        }

        $apiKey = Configure::read('Pagarme.api_key');
        $algorithm = $parts[0];
        $hash = $parts[1];        

        return hash_hmac($algorithm, $postback_body, $apiKey) === $hash;            
    }

    public function getPostBack($transaction_id, $postback_id){
            
        $curl = curl_init();
        $api_key = Configure::read('Pagarme.api_key');
        curl_setopt($curl, CURLOPT_URL,"https://api.pagar.me/1/transactions/{$transaction_id}/postbacks/{$postback_id}?api_key={$api_key}");        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json',
                                            'Connection: Keep-Alive'
                                            ));        
                
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($curl);

        curl_close ($curl);
        
        return json_decode($server_output,true);
    }
        
}
