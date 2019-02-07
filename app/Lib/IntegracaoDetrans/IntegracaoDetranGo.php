<?php

App::uses('IntegracaoBase', 'IntegracaoDetrans');
App::uses('CourseType', 'Model');

/**
 * Classe de Integração com o Detran GO
 * @author Douglas Gomes de Souza <douglas@dsconsultoria.com.br>
 * @copyright LM Cursos de Transito
 */

class IntegracaoDetranGo extends IntegracaoBase
{
    //**************************************************************************************************************************** */
    //HOMOLOGAÇÃO
    // const URL_WEBSERVICE_TOKEN              = 'https://servicoshomolog.detran.go.gov.br/token';
    // const URL_WEBSERVICE_CONSULTA           = 'https://servicoshomolog.detran.go.gov.br/gtih/ws/rest/reciclagem/v1.0.0/get/permite/';
    // const URL_WEBSERVICE_CERTIFICADO        = 'https://servicoshomolog.detran.go.gov.br/gtih/ws/rest/reciclagem/v1.0.0/post/enviaCurso';
    // const URL_WEBSERVICE_VERIFICA_CERTIFICADO  = 'https://servicoshomolog.detran.go.gov.br/gtih/ws/rest/reciclagem/v1.0.0/get/certificado/';

    // const CLIENT_KEY    = 'eGCTqJsaQjOrw__3lboqh3s3go8a';
    // const CLIENT_SECRET = 'oSlI3FUOeelzy8QBCgIrbKx5eeoa';

    // const CNPJ_CFC = '05784754000101';
    // const CPF_INSTRUTOR = '24258806153';
    //**************************************************************************************************************************** */


    //**************************************************************************************************************************** */
    //PRODUÇÃO
    const URL_WEBSERVICE_TOKEN               = 'https://services.detran.go.gov.br/token';
    const URL_WEBSERVICE_CONSULTA            = 'https://services.detran.go.gov.br/gtih/reciclagem/v1.0.0/get/permite/';
    const URL_WEBSERVICE_CERTIFICADO         = 'https://services.detran.go.gov.br/gtih/reciclagem/v1.0.0/post/enviaCurso/';
    const URL_WEBSERVICE_PRINT_CERTIFICADO   = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

    const CLIENT_KEY    = 'qhzq7hYsP9ZEfjfMm0AZ7n1tzRYa';
    const CLIENT_SECRET = 'DDKivA0xbm4VeBXHSK9jrilurCga';

    const CNPJ_CFC = '18657198000146';
    const CPF_INSTRUTOR = '11287596754';
    //**************************************************************************************************************************** */

    

    const OPERACAO_CONSULTA    = 1;
    const OPERACAO_CERTIFICADO = 2;
    const OPERACAO_VERIFICA_CERTIFICADO = 3;

    const MSG_ERRO_DETRAN = 'No momento não foi possível consultar o DETRAN-GO';

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

            $token = $this->getDynamicToken();

            $arrReturn = $this->client(self::OPERACAO_CONSULTA, $token, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '001' && $objParams->tipo_reciclagem == 1 || $arrReturn[0] == '002' && $objParams->tipo_reciclagem = 2); //Processamento OK

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
            $token = $this->getDynamicToken();

            $arrRetorno = $this->client(self::OPERACAO_CONSULTA, $token, $objParams);
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

            $token = $this->getDynamicToken();

            $arrReturn = $this->client(self::OPERACAO_CONSULTA, $token, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '001' && $objParams->tipo_reciclagem == 1 || $arrReturn[0] == '002' && $objParams->tipo_reciclagem = 2); //Processamento OK

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

            $token = $this->getDynamicToken();

            $arrReturn = $this->client(self::OPERACAO_CERTIFICADO, $token, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '000'); //Processamento OK

        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;

        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }
    }

    /**
     * Envia o Sinal de Conclusão do Curso no Órgão de Trânsito
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public function verificarCertificado(IntegracaoParams $objParams)
    {
        $this->createLog('verificar', ['parametros' => $objParams]);

        try {
            $this->prepareParamsCertificado($objParams);

            $token = $this->getDynamicToken();

            $arrReturn = $this->client(self::OPERACAO_VERIFICA_CERTIFICADO, $token, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '020'); //Processamento OK

        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;

        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getDynamicToken()
    {
        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, self::URL_WEBSERVICE_TOKEN);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($handle, CURLOPT_HTTPHEADER, $this->getHashToToken(self::CLIENT_KEY, self::CLIENT_SECRET));

        //$return RECEBE O TOKEN DE ACESSO
        $return = curl_exec($handle);
        $return = json_decode($return, true);
        
        curl_close($handle);

        if (!$return) {
            throw new IntegracaoException(self::MSG_ERRO_DETRAN);
        }

        return $return['access_token'];
    }
    
    private function getHashToToken($clientKey, $clientSecret) {
        $hashToken = base64_encode($clientKey.':'.$clientSecret);
        
        $headerToken = array('Authorization: Basic ' . $hashToken);

        return $headerToken;
    }

    private function client($strOperacao, $token, IntegracaoParams $objParams)
    {
        switch ($strOperacao) {
            case self::OPERACAO_CONSULTA:
                $strUrl    = self::URL_WEBSERVICE_CONSULTA . $objParams->cnh;

                $this->updateLog(['dados_enviados' => ['registro' => $objParams->cnh]]);

                $handle = curl_init($strUrl);

                curl_setopt($handle, CURLOPT_HTTPHEADER, ['Accept: application/xml', 'Authorization: Bearer ' . $token]);
                
                curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($handle, CURLOPT_TIMEOUT, 20);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST,false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER,false);
                $return = curl_exec($handle);
                curl_close($handle);
                if (!$return) {
                    throw new IntegracaoException(self::MSG_ERRO_DETRAN);
                }

                break;

            case self::OPERACAO_CERTIFICADO:
                $strUrl = self::URL_WEBSERVICE_CERTIFICADO;

                $arrParams = [
                    'registro'      => $objParams->cnh,
                    'tipoCurso'     => $objParams->tipo_reciclagem,  //1 - Recilagem Preventiva, 2 - Reciclagem Infrator
                    'dataInicio'    => $objParams->data_matricula_detran, //Data Inicio do Curso - YYYYMMDD
                    'dataFim'       => date('Ymd'), //Data Fim do Curso - YYYYMMDD
                    'duracaoAula'   => 30, //Duracao de Horas do Curso
                    'cnpjCfc'       => self::CNPJ_CFC, //Cnpj do CFC
                    'cpfInstrutor'  => self::CPF_INSTRUTOR, //Cpf do Instrutor
                    'codigoMunicio' => '09373', //Codigo do Municipio
                    'ufCfc'         => 'GO', //UF do CFC
                    'categoria'     => $objParams->cnh_category, //Categoria do Candidato
                    'cpf'           => $objParams->cpf, //CPF do Candidato
                    'renach'        => $objParams->renach, //Renach do Candidato
                ];

                $this->updateLog(['dados_enviados' => $arrParams]);

                $objXml = new SimpleXMLElement('<enviaCurso/>');
                foreach ($arrParams as $key => $val) {
                    $objXml->addChild($key, $val);
                }
                $strXmlBody = $objXml->asXML();

                $handle = curl_init($strUrl);

                curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-type: text/xml', 'Authorization: Bearer ' . $token]);
                
                curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($handle, CURLOPT_TIMEOUT, 20);
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $strXmlBody);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST,false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER,false);
                $return = curl_exec($handle);
                curl_close($handle);

                if (!$return) {
                    throw new IntegracaoException(self::MSG_ERRO_DETRAN);
                }

                break;

            case self::OPERACAO_VERIFICA_CERTIFICADO:
                $strUrl = self::URL_WEBSERVICE_VERIFICA_CERTIFICADO . $objParams->cnh . '/' . self::CNPJ_CFC;

                $handle = curl_init($strUrl);

                curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-type: text/xml', 'Authorization: Bearer ' . $token]);
                
                curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($handle, CURLOPT_TIMEOUT, 20);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST,false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER,false);
                $return = curl_exec($handle);
                curl_close($handle);

                if (!$return) {
                    throw new IntegracaoException(self::MSG_ERRO_DETRAN);
                }

                break;
            default:
                throw new Exception('Operação não disponível.');
        }

        if ($return) {

            // $this->updateLog(['dados_retornados' => $return]);

            libxml_use_internal_errors(true);
            $objXmlRetorno = simplexml_load_string($return);
            if ($objXmlRetorno === false) {
                throw new Exception('Não foi possível interpretar o XML de retorno da transação.');
            }

            $result = $this->objToArray($objXmlRetorno);
            $this->updateLog(['dados_retornados' => $result]);

            if (isset($result['codMensagem'])) {
                $intStatus   = $result['codMensagem'];
                $strMensagem = isset($result['mensagem']) ? $result['mensagem'] : '';
                return [$intStatus, $strMensagem];
            } else {
                throw new Exception('Não foi possível recuperar o código de retorno da transação');
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
        //Tipo de Reciclagem
        if (empty($objParams->tipo_reciclagem) || $objParams->tipo_reciclagem != 1 && $objParams->tipo_reciclagem != 2) {
            throw new Exception("O campo Tipo de Reciclagem é obrigatório.");
        }

        //Registro CNH
        if (empty($objParams->cnh)) {
            throw new Exception("O campo registro CNH é obrigatório.");
        }

        $objParams->cnh = preg_replace('/\D/', '', trim($objParams->cnh));
        if (strlen($objParams->cnh) != 11) {
            throw new IntegracaoException("O campo registro CNH é inválido.");
        }

        //CPF
        if (empty($objParams->cpf)) {
            throw new IntegracaoException("O campo CPF é obrigatório.");
        }

        $objParams->cpf = preg_replace('/\D/', '', trim($objParams->cpf));
        if (strlen($objParams->cpf) != 11) {
            throw new IntegracaoException("CPF inválido.");
        }

        //RENACH
        if (empty($objParams->renach)) {
            throw new IntegracaoException("O campo RENANCH é obrigatório.");
        }
        $objParams->renach = strtoupper(trim($objParams->renach));
        if (strlen($objParams->renach) != 11) {
            throw new IntegracaoException("RENACH inválido.");
        }

        //CATEGORIA CNH
        if (empty($objParams->cnh_category)) {
            throw new IntegracaoException("O campo Categoria CNH é obrigatório.");
        }
        $objParams->cnh_category = strtoupper($objParams->cnh_category);

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


        } catch (Exception $ex) {
            $this->updateLog(['mensagem_retorno' => $ex->getMessage()]);
            throw $ex;
        }
    }
}
