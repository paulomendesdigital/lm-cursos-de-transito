<?php
/**
 * Easy Compressor Plugin - compress Js and CSS in a easy way
 * @author Glauco Custódio (@glauco_dsc) <glauco.custodio@gmail.com>     
 * @link https://github.com/glaucocustodio/easy-compressor-plugin
 * http://blog.glaucocustodio.com - http://glaucocustodio.com
 */
class FindCepsController extends  FindCepsAppController{
  /**
   * Method responsible to combine and compress CSS
   */
  public function index($cep=null){
    $this->autoRender = false;
    $this->layout = false;

    $return = null;

    if($cep){
      $cep = preg_replace("/[^0-9]/", "",$cep);

        $return = $this->postmon($cep);

        if(!$return){
          $return = $this->correiosapi($cep);
        }

    }

    return json_encode($return);
    exit;
    
  }

  private function postmon($cep){

    $url = "http://api.postmon.com.br/v1/cep/".$cep;

    if($this->get_http_response_code($url)!="404" && $this->get_http_response_code($url)!= "403"){
        $data = file_get_contents($url);

        if($data!=false):

          $xml = (array) json_decode($data);

          $model = array(
            'uf' => $xml['estado'],
            'cidade' => $xml['cidade'],
            'bairro' => $xml['bairro'],
            'logradouro' => $xml['logradouro'],
            'servico' => 'postmon'
          );

          $this->loadModel('State');
          $model['uf_id'] = $this->State->find('first',['conditions'=>['abbreviation'=>$xml['estado']]])['State']['id'];

          $model['cidades'] = $this->State->City->getOptionsForSelect($model['uf_id']);

          $model['cidade_id'] = $this->State->City->find('first',['conditions'=>['City.name'=>$xml['cidade']]])['City']['id'];

          return $model;

        else:
          return false;
        endif;
    }

    return false;

  }

  private function correiosapi($cep){

    $url = "http://correiosapi.apphb.com/cep/".$cep;
    $data = file_get_contents($url);

    if($data!=false):
      
      $xml = (array) json_decode($data);

      $model = array(
        'uf' => $xml['estado'],
        'cidade' => $xml['cidade'],
        'bairro' => $xml['bairro'],
        'logradouro' => $xml['tipoDeLogradouro'].' '.$xml['logradouro'],
        'servico' => 'correiosapi'
      );

      $this->loadModel('State');
      $model['uf_id'] = $this->State->find('first',['conditions'=>['abbreviation'=>$xml['estado']]])['State']['id'];

      $model['cidades'] = $this->State->City->getOptionsForSelect($model['uf_id']);

      $model['cidade_id'] = $this->State->City->find('first',['conditions'=>['City.name'=>$xml['cidade']]])['City']['id'];

      return $model;

    else:
      return false;
    endif;

  }

  private function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}
  
}
