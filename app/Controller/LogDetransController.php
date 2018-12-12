<?php

App::uses('AppController', 'Controller');

/**
 * Class LogDetransController
 *
 * @property LogDetran $LogDetran
 */
class LogDetransController extends AppController
{
    /**
     * Components
     * @var array
     */
    public $components = array('Paginator');

    /**
     * manager_index method
     *
     * @return void
     */
    public function manager_index()
    {
        $arrIntegracoes = [
            'IntegracaoDetranAl' => 'DETRAN-AL',
            'IntegracaoDetranPr' => 'DETRAN-PR',
            'IntegracaoDetranGo' => 'DETRAN-GO',
            'IntegracaoDetranMa' => 'DETRAN-MA',
            'IntegracaoDetranRj' => 'DETRAN-RJ',
            'IntegracaoDetranSe' => 'DETRAN-SE',
        ];

        $arrRotinas = [
            'consultar'  => 'Consulta',
            'validar'    => 'Validação',
            'matricular' => 'Matrícula',
            'creditar'   => 'Crédito de Aula',
            'concluir'   => 'Certificado',
        ];

        $this->Filter->addFilters(
            array(
                'filterCpf'        => array(
                    'LogDetran.cpf' => array(
                        'operator' => 'LIKE',
                        'value'    => array(
                            'before' => '%',
                            'after'  => '%'
                        )
                    )
                ),
                'filterMatricula' => array('LogDetran.order_id'),
                'filterIntegracao' => array(
                    'LogDetran.integracao' => array(
                        'select' => $arrIntegracoes
                    )
                ),
                'filterRotina' => array(
                    'LogDetran.rotina' => array(
                        'select' => $arrRotinas
                    )
                )
            )
        );

        $this->Filter->setPaginate('order', 'LogDetran.id DESC');
        $this->Filter->setPaginate('limit', Configure::read('ResultPage'));

        if (isset($this->request->data['filter']['filterCpf'])) {
            $this->request->data['filter']['filterCpf'] =  preg_replace('/\D/', '', $this->request->data['filter']['filterCpf']);
        }

        $conditions = $this->Filter->getConditions();

        //named params
        if (isset($this->params['named']['matricula'])) {
            $conditions['LogDetran.order_id'] = $this->request->data['filter']['filterMatricula'] = $this->params['named']['matricula'];
        }
        if (isset($this->params['named']['cpf'])) {
            $conditions['LogDetran.cpf'] = $this->request->data['filter']['filterCpf'] = preg_replace('/\D/', '', $this->params['named']['cpf']);
        }

        $this->Filter->setPaginate('conditions', $conditions);

        $this->set('logs', $this->Paginator->paginate());
        $this->set('integracoes', $arrIntegracoes);
        $this->set('rotinas', $arrRotinas);
    }

    /**
     * manager_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function manager_view($id = null){

        if (!$this->LogDetran->exists($id)) {
            throw new NotFoundException(__('Invalid poll'));
        }

        $this->LogDetran->Behaviors->load('Containable');
        $this->set('log', $this->LogDetran->find('first', [
            'conditions' => ['LogDetran.' . $this->LogDetran->primaryKey => $id],
            'contains' => [
                'User'
            ]
        ]));
    }
}
