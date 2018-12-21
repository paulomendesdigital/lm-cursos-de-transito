<?php
/**
 * Integracao Service
 * Faz a interface entre o sistema e as integrações com os órgãos de trânsito
 *
 * @author Douglas Gomes de Souza <douglas@dsconsultoria.com.br>
 * @copyright LM Cursos de Transito
 */

App::uses('IntegracaoRetorno', 'IntegracaoDetrans');
App::uses('IntegracaoParams', 'IntegracaoDetrans');
App::uses('IntegracaoException', 'IntegracaoDetrans');
App::uses('Course', 'Model');
App::uses('CourseType', 'Model');
App::uses('OrderCourse', 'Model');
App::uses('StatusDetran', 'Model');
App::uses('Payment', 'Model');
App::uses('UserCertificate', 'Model');
App::uses('UserModuleLog', 'Model');
App::uses('UserQuestion', 'Model');
App::uses('UserModuleSummary', 'Model');

class IntegracaoDetransService
{
    const HORA_INICIO_AULAS = 6;
    const HORA_FIM_AULAS    = 22;


    /**
     * @var IntegracaoRetorno
     */
    private $retorno = null;

    /**
     * Origem da Transmissão
     * @var string
     */
    private $origem;

    /**
     * Valida junto ao Sistema do Órgão de Trânsito se o condutor é publico alvo do referido curso.
     *
     * @param int      $courseId Id do Curso
     * @param int|null $stateId Id do Estado
     * @param int|null $cityId Id da Cidade
     * @param array    $parametros Parâmetros para serem validados pelo Órgão de Trânsito
     * @return boolean
     * @throws Exception|IntegracaoException
     */
    public function validar($courseId, $stateId = null, $cityId = null, array $parametros = null)
    {
        $arrCurso      = $this->getDadosCurso($courseId);
        $objIntegracao = $this->getIntegracao($arrCurso['Course'], $stateId, $cityId);

        if ($objIntegracao) {
            try {
                    
                return $objIntegracao->validar(IntegracaoParams::createFromArray(array_merge($arrCurso, $parametros)));

            } catch (Exception $exception) {
                throw $exception;
            } finally {
                $this->retorno = $objIntegracao->getRetorno();
            }
        } else {
            $this->retorno = new IntegracaoRetorno('OK', 'Curso não integrado');
            return true;
        }
    }

    /**
     * Consulta junto ao Sistema do Órgão de Trânsito se o condutor é publico alvo do referido curso.
     *
     * @param int $orderId   Id do Pedido
     * @param int $courseId  Id do Curso
     * @return IntegracaoRetorno
     * @throws Exception
     */
    public function consultar($orderId, $courseId)
    {
        $arrMatricula   = $this->getDadosMatricula($orderId, $courseId);
        $arrOrderCourse = $arrMatricula['OrderCourse'];

        $objIntegracao = $this->getIntegracao($arrMatricula['Course'], $arrOrderCourse['state_id'], $arrOrderCourse['citie_id']);

        if ($objIntegracao) {
            return $objIntegracao->consultar(IntegracaoParams::createFromArray($arrMatricula));
        } else {
            return new IntegracaoRetorno('OK', 'Curso não integrado');
        }
    }

    /**
     * Valida, Matricula e Conclui junto ao Sistema do Órgão de Trânsito de acordo com a situação do aluno
     *
     * @param int $orderId   Id do Pedido
     * @param int $courseId  Id do Curso
     * @throws Exception|IntegracaoException
     */
    public function reprocessar($orderId, $courseId)
    {
        $this->matricular($orderId, $courseId);
        $this->concluir($orderId, $courseId);
    }

    /**
     * Matricula o Condutor no Órgão de Trânsito
     *
     * @param int $orderId   Id do Pedido
     * @param int $courseId  Id do Curso
     * @throws Exception|IntegracaoException
     * @return boolean
     */
    public function matricular($orderId, $courseId)
    {
        $arrMatricula   = $this->getDadosMatricula($orderId, $courseId);
        
        $arrOrderCourse = $arrMatricula['OrderCourse'];

        $objIntegracao = $this->getIntegracao($arrMatricula['Course'], $arrOrderCourse['state_id'], $arrOrderCourse['citie_id']);

        if ($objIntegracao) {

            try {

                //VALIDA. SE AINDA NÃO FOI VALIDADO
                if ($arrOrderCourse['status_detran_id'] == StatusDetran::NAO_VALIDADO || $arrOrderCourse['status_detran_id'] == StatusDetran::ERRO) {
                    
                    $bolValido = $objIntegracao->validar(IntegracaoParams::createFromArray($arrMatricula));

                    $arrOrderCourse['status_detran_id']        = $bolValido ? StatusDetran::VALIDADO : StatusDetran::ERRO;
                    $arrOrderCourse['codigo_retorno_detran']   = $objIntegracao->getRetorno()->getCodigo();
                    $arrOrderCourse['mensagem_retorno_detran'] = $objIntegracao->getRetorno()->getMensagem();
                    $arrOrderCourse['data_status_detran']      = date('Y-m-d H:i:s');
                    $arrOrderCourse['retry_count_detran']      = $bolValido ? 0 : ($arrOrderCourse['retry_count_detran'] + 1);
                    $arrOrderCourse['last_exec_detran']        = date('Y-m-d H:i:s');

                    $objOrderCourseModel = new OrderCourse();
                    $objOrderCourseModel->save(['OrderCourse' => $arrOrderCourse]);
                }

                //EFETUA A MATRICULA se foi validado anterioremente e o pagamento for Aprovado ou Disponivel
                if ($arrOrderCourse['status_detran_id'] == StatusDetran::VALIDADO &&
                    ($arrMatricula['Order']['order_type_id'] == Payment::APROVADO || $arrMatricula['Order']['order_type_id'] == Payment::DISPONIVEL)) {

                    if ($objIntegracao->matricular(IntegracaoParams::createFromArray($arrMatricula))) {
                        $arrOrderCourse['status_detran_id']        = StatusDetran::MATRICULADO;
                        $arrOrderCourse['codigo_retorno_detran']   = $objIntegracao->getRetorno()->getCodigo();
                        $arrOrderCourse['mensagem_retorno_detran'] = $objIntegracao->getRetorno()->getMensagem();
                        $arrOrderCourse['data_status_detran']      = date('Y-m-d H:i:s');
                        $arrOrderCourse['data_matricula_detran']   = date('Y-m-d H:i:s');
                        $arrOrderCourse['retry_count_detran']      = 0;
                        $arrOrderCourse['last_exec_detran']        = date('Y-m-d H:i:s');

                        $objOrderCourseModel = new OrderCourse();
                        $objOrderCourseModel->save(['OrderCourse' => $arrOrderCourse]);
                        return true;
                    } else {
                        $arrOrderCourse['codigo_retorno_detran']   = $objIntegracao->getRetorno()->getCodigo();
                        $arrOrderCourse['mensagem_retorno_detran'] = $objIntegracao->getRetorno()->getMensagem();
                        $arrOrderCourse['data_status_detran']      = date('Y-m-d H:i:s');
                        $arrOrderCourse['last_exec_detran']        = date('Y-m-d H:i:s');
                        $arrOrderCourse['retry_count_detran']++;

                        $objOrderCourseModel = new OrderCourse();
                        $objOrderCourseModel->save(['OrderCourse' => $arrOrderCourse]);
                    }
                }

                return false;

            } catch (Exception $ex) {
                $this->retorno = $objIntegracao->getRetorno();

                $arrOrderCourse['status_detran_id']        = StatusDetran::ERRO;
                $arrOrderCourse['codigo_retorno_detran']   = $objIntegracao->getRetorno()->getCodigo();
                $arrOrderCourse['mensagem_retorno_detran'] = $objIntegracao->getRetorno()->getMensagem();
                $arrOrderCourse['data_status_detran']      = date('Y-m-d H:i:s');
                $arrOrderCourse['last_exec_detran']        = date('Y-m-d H:i:s');
                $arrOrderCourse['retry_count_detran']++;

                $objOrderCourseModel = new OrderCourse();
                $objOrderCourseModel->save(['OrderCourse' => $arrOrderCourse]);
                throw $ex;
            }
        }

        $this->retorno = new IntegracaoRetorno('OK', 'Curso não é integrado, aluno já foi matriculado ou não consultado.');
        return true;
    }

    /**
     * Comunica a Conclusão do Curso no Órgão de Trânsito
     *
     * @param int $orderId   Id do Pedido
     * @param int $courseId  Id do Curso
     * @throws Exception|IntegracaoException
     * @return boolean
     */
    public function concluir($orderId, $courseId)
    {
        $arrMatricula   = $this->getDadosMatricula($orderId, $courseId);
        $arrOrderCourse = &$arrMatricula['OrderCourse'];

        $objIntegracao = $this->getIntegracao($arrMatricula['Course'], $arrOrderCourse['state_id'], $arrOrderCourse['citie_id']);

        if ($objIntegracao) {

            //deve estar Matriculado ou Aguardando Conclusão para processar
            if ($arrOrderCourse['status_detran_id'] == StatusDetran::MATRICULADO || $arrOrderCourse['status_detran_id'] == StatusDetran::AGUARDANDO_CONCLUSAO) {

                $bolSave = false;
                try {
                    $arrCertificado = $this->getCertificado($orderId, $courseId);

                    //se já tem o certificado, altera o status para Aguardando Conclusão
                    if ($arrCertificado && $arrOrderCourse['status_detran_id'] == StatusDetran::MATRICULADO) {
                        $arrOrderCourse['status_detran_id']   = StatusDetran::AGUARDANDO_CONCLUSAO;
                        $arrOrderCourse['data_status_detran'] = date('Y-m-d H:i:s');
                        $bolSave = true;
                    }

                    //só faz a comunicação da conclusão enviou todos os créditos de aula e tem certificado
                    if ($this->creditar($orderId, $courseId, $arrMatricula) && $arrCertificado) {
                        $bolSave = true;

                        if ($objIntegracao->concluir(IntegracaoParams::createFromArray(array_merge($arrMatricula, $arrCertificado)))) {
                            $arrOrderCourse['status_detran_id']   = StatusDetran::CONCLUIDO;
                            $arrOrderCourse['data_status_detran'] = date('Y-m-d H:i:s');
                            $arrOrderCourse['retry_count_detran'] = 0;
                            return true;
                        } else {
                            $arrOrderCourse['retry_count_detran']++; //tentará novamente pelo cron
                            return false;
                        }

                    }

                } catch (Exception $ex) {
                    $arrOrderCourse['retry_count_detran']++;
                    $bolSave = true;
                    throw $ex;
                } finally {
                    $this->retorno = $objIntegracao->getRetorno();
                    if ($bolSave) {
                        if ($this->retorno) {
                            $arrOrderCourse['codigo_retorno_detran']   = $this->retorno->getCodigo();
                            $arrOrderCourse['mensagem_retorno_detran'] = $this->retorno->getMensagem();
                            $arrOrderCourse['data_status_detran']      = date('Y-m-d H:i:s');
                        }
                        $arrOrderCourse['last_exec_detran'] = date('Y-m-d H:i:s');
                        $objOrderCourseModel = new OrderCourse();
                        $objOrderCourseModel->save(['OrderCourse' => $arrOrderCourse]);
                    }
                }
            }
        }

        $this->retorno = new IntegracaoRetorno('OK', 'Curso não é integrado');
        return true;
    }


    /**
     * Envia o Crédito de Aula para o Órgão de Trânsito
     * @param int $orderId           Id do Pedido
     * @param int $courseId          Id do Curso
     * @param array $arrMatricula    Dados da Matricula
     * @return bool
     * @throws Exception|IntegracaoException
     */
    public function creditar($orderId, $courseId, $arrMatricula = [])
    {
        if (empty($arrMatricula)) {
            $arrMatricula = $this->getDadosMatricula($orderId, $courseId);
        }
        $arrOrderCourse = $arrMatricula['OrderCourse'];

        $objIntegracao = $this->getIntegracao($arrMatricula['Course'], $arrOrderCourse['state_id'], $arrOrderCourse['citie_id']);

        if ($objIntegracao) {

            //só faz a comunicação de crédito de aula se estiver com status de Matriculado ou Aguardando Conclusão
            if ($arrOrderCourse['status_detran_id'] == StatusDetran::MATRICULADO || $arrOrderCourse['status_detran_id'] == StatusDetran::AGUARDANDO_CONCLUSAO) {

                //CURSOS SERGIPE TEM CREDITO DE HORAS
                if ($arrOrderCourse['state_id'] == State::SERGIPE) {

                    $bolSave = false;
                    try {
                        $arrCreditoHoras = $this->getDadosCreditoHoras($orderId);

                        $bolRetry            = false;
                        $intCountModules     = count($arrCreditoHoras);
                        $intCountSentModules = 0;

                        foreach ($arrCreditoHoras as $arrHorasModulo) {
                            $arrModulo = $arrHorasModulo['Module'];

                            //Se o total de horas executadas for maior ou igual a carga horária do módulo
                            if ($arrHorasModulo['total'] > 0 && $arrHorasModulo['total'] >= $arrModulo['value_time'] * 60) {

                                foreach ($arrHorasModulo['dates'] as $strData => $arrDisciplines) {
                                    if ($strData <= date('Y-m-d')) { //não processa datas futuras
                                        foreach ($arrDisciplines as $arrDiscipline) {
                                            if ($arrDiscipline['count_sent'] < $arrDiscipline['count_total']) {
                                                $arrParams = IntegracaoParams::createFromArray(array_merge($arrMatricula, $arrModulo, $arrDiscipline));
                                                if ($objIntegracao->creditar($arrParams)) {

                                                    if (isset($arrDiscipline['is_exam'])) {
                                                        $objUserQuestion     = new UserQuestion();
                                                        $objUserQuestion->id = $arrDiscipline['id'];
                                                        if (!$objUserQuestion->saveField('sent_to_detran', 1)) {
                                                            throw new Exception('Erro ao salvar flag de envio paro detran');
                                                        }
                                                    } else {
                                                        $objModuleLog = new UserModuleLog();
                                                        if (!$objModuleLog->updateAll(['UserModuleLog.sent_to_detran' => 1], ['UserModuleLog.id' => $arrDiscipline['logs']])) {
                                                            throw new Exception('Erro ao salvar flag de envio paro detran');
                                                        }
                                                    }

                                                } else {
                                                    $bolRetry = true;
                                                    break 3;
                                                }
                                            }
                                        }
                                    } else {
                                        $bolRetry = true;
                                        break 2;
                                    }
                                }

                                $intCountSentModules++; //modulo concluído e enviado

                            } else {
                                break;
                            }
                        }

                        //se todos os módulos foram enviados, altera o status
                        if ($intCountModules > 0 && $intCountSentModules == $intCountModules) {
                            $arrOrderCourse['retry_count_detran'] = 0;
                            $bolSave = true;
                            return true;
                        } else {
                            if ($bolRetry) {
                                $arrOrderCourse['retry_count_detran']++;
                                $bolSave = true;
                            } elseif ($arrOrderCourse['retry_count_detran'] != 0) {
                                $arrOrderCourse['retry_count_detran'] = 0;
                                $bolSave = true;
                            }
                        }

                        return false;

                    } catch (Exception $ex) {
                        $arrOrderCourse['retry_count_detran']++;
                        $bolSave = true;
                        throw $ex;
                    } finally {
                        $this->retorno       = $objIntegracao->getRetorno();
                        if ($bolSave) {
                            $arrOrderCourse['last_exec_detran'] = date('Y-m-d H:i:s');
                            $objOrderCourseModel                = new OrderCourse();
                            $objOrderCourseModel->save(['OrderCourse' => $arrOrderCourse]);
                        }
                    }

                //CURSOS RJ NÃO TEM CRÉDITOS DE HORAS
                } else {
                    return true;
                }
            }
            return false;
        }

        $this->retorno = new IntegracaoRetorno('OK', 'Curso não é integrado');
        return true;
    }

    /**
     * Retorno da Última Chamada
     * @return IntegracaoRetorno
     */
    public function getRetorno()
    {
        return $this->retorno;
    }

    /**
     * Integração Factory
     * Retorna a classe concreta de integração de acordo com o tipo de curso, estado e cidade
     *
     * @param array $arrCourse
     * @param null $stateId
     * @param null $cityId
     * @return IntegracaoBase|null
     * @throws Exception|IntegracaoException
     */
    public function getIntegracao(array $arrCourse, $stateId = null, $cityId = null)
    {
        try {
            if (!array_key_exists('course_type_id', $arrCourse)) {
                throw new Exception('Não foi possível identificar o tipo de curso.');
            }

            if (!array_key_exists('detran_validation', $arrCourse)) {
                throw new Exception('Não foi possível identificar a validação do curso.');
            }

            if (!$arrCourse['detran_validation']) {
                return null; //CURSO NÃO TEM INTEGRAÇÃO
            }

            $courseTypeId = $arrCourse['course_type_id'];

            //CURSOS DE RECICLAGEM RJ
            if ($courseTypeId == CourseType::RECICLAGEM && $stateId == State::RIO_DE_JANEIRO) {
                App::uses('IntegracaoDetranRj', 'IntegracaoDetrans');
                return new IntegracaoDetranRj($this->origem);

            //CURSOS DE RECICLAGEM E ESPECIALIZADOS SERGIPE
            } elseif (($courseTypeId == CourseType::RECICLAGEM || $courseTypeId == CourseType::ESPECIALIZADOS) && $stateId == State::SERGIPE) {
                App::uses('IntegracaoDetranSe', 'IntegracaoDetrans');
                return new IntegracaoDetranSe($this->origem);

            //CURSOS DE RECICLAGEM ALAGOAS
            } elseif ($courseTypeId == CourseType::RECICLAGEM && $stateId == State::ALAGOAS) {
                App::uses('IntegracaoDetranAl', 'IntegracaoDetrans');
                return new IntegracaoDetranAl($this->origem);

            //CURSOS DE ATUALIZAÇÃO ALAGOAS
            } elseif ($courseTypeId == CourseType::ATUALIZACAO && $stateId == State::ALAGOAS) {
                App::uses('IntegracaoDetranAl', 'IntegracaoDetrans');
                return new IntegracaoDetranAl($this->origem);

            //CURSOS DE RECICLAGEM PARANÁ
            } elseif ($courseTypeId == CourseType::RECICLAGEM && $stateId == State::PARANA) {
                App::uses('IntegracaoDetranPr', 'IntegracaoDetrans');
                return new IntegracaoDetranPr($this->origem);
	
            //CURSOS DE RECICLAGEM MARANHÃO
            } elseif ($courseTypeId == CourseType::RECICLAGEM && $stateId == State::MARANHAO) {
                App::uses('IntegracaoDetranMa', 'IntegracaoDetrans');
                return new IntegracaoDetranMa($this->origem);
            
            //CURSOS DE RECICLAGEM GOIÁS
            } elseif ($courseTypeId == CourseType::RECICLAGEM && $stateId == State::GOIAS) {
                App::uses('IntegracaoDetranGo', 'IntegracaoDetrans');
                return new IntegracaoDetranGo($this->origem);

            //CURSOS DE RECICLAGEM OU ESPECIALIZADOS DE OUTROS ESTADOS
            } elseif ($courseTypeId == CourseType::RECICLAGEM || $courseTypeId == CourseType::ESPECIALIZADOS) {
                throw new IntegracaoException('Este curso ainda não está disponível na sua região.');
            } else {
                return null; //Se o curso não tem integração, não deve retornar nada, nem exception
            }
        } catch (Exception $ex) {
            $this->retorno = new IntegracaoRetorno('Erro', $ex->getMessage());
            throw $ex;
        }
    }

    /**
     * Retorna os Dados do Curso para a integração
     * @param int $courseId Id do Curso
     * @return array
     */
    private function getDadosCurso($courseId) {
        $objCourseModel = new Course();
        $objCourseModel->Behaviors->load('Containable');
        return $objCourseModel->find('first', [
            'recursive' => false,
            'conditions' => ['Course.id' => $courseId],
            'fields' => ['id', 'course_type_id', 'detran_validation', 'course_code_id'],
            'contain' => [
                'CourseCode' => [
                    'fields' => ['id', 'code as course_code', 'name']
                ]
            ]
        ]);
    }

    /**
     * Retorna os Dados da Matrícula para a integração
     * @param int $orderId Id do Pedido
     * @param int $courseId Id do Curso
     * @return array
     * @throws Exception
     */
    private function getDadosMatricula($orderId, $courseId) {
        $objOrderCourseModel = new OrderCourse();
        $objOrderCourseModel->Behaviors->load('Containable');

        $result = $objOrderCourseModel->find('first', [
            'conditions' => ['OrderCourse.order_id' => $orderId, 'OrderCourse.course_id' => $courseId],
            'fields' => ['id', 'order_id', 'course_id', 'citie_id', 'state_id', 'status_detran_id', 'codigo_retorno_detran', 'mensagem_retorno_detran', 'data_matricula_detran', 'retry_count_detran', 'renach', 'cnh', 'cnh_category', 'tipo_reciclagem'],
            'contain' => [
                'Course' => [
                    'fields' => ['id', 'course_type_id', 'detran_validation', 'max_time', 'course_code_id'],
                    'CourseCode' => [
                        'fields' => ['id', 'code as course_code', 'name']
                    ]
                ],
                'Order' => [
                    'fields' => ['id', 'order_type_id', 'user_id'],
                    'User' => [
                        'fields' => ['id', 'cpf'],
                        'School' => [
                            'fields' => ['id', 'cod_cfc']
                        ],
                        'Student' => [
                            'fields' => ['id', 'birth']
                        ]
                    ]
                ]
            ]
        ]);

        if (empty($result)) {
            throw new Exception('Não foi possível encontrar os dados referente a matrícula');
        }

        $result['OrderCourse']['order_courses_id'] = $result['OrderCourse']['id'];

        return $result;
    }

    /**
     * Retorna os Dados do Certificado para a integração
     * @param int $orderId   Id do Pedido
     * @param int $courseId  Id do Curso
     * @return array
     */
    private function getCertificado($orderId, $courseId) {
        $objModelUserCertificate = new UserCertificate();
        $objModelUserCertificate->Behaviors->load('Containable');
        $arrCertificate = $objModelUserCertificate->find('first', [
            'fields' => ['id as num_certificado', 'start as data_inicio', 'finish as data_fim'],
            'contain' => [
                'UserCertificateModule'
            ],
            'conditions' => [
                'UserCertificate.order_id'  => $orderId,
                'UserCertificate.course_id' => $courseId
            ]
        ]);

        if ($arrCertificate) {
            $arrCertificate['workload'] = $objModelUserCertificate->__getTotalWorkload($arrCertificate['UserCertificateModule']);
        }
        return $arrCertificate;
    }

    private function getDateGroupTimes($arrGroup, $arrRow) {
        if (isset($arrGroup['start'])) {
            $intStart = $arrGroup['start'];
            $intTime  = $arrGroup['total_time'] + $arrRow['time'];
        } else {
            $intStart = $arrRow['datetime'];
            $intTime  = $arrRow['time'];
        }
        $intFinish = $intStart + $intTime * 60;

        return [$intTime, $intStart, $intFinish];
    }

    /**
     * Retorna os Dados para Crédito de Horas com base nos registros de UserModuleLog
     * @param $orderId
     * @return array
     */
    public function getDadosCreditoHoras($orderId)
    {
        $objSummary = new UserModuleSummary();
        $objSummary->Behaviors->load('Containable');

        //recupera todos os módulos da grade de estudos e agrupa por módulo e disciplina
        $arrModules = $objSummary->find('all', [
            'recursive' => false,
            'contain'    => [
                'Module' => ['fields' => ['id', 'name', 'value_time']],
                'ModuleDiscipline' => [
                    'fields' => ['id', 'name', 'discipline_code_id', 'value_time', 'module_discipline_slider_count', 'module_discipline_player_count'],
                    'DisciplineCode'
                ]
            ],
            'conditions' => ['UserModuleSummary.order_id' => $orderId, 'Module.is_introduction' => 0],
        ]);

        $arrResult = [];
        foreach ($arrModules as $arrRow) {
            if (isset($arrRow['ModuleDiscipline']['DisciplineCode']['id'])) {

                $arrGroupModule           = &$arrResult[$arrRow['Module']['id']];
                $arrGroupModule['Module'] = $arrRow['Module'];
                $arrGroupModule['total']  = 0;
                $arrGroupModule['dates']  = [];

                $arrGroupDiscipline = &$arrGroupModule['disciplines'][$arrRow['ModuleDiscipline']['id']];
                $arrGroupDiscipline['ModuleDiscipline'] = $arrRow['ModuleDiscipline'];

                $arrGroupDiscipline['value_count']  = $arrRow['ModuleDiscipline']['module_discipline_slider_count'] + $arrRow['ModuleDiscipline']['module_discipline_player_count'];

                $arrGroupDiscipline['logs'] = [];
            }
        }
        if (isset($arrGroupDiscipline)) {
            unset($arrGroupDiscipline);
            unset($arrGroupModule);
        }

        //recupera o log de estudos
        $objModuleLog = new UserModuleLog();
        $objModuleLog->Behaviors->load('Containable');

        $arrLogs = $objModuleLog->find('all', [
            'recursive'  => false,
            'conditions' => ['UserModuleLog.order_id' => $orderId],
            'fields'     => ['id', 'module_id', 'module_discipline_id', 'time', 'created', 'sent_to_detran'],
            'order'      => ['created']
        ]);

        //associa o log a disciplina
        foreach ($arrLogs as $arrRow) {
            $intModuleId     = $arrRow['UserModuleLog']['module_id'];
            $intDisciplineId = $arrRow['UserModuleLog']['module_discipline_id'];
            if (isset($arrResult[$intModuleId]['disciplines'][$intDisciplineId])) {
                $arrResult[$intModuleId]['disciplines'][$intDisciplineId]['logs'][] = $arrRow['UserModuleLog'];
            }
        }

        //agrupa por carga horária
        $intLastFinish = null;
        foreach ($arrResult as $intModuleId => &$arrModule) {
            $arrDates = &$arrModule['dates'];
            foreach ($arrModule['disciplines'] as &$arrDiscipline) {

                if (count($arrDiscipline['logs']) >= $arrDiscipline['value_count']) { //SE COMPLETOU TODOS OS SLIDES

                    $arrFirstLog = $arrDiscipline['logs'][0];

                    $strDate     = substr($arrFirstLog['created'], 0, 10);
                    $intDate     = strtotime($strDate);
                    $intMinTime  = $intDate + self::HORA_INICIO_AULAS * 3600;
                    $intMaxTime  = $intDate + self::HORA_FIM_AULAS * 3600;
                    $intNextDate = $intDate + 86400;
                    $intNextTime = $intNextDate + self::HORA_INICIO_AULAS * 3600;

                    $arrRow['datetime'] = strtotime(substr($arrFirstLog['created'], 0, 16));
                    $arrRow['time']     = $arrDiscipline['ModuleDiscipline']['value_time'] * 60;

                    //se o registro for antes do horário inicial, altera para o horário inicial
                    if ($arrRow['datetime'] < $intMinTime) {
                        $arrRow['datetime'] = $intMinTime;
                    }

                    if ($arrRow['datetime'] <= $intLastFinish) {
                        $arrRow['datetime'] = $intLastFinish + 60;
                    }

                    $strGroupKey = $strDate . '-' . $arrDiscipline['ModuleDiscipline']['DisciplineCode']['id'];

                    $arrGroup = &$arrDates[$strDate][$strGroupKey];
                    list($intTime, $intStart, $intFinish) = $this->getDateGroupTimes($arrGroup, $arrRow);

                    $intLimiter = 0;
                    while ($intFinish > $intMaxTime && $intLimiter < 7) {
                        if (empty($arrGroup)) {
                            unset($arrDates[$strDate][$strGroupKey]);
                        }

                        $arrGroup           = &$arrDates[date('Y-m-d', $intNextDate)][$strGroupKey];
                        $arrRow['datetime'] = $intNextTime;
                        if ($arrRow['datetime'] <= $intLastFinish) {
                            $arrRow['datetime'] = $intLastFinish + 60;
                        }
                        list($intTime, $intStart, $intFinish) = $this->getDateGroupTimes($arrGroup, $arrRow);

                        $intDate     = $intNextDate;
                        $strDate     = date('Y-m-d', $intDate);
                        $intNextDate = $intDate + 86400;
                        $intNextTime = $intNextDate + self::HORA_INICIO_AULAS * 3600;
                        $intMaxTime  = $intDate + self::HORA_FIM_AULAS * 3600;

                        $intLimiter++;
                    }

                    $intLastFinish = $intFinish;

                    $arrGroup['start']      = $intStart;
                    $arrGroup['finish']     = $intFinish;
                    $arrGroup['total_time'] = $intTime;

                    $arrGroup['discipline_code'] = $arrDiscipline['ModuleDiscipline']['DisciplineCode']['code'];
                    $arrGroup['discipline_name'] = $arrDiscipline['ModuleDiscipline']['DisciplineCode']['name'];
                    $arrGroup['inicio_aula']     = $intStart;
                    $arrGroup['fim_aula']        = $intFinish;
                    $arrGroup['time']            = $intTime;

                    foreach ($arrDiscipline['logs'] as $arrLog) {
                        $intOriginalTimeCreated       = strtotime($arrLog['created']);
                        $arrGroup['real_inicio_aula'] = isset($arrGroup['real_inicio_aula']) ? min($arrGroup['real_inicio_aula'], $intOriginalTimeCreated) : $intOriginalTimeCreated;
                        $arrGroup['real_fim_aula']    = isset($arrGroup['real_fim_aula']) ? max($arrGroup['real_fim_aula'], $intOriginalTimeCreated) : $intOriginalTimeCreated;
                        $arrGroup['logs'][$arrLog['id']] = ['id' => $arrLog['id'], 'sent_to_detran' => $arrLog['sent_to_detran']];
                    }

                    if (empty($arrDates[$strDate])) { //limpa bloco vazio
                        unset($arrDates[$strDate]);
                    }

                    unset($arrGroup);
                }
            }
            unset($arrDiscipline);
            unset($arrModule['disciplines']);

            //insere a prova por último
            if (!empty($arrDates)) {

                $arrProva = $this->getQtdAcertosProva($orderId, $intModuleId);
                if ($arrProva) {

                    end($arrDates);
                    $strLastDate = key($arrDates);

                    $intDate     = strtotime($strLastDate);
                    $intMaxTime  = $intDate + self::HORA_FIM_AULAS * 3600;
                    $intNextDate = $intDate + 86400;
                    $intNextTime = $intNextDate + self::HORA_INICIO_AULAS * 3600;

                    $arrLastDiscipline = end($arrDates[$strLastDate]);

                    $intStart  = $arrLastDiscipline['finish'] + 60;
                    $intFinish = $intStart + $arrProva['time'] * 60;

                    if ($intFinish > $intMaxTime) {
                        $strLastDate = date('Y-m-d', $intNextDate);
                        $intStart    = $intNextTime;
                    }
                    $arrProva['inicio_aula'] = $intStart;
                    $arrProva['fim_aula']    = $intFinish;

                    $arrDates[$strLastDate][] = $arrProva;
                }
            }

            unset($arrDates);
        }
        unset($arrModule);

        //formata a saida
        foreach ($arrResult as &$arrModule) {
            $arrModule['total'] = 0;
            foreach ($arrModule['dates'] as &$arrDisciplines) {
                foreach ($arrDisciplines as &$arrDiscipline) {

                    $arrModule['total'] += $arrDiscipline['time'];

                    //date time
                    foreach (['inicio_aula', 'fim_aula', 'real_inicio_aula', 'real_fim_aula'] as $key) {
                        if (isset($arrDiscipline[$key])) {
                            $arrDiscipline[$key] = date('Y-m-d H:i:s', $arrDiscipline[$key]);
                        }
                    }

                    //contagem transmitidos
                    $intCountSent = 0;
                    if (isset($arrDiscipline['logs'])) {
                        foreach ($arrDiscipline['logs'] as &$arrLog) {
                            if ($arrLog['sent_to_detran']) {
                                $intCountSent++;
                            }
                            $arrLog = $arrLog['id'];
                        }
                        $arrDiscipline['count_sent']  = $intCountSent;
                        $arrDiscipline['count_total'] = count($arrDiscipline['logs']);
                    } elseif (array_key_exists('sent_to_detran', $arrDiscipline)) {
                        $arrDiscipline['count_sent']  = $arrDiscipline['sent_to_detran'] ? 1 : 0;
                        $arrDiscipline['count_total'] = 1;
                    }

                    unset($arrDiscipline);
                }
                unset($arrDisciplines);
            }
            unset($arrModule);
        }

        return $arrResult;
    }

    /**
     * Recupera a Quantidade de Acertos na Prova de um módulo
     * @param $orderId
     * @param $moduleId
     * @return mixed
     */
    private function getQtdAcertosProva($orderId, $moduleId)
    {
        $objUserQuestion = new UserQuestion();
        $arrResult = $objUserQuestion->query("SELECT uq.id, dc.code, dc.name, dc.hours, uq.sent_to_detran, uq.created, COUNT(qu.id) as acertos
            FROM user_questions uq
            INNER JOIN user_question_options uqo ON uqo.user_question_id = uq.id
            INNER JOIN question_alternative_option_users qu ON qu.id = uqo.question_alternative_option_user_id
            INNER JOIN question_alternatives qa ON qu.question_alternative_id = qa.id
            INNER JOIN modules m ON qa.module_id = m.id
            INNER JOIN discipline_codes dc ON dc.id = m.exam_discipline_code_id
            WHERE
            uq.order_id = '$orderId' AND qa.module_id = '$moduleId' AND uq.model = 'Module' AND uq.result = 1 AND qu.correct = 1
            GROUP BY qa.module_id
            ORDER BY uq.id DESC
            LIMIT 1");

        if (isset($arrResult[0]['dc'])) {
            return [
                'id'               => $arrResult[0]['uq']['id'],
                'discipline_code'  => $arrResult[0]['dc']['code'],
                'discipline_name'  => $arrResult[0]['dc']['name'],
                'time'             => $arrResult[0]['dc']['hours'] * 60,
                'real_inicio_aula' => strtotime($arrResult[0]['uq']['created']),
                'real_fim_aula'    => strtotime($arrResult[0]['uq']['created']) + $arrResult[0]['dc']['hours'] * 3600,
                'acertos'          => $arrResult[0][0]['acertos'],
                'is_exam'          => true,
                'sent_to_detran'   => $arrResult[0]['uq']['sent_to_detran']
            ];
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * @param string $origem
     */
    public function setOrigem($origem)
    {
        $this->origem = $origem;
    }

}
