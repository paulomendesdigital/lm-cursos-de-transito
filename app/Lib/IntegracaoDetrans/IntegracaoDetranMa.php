<?php

App::uses('IntegracaoBase', 'IntegracaoDetrans');
App::uses('CourseType', 'Model');

/**
 * Classe de Integração com o Detran MA
 * @author Douglas Gomes de Souza <douglas@dsconsultoria.com.br>
 * @copyright LM Cursos de Transito
 */

class IntegracaoDetranMa extends IntegracaoBase
{
    //HOMOLOGAÇÃO
    // const URL_WEBSERVICE_CERTIFICADO = 'http://wsdesenwebapp.detran.ma.gov.br:10010/wsstack/services/wsRegistroCursoEAD_dsv?wsdl';

    //PRODUÇÃO
    const URL_WEBSERVICE_CERTIFICADO = 'http://wsprodwebapp.detran.ma.gov.br:10010/wsstack/services/wsRegistroCursoEAD?wsdl';

    const USUARIO_WEBSERVICE = 'LMCTRANSITO';
    const SENHA_WEBSERVICE   = 'LMCT#92018';

    const OPERACAO_CERTIFICADO = 3;

     const MSG_ERRO_DETRAN = 'No momento não foi possível consultar o DETRAN-MA';

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
            return $this->createRetorno(null, null);
        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }
    }

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
            $this->createRetorno(null, null);

            return true;

        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;

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
            $this->createRetorno(null, null);

            return true;

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

            return ($arrReturn[0] === '1'); //Processamento OK

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
        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);

        switch ($strOperacao) {
            case self::OPERACAO_CERTIFICADO:
                $strUrl    = self::URL_WEBSERVICE_CERTIFICADO;

                $arrParams = [
                    'WSIN_CPF_ALUNO'        => $objParams->cpf,
                    'WSIN_CODIGO_CURSO'     => 20, //reciclagem de infrator
                    'WSIN_DATA_INICIO'      => $objParams->data_matricula_detran, //YYYYMMDD
                    'WSIN_DATA_FIM'         => date('Ymd'), //vazio
                    'WSIN_CERTIFICADO'      => $objParams->num_certificado,
                    'WSIN_CATEGORIA'        => '',
                    'WSIN_CARGA_HORARIA'    => 30,
                    'WSIN_CODIGO_MUNICIPIO' => '09373',
                    'WSIN_DATA_VALIDADE'    => 0,
                    'WSIN_CPF_INSTRUTOR'    => '11287596754',
                    'WSIN_CNPJ_ENTIDADE'    => '18657198000146',
                    'WSIN_USUARIO'          => self::USUARIO_WEBSERVICE,
                    'WSIN_SENHA'            => self::SENHA_WEBSERVICE
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

        $this->updateLog(['dados_enviados' => $arrParams]);

        $result = $client->__soapCall('NJXHNEAD', [$arrParams]);

        if ($result) {

            $result = $this->objToArray($result);
            $this->updateLog(['dados_retornados' => $result]);

            if (isset($result['WSOUT_EXEC'])) {

                $strMensagem = isset($result['WSOUT_MSG']) ? $result['WSOUT_MSG'] : '';
                return [$result['WSOUT_EXEC'], $strMensagem];

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
            throw new IntegracaoException("O campo CPF do condutor é obrigatório.");
        }

        $objParams->cpf = preg_replace('/\D/', '', trim($objParams->cpf));
        if (strlen($objParams->cpf) != 11) {
            throw new IntegracaoException("CPF inválido.");
        }

    }
}
