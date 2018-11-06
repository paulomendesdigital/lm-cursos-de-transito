<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	public function __Normalize($string)
    {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        $string = str_replace("-","",$string);
        $string = str_replace("&","e",$string);
        $string = str_replace(" ","-",$string);
        $string = str_replace(".","",$string);
        $string = str_replace("!","",$string);
        $string = str_replace("?","",$string);
        $string = str_replace(":","",$string);
        $string = str_replace(";","",$string);
        $string = str_replace(";","",$string);
        $string = str_replace(",","",$string);
        $string = str_replace("'","",$string);
        $string = str_replace("\"","",$string);
        $string = str_replace("/","",$string);
        $string = str_replace("|","",$string);
        $string = str_replace("--","-",$string);
        $string = str_replace("---","-",$string);
        $string = str_replace("----","-",$string);
        $string = strtolower($string);

        return utf8_encode($string);
    }

    public function dateFormatAfterFind($dateString) {
        return date('d/m/Y', strtotime($dateString));
    }

    public function dateFormatBeforeSave($data) {

        $hora = substr($data, 10, 20);
        $data = substr($data, 0, 10);

        $explode = explode("/", $data);
        if( count($explode) > 1 ){
            if ($hora) {
                $data = $explode[2] . "-" . $explode[1] . "-" . $explode[0] . $hora . ":00";
            } else {
                $data = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
            }
        }

        return $data;
    }

    public function getGendersList(){
        return [1=>'Masculino',2=>'Feminino'];
    }

    public function __extractNameLastName($fullname=null){
        if( $fullname ){
            return explode(' ', $fullname);
        }else{
            return [0=>'',1=>''];
        }
    }

    public function autocomplete($conditions = array(), $id = 'id', $label = 'name', $value = 'name'){
        $responses = array();

        $rows = $this->find('all', array(
            'recursive'=>-1,
            'conditions' => $conditions,
            'fields' => array(
                "{$id}",
                "{$label}",
                "{$value}",
            )
        ));

        $i = 0;
        foreach ($rows as $row) {
            $responses[$i]['id'] = $row[$this->name][$id];
            $responses[$i]['label'] = $row[$this->name][$label];
            $responses[$i]['value'] = $row[$this->name][$value];
            $i++;
        }

        return $responses;
    }
}
