<?php

App::uses('AuthComponent', 'Controller/Component');
App::uses('IntegracaoDetransService', 'IntegracaoDetrans');
App::uses('StatusDetran', 'Model');
App::uses('OrderCourse', 'Model');

/**
 * Classe para Retransmissão de Informações das Integrações
 *
 * @property OrderCourse $OrderCourse
 */
class IntegracaoShell extends AppShell {

    const LIMITE_TENTATIVAS = 200;

    public $uses = ['OrderCourse'];

    public function main() {
        $this->out('Inicializando transmissoes...');

        $this->stdout->styles('ok', ['text' => 'green']);

        $arrOrderCourses = $this->OrderCourse->find('all', [
            'conditions' => [
                'OrderCourse.retry_count_detran >'  => 0,
                'OrderCourse.retry_count_detran <=' => self::LIMITE_TENTATIVAS,
                'OR' => [
                    'OrderCourse.status_detran_id'   => null,
                    'OrderCourse.status_detran_id <' => StatusDetran::CONCLUIDO
                ]
            ],
            'fields'     => ['id', 'order_id', 'course_id', 'retry_count_detran'],
            'order'      => ['OrderCourse.last_exec_detran'],
            'limit'      => 1
        ]);

        $this->out('<info>' . count($arrOrderCourses) . ' registros encontrados.</info>');

        $objIntegracaoService = new IntegracaoDetransService();
        $objIntegracaoService->setOrigem('console');

        foreach ($arrOrderCourses as $arrOrderCourse) {
            $strPrefix = 'ID ' . str_pad($arrOrderCourse['OrderCourse']['order_id'] . ' - ' . $arrOrderCourse['OrderCourse']['id'], 7, ' ') . ' ';
            try {
                $this->out($strPrefix . 'Processando ...');
                $this->out($strPrefix . 'Num. tentativas anteriores: ' . $arrOrderCourse['OrderCourse']['retry_count_detran']);
                if ($arrOrderCourse['OrderCourse']['retry_count_detran'] < self::LIMITE_TENTATIVAS) {
                    $objIntegracaoService->reprocessar($arrOrderCourse['OrderCourse']['order_id'], $arrOrderCourse['OrderCourse']['course_id']);
                    $this->out($strPrefix . ' - <ok>OK</ok>');
                } else {
                    $this->out($strPrefix . '<warning>Esgotou o limite de ' . self::LIMITE_TENTATIVAS . ' tentativas.</warning>');

                    $arrOrderCourse['OrderCourse']['status_detran_id'] = StatusDetran::CANCELADO;
                    $arrOrderCourse['OrderCourse']['last_exec_detran'] = date('Y-m-d H:i:s');
                    $objOrderCourseModel = new OrderCourse();
                    $objOrderCourseModel->save(['OrderCourse' => $arrOrderCourse['OrderCourse']]);
                }
            } catch (Exception $exception) {
                $this->out($strPrefix . '<error>' . utf8_decode($exception->getMessage()) . '</error>');
            }
        }

        $this->out('Transmissao finalizada.');
    }
}
