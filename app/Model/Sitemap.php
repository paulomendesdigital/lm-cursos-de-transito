<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Sitemap Model
 *
 */
class Sitemap extends AppModel {

	var $useTable = false;

	public function __construct(){
		$this->Product = ClassRegistry::init('Product');
		$this->Area = ClassRegistry::init('Area');
	}

	public function getSitemapInformation($model='Product'){
		switch ($model) {
			case 'Product':
				return $this->Product->find('all', ['recursive'=>-1, 'conditions'=>['Product.status' => 1]]);
			default:
				return $this->Area->find('all', ['recursive'=>-1, 'conditions'=>['Area.status' => 1]]);
		}
	}
}