<?php
/** 
 * @author Ricardo Aranha <ricardo.elias.aranha@gmail.com>     
 */
class PagarMeController extends AppController {
	public function getEncryptionKey(){		
		if(!empty($this->Auth->user('id'))){
			return json_encode(['encryption_key'=>Configure::read('Pagarme.encryption_key')]);
		}else{
			return false;
		}
	}

    
}
?>
