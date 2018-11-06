<?php
App::uses('AppController', 'Controller', 'File', 'Utility');

/**
 * @copyright Copyright 2017
 * @author Grupo Grow - www.grupogrow.com.br
 * Downloads Controller
 *
 * @property Download $Download
 * @property PaginatorComponent $Paginator
 */
class DownloadsController extends AppController {

    public function send($filepath){

        $this->viewClass = 'Media';
        $filepath = base64_decode($filepath);
        $path = pathinfo($filepath);

        $file = new File( $filepath );
        if( $file->exists( $filepath ) ){
            $params = array(
                'id' => $path['basename'],
                'name' => $path['filename'],
                'download' => true,
                'extension' => $path['extension'],
                'target' => '_blank',
                'path' => $path['dirname'] . DS,
            );
            $this->set($params);
        }else{
            $this->Session->setFlash(__('O arquivo não foi localizado no servidor, comunique ao suporte!'), 'manager/error');
            return $this->redirect( $this->referer() );
        }
    }
}
