<?php
App::uses('AppModel', 'Model');
/**
 * @copyright Copyright 2018 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Grille Model
 *
 */
class Grille extends AppModel {

	CONST QUEM_SOMOS = 1;
	CONST TERMOS = 2;
    CONST PASSO_A_PASSO = 3;

	public $actsAs = array(
        'Upload.Upload' => array(
            'image' => array(
                'fields' => array(
                    'dir' => 'photo_dir'
                ),
                'thumbnailSizes' => array(
                    'thumb' => '100x100',
                    'vga' => '200x200',
                    'xvga' => '400x400'
                )
            )
        ),
    );

}
