<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * States Controller
 *
 * @property City $City
 */
class CitiesController extends AppController {

    public function ajax_getCityIdByName($name,$state_id=null){
        $this->autoRender = false;
        $this->layout = 'ajax';
        $name = $this->__RemoveAcentos($name);

        if( $state_id ){
            $city = $this->City->find('first',['fields'=>['City.id'],'conditions'=>['City.name'=>$name,'City.state_id'=>$state_id]]);
        }else{
            $city = [];
        }

        return isset($city['City']['id']) && !empty($city['City']['id']) ? $city['City']['id'] : false;
    }

    public function ajax_getCityOptionsByStateId($state_id){
        $this->autoRender = false;
        $this->layout = 'ajax';

        $cities = $this->City->find('list',['conditions'=>['City.state_id'=>$state_id]]);

        $options = "<option>Selecione a Cidade</option>";
        foreach($cities as $id => $city){
            $options .= "<option value='{$id}'>{$city}</option>";            
        }

        return $options;
    }

    public function ajax_getCitiesForCourseTypes($state_id){
        $this->autorender = false;
        $this->layout = false;
        $cities = $this->City->find('all', [
            'recursive'=>-1,
            'conditions'=>['City.state_id'=>$state_id, 'City.name <>'=>'Todas as Cidades'],
            'order'=>['City.name']
        ]);

        $this->set(compact('cities'));
        $this->render('/Elements/manager/cities_course');
    } 
}