<?php
App::uses('AppController', 'Controller');
/**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Grilles Controller
 *
 * @property Grille $Grille
 * @property PaginatorComponent $Paginator
 */
class GrillesController extends AppController {

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
    public function manager_index() {

        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Grille.id' => array(
                        'operator' => '=',
                        'value' => array(
                            'before' => '', 
                            'after'  => ''  
                        )
                    )
                ),
                'filter2' => array(
                    'Grille.status' => array(
                        'select' => ['' => 'Status', 0 => 'Inativo', 1 => 'Ativo']
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'Grille.id ASC'); // optional
        $this->Filter->setPaginate('limit', Configure::read('ResultPage')); // optional

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        $this->Grille->recursive = 0;
        $this->set('grilles', $this->Paginator->paginate());
    }

    /**
    * manager_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */

    public function manager_view($id = null)
    {
        if (!$this->Grille->exists($id)) {
            throw new NotFoundException(__('Invalid grille'));
        }
        $options = array('conditions' => array('Grille.' . $this->Grille->primaryKey => $id));
        $this->set('grille', $this->Grille->find('first', $options));
    }

        
    /**
    * manager_add method
    *
    * @return void
    */
    
    public function manager_add() 
    {
        if ($this->request->is('post')) {
        
            $this->Grille->create();
            if ($this->Grille->save($this->request->data)) {
            
                                    $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        }
            }

    
    /**
    * manager_edit method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_edit($id = null) 
    {
        if (!$this->Grille->exists($id)) {
            throw new NotFoundException(__('Invalid grille'));
        }
        
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Grille->save($this->request->data)) {
                                        $this->Session->setFlash(__('The has been saved.'), 'manager/success');
                        if(isset($this->request->data['aplicar'])){
                            return $this->redirect($this->referer());
                        }
                                                    return $this->redirect(array('action' => 'index', 'manager' => true));
                                            } else {
                        $this->Session->setFlash(__('The could not be saved. Please, try again.'), 'manager/error');
                            }
        } else {
            $options = array('conditions' => array('Grille.' . $this->Grille->primaryKey => $id));
            $this->request->data = $this->Grille->find('first', $options);
        }
        
            }

    /**
    * manager_delete method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    
    public function manager_delete($id = null) 
    {
        $this->Grille->id = $id;
        if (!$this->Grille->exists()) {
            throw new NotFoundException(__('Invalid grille'));
        }
        
        $this->request->onlyAllow('post', 'delete');
        if ($this->Grille->delete()) {
                    $this->Session->setFlash(__('The has been deleted.'), 'manager/success');
            } else {
            $this->Session->setFlash(__('The could not be deleted. Please, try again.'), 'manager/error');
            }
                            return $this->redirect(array('action' => 'index', 'manager' => true));
                            }}
