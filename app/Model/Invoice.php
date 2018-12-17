<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Paulo Mendes - www.lmcursosdetransito.com.br
 * Cart Model
 * @property Invoice $Invoice
 */
class Invoice extends AppModel {

	/**
	 * belongsTo associations
	 *
	 * @var array
	*/

	private function __getInvoiceIds($invoices){
		$ids = [];
		foreach ($invoices as $invoice) {
			$ids[$invoice['id']] = $invoice['id'];
		}
		return $ids;
	}
}
