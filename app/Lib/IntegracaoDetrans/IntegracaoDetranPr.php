<?php

App::uses('IntegracaoBase', 'IntegracaoDetrans');
App::uses('CourseType', 'Model');

App::import('Vendor', 'autoload') or die ('Falha ao carregar bibliotecas');

/**
 * Classe de Integração com o Detran PR
 * @author Douglas Gomes de Souza <douglas@dsconsultoria.com.br>
 * @copyright LM Cursos de Transito
 */

class IntegracaoDetranPr extends IntegracaoBase
{
    //HOMOLOGAÇÃO
    //const URL_WEBSERVICE = 'http://homolog.wsutils.detran.pr.gov.br/detran-wsutils';
    //const KEY            = '319';
    //const SIGNATURE      = 'aa468b92020f85ba068b3c58c7051c9b';

    //PRODUÇÃO
    const URL_WEBSERVICE = 'http://www.wsutils.detran.pr.gov.br/detran-wsutils';
    const KEY            = '304572';
    const SIGNATURE      = 'e92b2f1891af3e160ed39f1f5491185e';


    const OPERACAO_CONSULTA    = 1;
    const OPERACAO_CERTIFICADO = 2;

    const COD_MATRICULA = 95710;
    const CPF_INSTRUTOR = 11287596754;

    const MSG_ERRO_DETRAN = 'No momento não foi possível consultar o DETRAN-PR';

    /**
     * Valida junto ao Sistema do Órgão de Trânsito se o condutor é publico alvo do referido curso.
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public function validar(IntegracaoParams $objParams)
    {
        $this->createLog('validar', ['parametros' => $objParams]);

        try {
            $this->prepareParamsConsulta($objParams);

            $arrReturn = $this->client(self::OPERACAO_CONSULTA, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] == true); //Processamento OK

        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;

        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }
    }

    /**
     * Consulta junto Sistema do Órgão de Trânsito as informações do condutor
     * @param IntegracaoParams $objParams
     * @return IntegracaoRetorno
     * @throws Exception
     */
    public function consultar(IntegracaoParams $objParams)
    {
        $this->createLog('consultar', ['parametros' => $objParams]);

        try { //na rotina consultar, se for erro de parâmetros retorna false em vez de exception
            $this->prepareParamsConsulta($objParams);
        }  catch (Exception $ex) {
            return $this->createRetorno(null, $ex->getMessage());
        }

        try {
            $arrRetorno = $this->client(self::OPERACAO_CONSULTA, $objParams);
            return $this->createRetorno($arrRetorno[0], $arrRetorno[1]);
        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }
    }

    /**
     * Matricula o Condutor no Órgão de Trânsito
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public function matricular(IntegracaoParams $objParams)
    {
        $this->createLog('matricular', ['parametros' => $objParams]);

        try {
            $this->prepareParamsConsulta($objParams);

            $arrReturn = $this->client(self::OPERACAO_CONSULTA, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] == true); //Processamento OK

        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;

        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }
    }

    /**
     * Envia o Crédito de Aula do Condutor no Órgão de Trânsito
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public function creditar(IntegracaoParams $objParams)
    {
        $this->createRetorno(null, 'Não implementado');
        return false;
    }

    /**
     * Envia o Sinal de Conclusão do Curso no Órgão de Trânsito
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public function concluir(IntegracaoParams $objParams)
    {
        $this->createLog('concluir', ['parametros' => $objParams]);

        try {
            $this->prepareParamsCertificado($objParams);

            $arrReturn = $this->client(self::OPERACAO_CERTIFICADO, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] == true); //Processamento OK

        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;

        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }
    }

    /**
     * @param $strOperacao
     * @param IntegracaoParams $objParams
     * @return array
     * @throws Exception
     */
    private function client($strOperacao, IntegracaoParams $objParams)
    {
        $result = null;

        switch ($strOperacao) {
            case self::OPERACAO_CONSULTA:

                $arrParams = [
                    'numRegCnh'      => $objParams->cnh,
                    'numCpf'         => $objParams->cpf,
                    'dataNascimento' => $objParams->birth
                ];

                $this->updateLog(['dados_enviados' => $arrParams]);

                try {
                    $strUrl = self::URL_WEBSERVICE . '/rest/servico/reciclagem/ead/certificado/verificar/' . implode('/', $arrParams);

                    /** @var \detran\restsecurity\Connection $connection */
                    /** @var \detran\restsecurity\ResponseImpl $result */
                    $connection = \detran\restsecurity\ConnectionFactory::getConnection(self::KEY, self::SIGNATURE);
                    $result     = $connection->get($strUrl);
                } catch (Exception $ex) {
                    throw new Exception('Não foi possível enviar a transação.', 0, $ex);
                }

                break;

            case self::OPERACAO_CERTIFICADO:

                $arrParams = [
                    'numCnpj'         => '18657198000146',
                    'numCpfInstrutor' => '11287596754',
                    'numRegCnh'       => $objParams->cnh,
                    'numCpfCondutor'  => $objParams->cpf,
                    'dataNascimento'  => $objParams->birth,
                    'dataInicioCurso' => $objParams->data_matricula_detran,
                    'dataFimCurso'    => date('d/m/Y')
                ];

                $this->updateLog(['dados_enviados' => $arrParams]);

                try {
                    $strUrl = self::URL_WEBSERVICE . '/rest/servico/reciclagem/ead/certificado/cadastrar';

                    /** @var \detran\restsecurity\Connection $connection */
                    /** @var \detran\restsecurity\ResponseImpl $result */
                    $connection = \detran\restsecurity\ConnectionFactory::getConnection(self::KEY, self::SIGNATURE);

                    foreach ($arrParams as $name => $val) {
                        $connection->addFormParam($name, $val);
                    }

                    $result = $connection->post($strUrl);
                } catch (Exception $ex) {
                    throw new Exception('Não foi possível enviar a transação.', 0, $ex);
                }

                break;

            default:
                throw new Exception('Operação não disponível.');
        }

        if ($result) {

            $this->updateLog(['dados_retornados' => ['httpCode' => $result->getHttpCode(), 'body' => $result->getBody()]]);

            if ($result->getHttpCode() != 200) {
                throw new Exception(self::MSG_ERRO_DETRAN);
            } else {
                $result = json_decode($result->getBody());
                return [$result->validacaoOk, $result->mensagens];
            }
        } else {
            throw new Exception('Não foi possível recuperar o retorno da transação');
        }
    }

    /**
     * Valida e Prepara os parâmetros para integração
     * @param IntegracaoParams $objParams
     * @throws IntegracaoException
     * @throws Exception
     */
    private function prepareParamsGeral(IntegracaoParams $objParams)
    {
        //CPF
        if (empty($objParams->cpf)) {
            throw new IntegracaoException("O campo CPF do aluno é obrigatório.");
        }
        $objParams->cpf = preg_replace('/\D/', '', trim($objParams->cpf));
        if (strlen($objParams->cpf) != 11) {
            throw new IntegracaoException("CPF inválido.");
        }

        //CNH
        if (empty($objParams->cnh)) {
            throw new Exception("O campo 'cnh' não foi informado ou é inválido.");
        }
        $objParams->cnh = preg_replace('/\D/', '', trim($objParams->cnh));
    }

    /**
     * Valida e Prepara os parâmetros para consulta
     * @param IntegracaoParams $objParams
     * @throws Exception|IntegracaoException
     */
    private function prepareParamsConsulta(IntegracaoParams $objParams)
    {
        try {
            $this->prepareParamsGeral($objParams);

            //DATA DE NASCIMENTO
            if (empty($objParams->birth) || strlen($objParams->birth) != 10) {
                throw new Exception("O campo 'birth' não foi informado ou é inválido.");
            }
            if (strpos($objParams->birth, '/')) {
                $arrData = explode('/', $objParams->birth);
                if (count($arrData) == 3 && checkdate($arrData[1], $arrData[0], $arrData[2])) {
                    $objParams->birth = implode('-', array_reverse($arrData));
                } else {
                    throw new Exception("O campo 'birth' é inválido.");
                }
            } elseif (strpos($objParams->birth, '-') != 4 || !date_create($objParams->birth)) {
                throw new Exception("O campo 'birth' é inválido.");
            }

        } catch (Exception $ex) {
            $this->updateLog(['mensagem_retorno' => $ex->getMessage()]);
            throw $ex;
        }
    }

    /**
     * Valida e Prepara os parâmetros para integração de Certificado
     * @param IntegracaoParams $objParams
     * @throws Exception|IntegracaoException
     */
    private function prepareParamsCertificado(IntegracaoParams $objParams)
    {
        try {
            $this->prepareParamsGeral($objParams);

            //DATA DE NASCIMENTO
            if (empty($objParams->birth) || strlen($objParams->birth) != 10) {
                throw new Exception("O campo 'birth' não foi informado ou é inválido.");
            }
            if (strpos($objParams->birth, '/')) {
                $arrData = explode('/', $objParams->birth);
                if (count($arrData) == 3 && checkdate($arrData[1], $arrData[0], $arrData[2])) {
                    $objParams->birth = implode('/', $arrData);
                } else {
                    throw new Exception("O campo 'birth' é inválido.");
                }
            } elseif (strpos($objParams->birth, '-') == 4 && date_create($objParams->birth)) {
                $objParams->birth = date_create($objParams->birth)->format('d/m/Y');
            } else {
                throw new Exception("O campo 'birth' é inválido.");
            }

            //DATA INICIO
            if (empty($objParams->data_matricula_detran) || !date_create($objParams->data_matricula_detran)) {
                throw new Exception("O campo 'data_matricula_detran' não foi informado ou é inválido.");
            }
            $objParams->data_matricula_detran = date_create($objParams->data_matricula_detran)->format('d/m/Y');

        } catch (Exception $ex) {
            $this->updateLog(['mensagem_retorno' => $ex->getMessage()]);
            throw $ex;
        }
    }
}
