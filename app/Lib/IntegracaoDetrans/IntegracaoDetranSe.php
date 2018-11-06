<?php

App::uses('IntegracaoBase', 'IntegracaoDetrans');
App::uses('CourseType', 'Model');

/**
 * Classe de Integração com o Detran SE
 * @author Douglas Gomes de Souza <douglas@dsconsultoria.com.br>
 * @copyright LM Cursos de Transito
 */

class IntegracaoDetranSe extends IntegracaoBase
{

    const AMBIENTE       = 'P'; //D = Desenvolvimento, P = Produção
    const URL_WEBSERVICE = 'http://172.28.64.58:8089/wsIntegracaoEAD'; //sem o ?wsdl

    const OPERACAO_CONSULTA    = 1;
    const OPERACAO_CREDITO     = 2;
    const OPERACAO_CERTIFICADO = 3;

    const MSG_ERRO_DETRAN = 'No momento não foi possível consultar o DETRAN-SE';


    /**
     * Consulta os dados do Condutor no Detran-SE
     *
     * Patrâmetros obrigatórios:
     * - cpf: CPF do Aluno
     *
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
     * Valida o Condutor no Detran-SE
     *
     * Patrâmetros obrigatórios:
     * - cpf: CPF do Aluno
     *
     * @param IntegracaoParams $objParams
     * @return bool
     * @throws Exception|IntegracaoException
     */
    public function validar(IntegracaoParams $objParams)
    {
        $this->createLog('validar', ['parametros' => $objParams]);

        try {
            $this->prepareParamsConsulta($objParams);

            $arrReturn = $this->client(self::OPERACAO_CONSULTA, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '999'); //Processamento OK

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
     * - cpf: CPF do Aluno
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception|IntegracaoException
     */
    public function matricular(IntegracaoParams $objParams)
    {
        $this->createLog('matricular', ['parametros' => $objParams]);

        try {
            $this->prepareParamsConsulta($objParams);

            $arrReturn = $this->client(self::OPERACAO_CONSULTA, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '999'); //Processamento OK

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
     * @throws Exception|IntegracaoException
     */
    public function creditar(IntegracaoParams $objParams)
    {
        $this->createLog('creditar', ['parametros' => $objParams]);

        try {
            $this->prepareParamsCreditar($objParams);

            $arrReturn = $this->client(self::OPERACAO_CREDITO, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '999'); //Processamento OK

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
     * @throws Exception|IntegracaoException
     */
    public function concluir(IntegracaoParams $objParams)
    {
        $this->createLog('concluir', ['parametros' => $objParams]);

        try {
            $this->prepareParamsCertificado($objParams);

            $arrReturn = $this->client(self::OPERACAO_CERTIFICADO, $objParams);
            $this->createRetorno($arrReturn[0], $arrReturn[1]);

            return ($arrReturn[0] === '999'); //Processamento OK

        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;

        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
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

        if ($objParams->course_type_id == CourseType::ESPECIALIZADOS) {
            if (empty($objParams->course_code) || strlen($objParams->course_code) != 2) {
                throw new Exception("O campo 'Código do Curso' não foi informado ou é inválido.");
            }
        }
        $objParams->course_code = substr(str_pad($objParams->course_code, 2, ' '), 0, 2);
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

    /**
     * Valida e Prepara os parâmetros para integração de Crédito de Aula
     * @param IntegracaoParams $objParams
     * @throws Exception|IntegracaoException
     */
    private function prepareParamsCreditar(IntegracaoParams $objParams)
    {
        try {
            $this->prepareParamsGeral($objParams);

            //Código do Módulo
            if (empty($objParams->discipline_code)) {
                throw new IntegracaoException("O campo Código da Disciplina não foi especificado no cadastro da Unidade do Módulo.");
            }
            $objParams->discipline_code = substr(str_pad($objParams->discipline_code, 2, ' '), 0,2);

            //Horário da Aula
            if (empty($objParams->inicio_aula) || !date_create($objParams->inicio_aula)) {
                throw new IntegracaoException("Horário do Início da Aula inválido");
            }
            if (empty($objParams->fim_aula) || !date_create($objParams->fim_aula)) {
                throw new IntegracaoException("Horário do Fim da Aula inválido");
            }

            if ($objParams->is_exam && empty($objParams->acertos)) {
                throw new IntegracaoException("Número de Acertos da Prova não foi informado.");
            }
            $objParams->acertos     = substr(str_pad($objParams->acertos, 2, ' '), 0, 2);
            $objParams->data_aula   = date_create($objParams->inicio_aula)->format('Ymd');
            $objParams->inicio_aula = date_create($objParams->inicio_aula)->format('Hi');
            $objParams->fim_aula    = date_create($objParams->fim_aula)->format('Hi');


        } catch (Exception $ex) {
            $this->updateLog(['mensagem_retorno' => $ex->getMessage()]);
            throw $ex;
        }
    }


    /**
     * Faz a comunicação com Webservice do Detran-SE
     * @param string           $strOperacao
     * @param IntegracaoParams $objParams
     * @return array
     * @throws Exception
     */
    private function client($strOperacao, IntegracaoParams $objParams)
    {
        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);

        $strAmbiente = self::AMBIENTE;

        if (!$this->verificaConexao(self::URL_WEBSERVICE)) {
            throw new Exception(self::MSG_ERRO_DETRAN);
        }

        $strCodigoCFC         = 'CFC037';      //6 caracteres
        $strRegistroInstrutor = '05324484644'; //11 caracteres -- cnh do instrutor
        $strCPFAluno          = $objParams->cpf;

        //CÓDIGOS DE DISCILINA
        //L = Legislação de Trânsito  [12h]
        //D = Direção Defensiva [8h]
        //S = Noções de Primeiros socorros [4h]
        //R = Relacionamento Interpessoal [6h]

        //TIPOS DE AULA
        //T = Teórica
        //A = Atualização
        //S = Simulador
        //P = Prática
        //E = Especializado
        //R = Reciclagem

        if ($objParams->course_type_id == CourseType::ESPECIALIZADOS) {
            $strTipoAula = 'E';
        } else {
            $strTipoAula = 'R';
        }

        switch ($strOperacao) {

            case self::OPERACAO_CONSULTA:
                $arrParametrosEnvio = [
                    'COD-TRANSACAO' => 431,                     //  3 caracteres - Consulta Processo do Aluno
                    'CPF-ALUNO'     => $strCPFAluno,            // 11 caracteres - CPF do Aluno
                    'TIPO-AULA'     => $strTipoAula,            //  1 caracter   - R = Reciclagem, E = Especializado
                    'CATEGORIA'     => ' ',                     //  1 caracter   - O campo categoria deve ser informado quando o tipo-aula for P
                    'CODIGO-CURSO'  => $objParams->course_code, //  2 caracteres - Deve ser informado quando o tipo de aula for E
                    'CODIGO-CFC'    => $strCodigoCFC,           //  6 caracteres - Código do CFC
                ];
                break;

            case self::OPERACAO_CERTIFICADO: //Certificado
                $arrParametrosEnvio = [
                    'COD-TRANSACAO'              => 427,                               //  3 caracteres - Cadastra Certificado
                    'CODIGO-CFC'                 => $strCodigoCFC,                     //  6 caracteres - Código do CFC
                    'REGISTRO-INSTRUTOR'         => $strRegistroInstrutor,             // 11 caracteres - Registro CNH do Instrutor
                    'CPF-ALUNO'                  => $strCPFAluno,                      // 11 caracteres - CPF do Aluno
                    'DATA-INICIO'                => $objParams->data_matricula_detran, //  8 caracteres - Data de início
                    'DATA-TERMINO'               => date('Ymd'),                //  8 caracteres - Data de término
                    'TIPO-CERTIFICADO'           => $strTipoAula,                      //  1 caracter   - R = Reciclagem, E = Especializado
                    'CATEGORIA'                  => ' ',                               //  1 caracter em branco que não constava na documentação de 09/06/2016
                    'CODIGO-CURSO-ESPECIALIZADO' => $objParams->course_code,           //  2 caracteres - Deve ser informado quando o tipo de aula for E
                ];
                break;

            case self::OPERACAO_CREDITO:
                $arrParametrosEnvio = [
                    'COD-TRANSACAO'                 => 424,                              //   3 caracteres - Consulta Processo do Aluno
                    'COD-CFC'                       => $strCodigoCFC,                    //   6 caracteres - Código do CFC
                    'REGISTRO-CNH-INSTRUTOR'        => $strRegistroInstrutor,            //  11 caracteres - Registro CNH do Instrutor
                    'CPF-ALUNO'                     => $strCPFAluno,                     //  11 caracteres - CPF do Aluno
                    'DATA-AULA'                     => $objParams->data_aula,            //   8 caracteres - Data da Aula
                    'HORARIO-INICIO-AULA'           => $objParams->inicio_aula,          //   4 caracteres - valido das 6h até 22h, ex.: 0600, 1030, 1400, 2100.
                    'HORARIO-FIM-AULA'              => $objParams->fim_aula,             //   4 caracteres - valido das 6h até 22h, ex.: 0600, 1030, 1400, 2100.
                    'CODIGO-MATERIA'                => $objParams->discipline_code,      //   2 caracteres - código da disciplina, se tipo de aula = S deve ser preenchido com 1 (simulador diruna) ou 2 (simulador noturna)
                    'TIPO-AULA'                     => $strTipoAula,                     //   1 caracter   - R = Reciclagem, E = Especializado
                    'CATEGORIA-PRATICA'             => ' ',                              //   1 caracter   - Deve ser informado quando o tipo de aula for P
                    'PLACA-OU-COD-SIMULADOR'        => '                              ', //  30 caracteres - Código ou Placa do Simulador
                    'CODIGO-CURSO-ESPECIALIZADO'    => $objParams->course_code,          //   2 caracteres - Deve ser informado quando o tipo de aula for E
                    'NRO-ACERTOS-PROVA'             => $objParams->acertos,              //   2 caracteres - somente deve ser enviado para prova dos cursos especializados
                    'CREDITO-MANUAL'                => ' ',                              //   1 caracter   - deve ser informado S ou N. Caso não informado será considerado N
                    'CPF-RESP-CREDITO-MANUAL'       => '           ',                    //  11 caracteres - informar quando CREDITO-MANUAL = S
                    'QTDE-AULAS-SIMULADOR-NOTURNAS' => ' ',                              //   1 caracter   - para tipos de aulas praticas e simuladores com a qtd de aula noturna
                    'MOTIVO-CREDITO-MANUAL'         => '',                               // 500 caracteres - não será enviado
                ];
                break;
            default:
                throw new Exception('Operação não disponível.');
        }

        $strMensagemEnvio = implode('', $arrParametrosEnvio);

        $client = new SoapClient(self::URL_WEBSERVICE . '?wsdl', [
            "trace"          => 1,
            "exceptions"     => true,
            'location'       => self::URL_WEBSERVICE
        ]);

        $arguments = [
            "pUsuario"  => "DET53003",
            "pSenha"    => "LM2017",
            "pAmbiente" => $strAmbiente,
            "pMensagem" => $strMensagemEnvio,
        ];

        $this->updateLog(['dados_enviados' => $arguments]);

        $result = $client->executaTransacao($arguments);

        if ($result) {

            $retorno = trim($result->executaTransacaoResult);
            $this->updateLog(['dados_retornados' => [$retorno]]);

            return [substr($retorno, 0, 3), trim(substr($retorno, 3))];

        } else {
            throw new Exception('Não foi possível recuperar o retorno da transação');
        }
    }

}
