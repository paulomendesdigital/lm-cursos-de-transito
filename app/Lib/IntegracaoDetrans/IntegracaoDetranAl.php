<?php

App::uses('IntegracaoBase', 'IntegracaoDetrans');
App::uses('CourseType', 'Model');

/**
 * Classe de Integração com o Detran AL
 * @author Douglas Gomes de Souza <douglas@dsconsultoria.com.br>
 * @copyright LM Cursos de Transito
 */

class IntegracaoDetranAl extends IntegracaoBase
{
    //HOMOLOGAÇÃO
    // const URL_WEBSERVICE_MATRICULA   = 'https://wshml01.detran.al.gov.br/wsstack/services/CFCNW020?wsdl';
    // const URL_WEBSERVICE_CERTIFICADO = 'https://wshml01.detran.al.gov.br/wsstack/services/CFCNW045?wsdl';

    //PRODUÇÃO
    const URL_WEBSERVICE_CONSULTA    = 'https://wsprd02.detran.al.gov.br/wsstack/services/CFCNW009?wsdl';
    const URL_WEBSERVICE_MATRICULA   = 'https://wsprd02.detran.al.gov.br/wsstack/services/CFCNW020?wsdl';
    const URL_WEBSERVICE_CERTIFICADO = 'https://wsprd02.detran.al.gov.br/wsstack/services/CFCNW045?wsdl';

    const OPERACAO_CONSULTA    = 1;
    const OPERACAO_MATRICULA   = 2;
    const OPERACAO_CERTIFICADO = 3;

    const COD_MATRICULA = 95710;
    const CPF_INSTRUTOR = 11287596754;

    const MSG_ERRO_DETRAN = 'No momento não foi possível consultar o DETRAN-AL';

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
            $this->prepareParamsMatricula($objParams);

            $arrReturn = $this->client(self::OPERACAO_MATRICULA, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '0'); //Processamento OK

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
            $this->prepareParamsMatricula($objParams);

            $arrReturn = $this->client(self::OPERACAO_MATRICULA, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '0'); //Processamento OK

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

            return ($arrReturn[0] === '0'); //Processamento OK

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
        $codigoCursoE = '20';

        if ($objParams->course_type_id == '5') {
            $codigoCursoE = '30';
        }

        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);

        switch ($strOperacao) {
            case self::OPERACAO_CONSULTA:
                $strUrl    = self::URL_WEBSERVICE_CONSULTA;
                $strMethod = 'CFCNW009';
                $strVarRet = 'DADOS_ALUNO';

                $arrParams = [
                    'CPF-E'       => $objParams->cpf,
                    'MATRICULA-E' => self::COD_MATRICULA
                ];

                break;

            case self::OPERACAO_MATRICULA:
                $strUrl    = self::URL_WEBSERVICE_MATRICULA;
                $strMethod = 'CFCNW020';
                $strVarRet = 'MATRICULA';

                $arrParams = [
                    'CPF-E'              => $objParams->cpf,
                    'CODIGO-CFC-E'       => $objParams->cod_cfc,
                    'TIPO-CURSO-E'       => 'T', //teórico
                    'CODIGO-CURSO-E'     => $codigoCursoE,
                    'CATEGORIA-CURSO-E'  => ' ', //vazio
                    'MATRICULA-E'        => self::COD_MATRICULA
                ];

                break;

            case self::OPERACAO_CERTIFICADO:
                $strUrl = self::URL_WEBSERVICE_CERTIFICADO;
                $strMethod = 'CFCNW045';
                $strVarRet = 'ENVIO_CURSO';

                $arrParams = [
                    'CPF-E'                     => $objParams->cpf,
                    'CERTIFICADO-E'             => $objParams->cod_cfc . '6' . $objParams->num_certificado,
                    'TIPO-CURSO-E'              => 'T', //teórico
                    'CATEGORIA-CURSO-E'         => ' ', //vazio
                    'DATA-INICIO-E'             => $objParams->data_matricula_detran,
                    'DATA-FINAL-E'              => date('Ymd'),
                    'CARGA-HORARIA-E'           => '32',
                    'CPF-INSTRUTOR-E'           => self::CPF_INSTRUTOR,
                    'CODIGO-CURSO-E'            => $codigoCursoE,
                    'CFC-E'                     => $objParams->cod_cfc,
                    'CNPJ-INSTITUICAO-ENSINO-E' => '18657198000146',
                    'MATRICULA-SISTEMA-E'       => self::COD_MATRICULA
                ];

                break;
            default:
                throw new Exception('Operação não disponível.');
        }

        if (!$this->verificaConexao($strUrl)) {
            throw new Exception(self::MSG_ERRO_DETRAN);
        }

        $client = new SoapClient($strUrl, [
            "trace"          => 1,
            "exceptions"     => true,
            'location'       => $strUrl,
            'stream_context' => stream_context_create([
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ])
        ]);

        $authvar = new SoapVar([
            'exs-rpc-password' => '',
            'exx-rpc-userID'   => '',
        ], SOAP_ENC_OBJECT);

        $header = new SoapHeader('urn:com.softwareag.entirex.xml.rt', 'EntireX', $authvar);
        $client->__setSoapHeaders($header);

        $arrDados = ['ENTRADA' => $arrParams];
        $this->updateLog(['dados_enviados' => $arrDados]);

        $result = $client->__soapCall($strMethod, [$arrDados]);

        if ($result) {

            $result = $this->objToArray($result);
            $this->updateLog(['dados_retornados' => $result]);


            if (isset($result[$strVarRet]['RETORNO']['CODIGO'])) {

                $strMensagem = isset($result[$strVarRet]['RETORNO']['MENSAGEM']) ? $result[$strVarRet]['RETORNO']['MENSAGEM'] : '';
                return [$result[$strVarRet]['RETORNO']['CODIGO'], $strMensagem];

            } else {

                throw new Exception('Não foi possível recuperar o retorno da transação');
            }
        } else {
            throw new Exception('Não foi possível recuperar o retorno da transação');
        }
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

        } catch (Exception $ex) {
            $this->updateLog(['mensagem_retorno' => $ex->getMessage()]);
            throw $ex;
        }
    }

    /**
     * Valida e Prepara os parâmetros para matricula
     * @param IntegracaoParams $objParams
     * @throws Exception|IntegracaoException
     */
    private function prepareParamsMatricula(IntegracaoParams $objParams)
    {
        try {
            $this->prepareParamsGeral($objParams);

            //CÓD. CFC
            if (empty($objParams->cod_cfc)) {
                throw new Exception("O campo 'cod_cfc' não foi informado ou é inválido.");
            }
            $objParams->cod_cfc = substr(str_pad($objParams->cod_cfc, 3, '0', STR_PAD_LEFT), 0, 3);

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

            //DATA INICIO
            if (empty($objParams->data_matricula_detran) || !date_create($objParams->data_matricula_detran)) {
                throw new Exception("O campo 'data_matricula_detran' não foi informado ou é inválido.");
            }
            $objParams->data_matricula_detran = date_create($objParams->data_matricula_detran)->format('Ymd');

            //CÓD. CFC
            if (empty($objParams->cod_cfc)) {
                throw new Exception("O campo 'cod_cfc' não foi informado ou é inválido.");
            }
            $objParams->cod_cfc = substr(str_pad($objParams->cod_cfc, 3, '0', STR_PAD_LEFT), 0, 3);

            //NUM CERTIFICADO
            if (empty($objParams->num_certificado)) {
                throw new Exception("O campo 'num_certificado' não foi informado ou é inválido.");
            }
            $objParams->num_certificado = substr(str_pad($objParams->num_certificado, 5, '0', STR_PAD_LEFT), 0, 5);

        } catch (Exception $ex) {
            $this->updateLog(['mensagem_retorno' => $ex->getMessage()]);
            throw $ex;
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
    }
}
