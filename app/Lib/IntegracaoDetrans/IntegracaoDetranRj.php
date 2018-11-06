<?php

App::uses('IntegracaoBase', 'IntegracaoDetrans');

/**
 * Classe de Integração com o Detran RJ
 * @author Douglas Gomes de Souza <douglas@dsconsultoria.com.br>
 * @copyright LM Cursos de Transito
 */

class IntegracaoDetranRj extends IntegracaoBase
{
    const OPERACAO_CONSULTA  = 1;
    const OPERACAO_MATRICULA = 2;
    const OPERACAO_CONCLUSAO = 3;

    const MSG_ERRO_DETRAN = 'No momento não foi possível consultar o Detran-RJ';


    /**
     * Consulta os dados do Condutor no Detran-RJ
     * @param IntegracaoParams $objParams
     * @return IntegracaoRetorno
     * @throws Exception
     */
    public function consultar(IntegracaoParams $objParams)
    {
        $this->createLog('consultar', ['parametros' => $objParams]);

        try { //na rotina consultar, se for erro de parâmetros retorna false em vez de exception
            $this->prepareParamsConsultaEMatricula($objParams);
        }  catch (Exception $ex) {
            return $this->createRetorno(null, $ex->getMessage());
        }

        try {
            $codigoRetorno = $this->integracaoReciclagemRJ(self::OPERACAO_CONSULTA, $objParams);
        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;
        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }

        return $this->createRetorno($codigoRetorno, $this->getMensagemRetorno($codigoRetorno));
    }

    /**
     * Valida o Condutor no Detran-RJ
     * @param IntegracaoParams $objParams
     * @return bool
     * @throws Exception
     */
    public function validar(IntegracaoParams $objParams)
    {
        $this->createLog('validar', ['parametros' => $objParams]);

        try {
            $this->prepareParamsConsultaEMatricula($objParams);
            $codigoRetorno = $this->integracaoReciclagemRJ(self::OPERACAO_CONSULTA, $objParams);
        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;
        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }

        $this->createRetorno($codigoRetorno, $this->getMensagemRetorno($codigoRetorno));

        //559 = Candidato apto para ser matriculado em CRCI
        //557 = Já matriculado em CRCI por Esta CFC/EAD
        return ($codigoRetorno === '559' || $codigoRetorno === '557');
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
            $this->prepareParamsConsultaEMatricula($objParams);
            $codigoRetorno = $this->integracaoReciclagemRJ(self::OPERACAO_MATRICULA, $objParams);
        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;
        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }

        $this->createRetorno($codigoRetorno, $this->getMensagemRetorno($codigoRetorno));

        //000 = Transação Efetuada com Sucesso
        //557 = Já matriculado em CRCI por esta CFC/EAD
        //506 = Candidato já possui carga horária
        return ($codigoRetorno === '000' || $codigoRetorno === '557' || $codigoRetorno === '506');
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
            $codigoRetorno = $this->integracaoReciclagemRJ(self::OPERACAO_CONCLUSAO, $objParams);
        } catch (IntegracaoException $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw $ex;
        } catch (Exception $ex) {
            $this->createRetorno(null, $ex->getMessage());
            throw new Exception(self::MSG_ERRO_DETRAN, 0, $ex);
        }

        $this->createRetorno($codigoRetorno, $this->getMensagemRetorno($codigoRetorno));

        //0999 = Transação Efetuada com Sucesso
        //506  = Candidato já possui carga horária
        //6013 = Não consta na documentação, mas o aluno consegue agendar
        return ($codigoRetorno === '0999' || $codigoRetorno === '506' || $codigoRetorno == '6013');
    }

    /**
     * Valida e Prepara os parâmetros para integração
     * @param IntegracaoParams $objParams
     * @throws Exception
     */
    private function prepareParamsGeral(IntegracaoParams $objParams)
    {
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
        $objParams->cnh_category = strtoupper(str_pad(trim($objParams->cnh_category), 4, ' ', STR_PAD_RIGHT));
    }

    /**
     * Valida e Prepara os parâmetros para integração de Consulta e Matrícula
     * @param IntegracaoParams $objParams
     * @throws Exception
     */
    private function prepareParamsConsultaEMatricula(IntegracaoParams $objParams)
    {
        try {
            $this->prepareParamsGeral($objParams);

            if (empty($objParams->cpf)) {
                throw new IntegracaoException("O campo CPF é obrigatório.");
            }

            $objParams->cpf = preg_replace('/\D/', '', trim($objParams->cpf));
            if (strlen($objParams->cpf) != 11) {
                throw new IntegracaoException("CPF inválido.");
            }

        } catch (Exception $ex) {
            $this->updateLog(['mensagem_retorno' => $ex->getMessage()]);
            throw $ex;
        }
    }

    /**
     * Valida e Prepara os parâmetros para integração de Certificado
     * @param IntegracaoParams $objParams
     * @throws Exception
     */
    private function prepareParamsCertificado(IntegracaoParams $objParams)
    {
        try {
            $this->prepareParamsGeral($objParams);

            //NUM CERTIFICADO
            if (empty($objParams->num_certificado)) {
                throw new Exception("O 'num_certificado' é obrigatório.");
            }
            $numImpresso = str_pad($objParams->num_certificado, 6, '0', STR_PAD_LEFT);
            $objParams->num_certificado = str_pad($numImpresso, 15, ' ', STR_PAD_RIGHT);

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
     * Faz a comunicação com Webservice do Detran-RJ
     * @param string           $strOperacao
     * @param IntegracaoParams $objParams
     * @return array
     * @throws Exception
     * @throws IntegracaoException
     */
    private function integracaoReciclagemRJ($strOperacao, IntegracaoParams $objParams)
    {
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');

        if (strpos($host, 'dev') === false && strpos($host, 'new') === false && strpos($host, 'digitaluow') === false) {
            $url = "http://10.200.180.71:8080/wsstack/services/ENSINODI.wsdl"; //PRODUÇÃO
        } else {
            $url = "http://10.200.180.70:8080/wsstack/services/ENSINODI.wsdl"; //HOMOLOGAÇÃO
        }

        if (!$this->verificaConexao($url)) {
            throw new Exception('No momento não foi possível consultar o DETRAN-RJ.');
        }

        //TR - 630 - CONSULTAR E MATRICULAR
        if ($strOperacao == self::OPERACAO_CONSULTA || $strOperacao == self::OPERACAO_MATRICULA) {

            $codigoTransacao  = '630';
            $tamanhoTransacao = '045';
            $caer             = 'RJ51970';
            $codigoServico    = $strOperacao == self::OPERACAO_CONSULTA ? '22' : '20';

            $parteVariavel = $objParams->cpf . '1' . $objParams->renach . '0' . $codigoServico . date('dmY') . $caer . $objParams->cnh_category;

            //TR - 010 - CERTIFICADO DE CONCLUSÃO
        } elseif ($strOperacao == self::OPERACAO_CONCLUSAO) {

            $codigoTransacao  = '010';
            $tamanhoTransacao = '054';

            $tipoChave         = '1';
            $codigoEvento      = 'C';
            $codigoAtualizacao = 'I';
            $codigoCurso       = '20';
            $codigoModalidade  = '2';
            $cargaHoraria      = '030';
            $cnpjCredenciada   = '18657198000146'; //18.657.198/0001-46
            $cpfInstrutor      = '11287596754';
            $codigoMunicipio   = '06001';
            $ufCurso           = 'RJ';
            $dataValidade      = '00000000';
            $caer              = 'RJ51970';
            $strDataFim        = date('Ymd'); //colocando a data de final do curso com o dia atual, pois a data do certificado não é confiável.

            $parteVariavel = $tipoChave . $objParams->renach . $codigoEvento . $codigoAtualizacao . $codigoCurso . $codigoModalidade . $objParams->num_certificado . $objParams->data_matricula_detran . $strDataFim . $cargaHoraria . $cnpjCredenciada . $cpfInstrutor . $codigoMunicipio . $ufCurso . $dataValidade . $objParams->cnh_category . $caer;

        } else {
            throw new Exception('Transação não disponível.');
        }

        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);

        $client = new SoapClient($url, array(
            "trace"          => 1,
            "exceptions"     => true,
            "stream_context" => stream_context_create(
                array(
                    'ssl' => array(
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                    )
                )
            )
        ));

        $authvar = new SoapVar(
            array('exx-natural-security' => 'TRUE',
                  'exx-natural-library'  => 'LIBBRK',
                  'exx-rpc-userID'       => 'COENSILM',
                  'exx-rpc-password'     => '6nVdgjNY'
            ), SOAP_ENC_OBJECT);

        $header = new SoapHeader('urn:com.softwareag.entirex.xml.rt', 'EntireX', $authvar);

        $client->__setSoapHeaders($header);

        $numeroSequencial     = str_pad(date('H') . date('i') . date('s'), 6, '0', STR_PAD_LEFT);
        $codigoModalidade     = '4';
        $codigoIdentCliente   = 'COENSILM   ';
        $ufOrigemTransacao    = 'RJ';
        $ufOrigemTransmissao  = 'RJ';
        $ufDestinoTransmissao = 'RJ';
        $tipoCondicionalidade = '0';
        $codigoRetTransacao   = ' ';
        $diaJuliano           = date('z');

        $arguments = [
            'PARTE-FIXA'     => $numeroSequencial . $codigoTransacao . $codigoModalidade . $codigoIdentCliente . $ufOrigemTransacao . $ufOrigemTransmissao . $ufDestinoTransmissao . $tipoCondicionalidade . $tamanhoTransacao . $codigoRetTransacao . $diaJuliano,
            'PARTE-VARIAVEL' => [$parteVariavel]
        ];

        $this->updateLog(['dados_enviados' => $arguments]);

        $result = $client->__soapCall("GTRN0003", array("parameters" => $arguments), null);

        if ($result) {

            $result = $this->objToArray($result);

            if (isset($result['PARTE-VARIAVEL']['string']) && is_array($result['PARTE-VARIAVEL']['string'])) {
                $resultParteVariavel = explode(' ', $result['PARTE-VARIAVEL']['string'][0]);
            } elseif (isset($result['PARTE-VARIAVEL']['string']) && is_string($result['PARTE-VARIAVEL']['string'])) {
                $resultParteVariavel = explode(' ', $result['PARTE-VARIAVEL']['string']);
            } else {
                $resultParteVariavel = [null, null];
            }

            $codigo = $resultParteVariavel[0];

            $this->updateLog(['dados_retornados' => $result]);

        } else {
            throw new Exception('Não foi possível localizar a string de retorno na Parte Variável');
        }

        return $codigo;
    }


    private function getMensagemRetorno($codigo)
    {
        $mensagens = [
            ''    => 'Erro',
            '000' => 'Transação efetuada com sucesso',
            '001' => 'Domínio inválido',
            '006' => 'Formulário Renach não encontrado',
            '007' => 'CPF obrigatório para EAD',
            '008' => 'CPF não corresponde ao RJ',
            '009' => 'EAD suspensa',
            '101' => 'Formulário em faixa diferente de em exames',
            '102' => 'RJ Transferido',
            '103' => 'RJ em Exigência',
            '105' => 'Idade inferior a permitida',
            '107' => 'Multa compatível para curso',
            '108' => 'CNH com Impedimento/Bloqueio',
            '112' => 'CNH vencida há mais de 30 dias',
            '114' => 'Dados Incompatíveis',
            '115' => 'Código de Serviço Inválido',
            '116' => 'Requerimento 4 não previsto para o serviço',
            '117' => 'Categoria Pretendida Inválida (Auto)',
            '118' => 'Categoria Pretendida diferente da informada (Moto)',
            '119' => 'Categoria Pretendida diferente da informada (Auto)',
            '120' => 'Categoria Pretendida inválida (Moto)',
            '121' => 'Tipo chave Inválido',
            '122' => 'Registro não encontrado',
            '127' => 'Categoria Pretendida diferente de B e AB',
            '128' => 'Categoria Pretendida diferente de A e XB (Auto)',
            '129' => 'Categoria Pretendida diferente de AB (Auto)',
            '130' => 'Categoria Pretendida diferente de C e D',
            '131' => 'Categoria Pretendida diferente de D e E',
            '132' => 'Categoria Pretendida diferente de E',
            '133' => 'Categoria Pretendida diferente de XC e XD',
            '134' => 'Categoria Pretendida diferente de XD e XE',
            '135' => 'Categoria Pretendida diferente de XE',
            '136' => 'Categoria Pretendida diferente de AC e AD',
            '137' => 'Categoria Pretendida diferente de AD e AE',
            '138' => 'Categoria Pretendida diferente de AE',
            '139' => 'Categoria Pretendida Incompatível (Auto)',
            '142' => 'Categoria Pretendida diferente de X, A, AB e XB',
            '143' => 'Categoria Pretendida diferente de A e XB (Moto)',
            '144' => 'Categoria Pretendida diferente de AB (Moto)',
            '145' => 'Categoria Pretendida diferente de XB e AB',
            '146' => 'Categoria Pretendida diferente de XC e AC',
            '147' => 'Categoria Pretendida diferente de XD e AD',
            '148' => 'Categoria Pretendida diferente de XE e AE',
            '149' => 'Categoria Pretendida Incompatível (Moto)',
            '002' => 'Campos Obrigatórios Ausentes.',
            '011' => 'UF de Origem da Transação Diferente da UF de Domínio.',
            '016' => 'Inexistência de Número de Registro na Base.',
            '017' => 'CNH Sendo Emitida.',
            '042' => 'Liberação já Registrada – Confirme Alteração de Dados.',
            '222' => 'Modalidade do Curso Fora da Tabela ou Ausente ou Não se Aplica ao Curso.',
            '345' => 'Curso/Exame não compatível com a Categoria Registrada no Prontuário do Candidato/Condutor.',
            '346' => 'Exame não compatível com a Categoria Registrada no Prontuário do Candidato/Condutor',
            '153' => 'Candidato não é alvo de CRCI',
            '154' => 'Categoria Incompatível',
            '155' => 'Já possui curso',
            '156' => 'Categoria Permitida diferente da informada',
            '198' => 'Serviço não é de CRCI',
            '199' => 'Condutor não exerce Atividade Remunerada**',
            '500' => 'Requerimento incompatível',
            '501' => 'Data anterior a de corte',
            '503' => 'Não está matriculado em nenhum curso',
            '506' => 'Candidato já possui carga horária',
            '507' => 'Categoria incompatível',
            '554' => 'CAER Ausente',
            '555' => 'Serviço já registrado (630)',
            '556' => 'Candidato não matriculado em CRCI',
            '557' => 'Já matriculado em CRCI por esta CFC/EAD',
            '558' => 'Já matriculado em CRCI por outra CFC/EAD',
            '559' => 'Candidato apto para ser matriculado em CRCI',
            '802' => 'Formulário Inválido ou Ausente.',
            '0002' => 'Campos Obrigatórios Ausentes',
            '0006' => 'Inexistência do Numero de Formulário-RENACH',
            '0101' => 'Formulário-RENACH Encerrado',
            '0199' => 'Condutor não exerce Atividade Remunerada',
            '0217' => 'Código do Curso não Tabelado',
            '0802' => 'Número de Formulário-RENACH Inválido',
            '0999' => 'Transação Efetuada com Sucesso',
            '1003' => 'Curso-Certificado já Informado',
            '1004' => 'Data do início ou fim do curso superior a data corrente',
            '1005' => 'Carga Horária Insuficiente',
            '1006' => 'Carga Horária Incompatível com Período',
            '1007' => 'Data início ou fim do curso diferente de aaaa/mm/dd',
            '1008' => 'Sem autorização especial para recepção de carga horária ???????????',
            '1010' => 'Sem autorização especial para ignorar crítica ??????????????',
            '1011' => 'Reprovado no exame psicológico',
            '1012' => 'Autorização especial para ignorar crítica ???????????',
            'R999' => 'Código de Erro do REFOR',
            '1020' => 'Candidato não está matriculado no curso',
            '1023' => 'Carga horaria máxima diária excedida',
            '1024' => 'Curso não é de CRCI',
            '1025' => 'Curso não é a distancia',
            '1026' => 'Carga horária inferior a 20',
            '1029' => 'Data da matrícula é posterior a data do início do curso',
            '375' => 'O Número Formulário RENACH só Aceito Para Candidato.',
            '376' => 'Tipo de Evento Inválido ou Ausente.',
            '377' => 'Tipo Atualização Evento Inválido ou Ausente.',
            '388' => 'Categoria Permitida Deve ser Igual ou Inferior a Categoria Pretendida.',
            '389' => 'CNH Cancelada Por Erro Gráfica.',
            '390' => 'O Campo Modalidade é Obrigatório Para Este Curso.',
            '391' => 'A Carga Horária é Obrigatório Para Este Curso.',
            '392' => 'O Município do Evento não Pertence a UF Evento.',
            '393' => 'Data Validade é Obrigatório Para Este Evento.',
            '394' => 'Categoria é Obrigatório Para Este Curso.',
            '395' => 'Evento Já Registrado no Prontuário do Condutor/Candidato.',
            '396' => 'Código do Curso Fora da Tabela ou Ausente.',
            '397' => 'Data Inicio Curso Inválida.',
            '398' => 'Data Fim Curso Inválida.',
            '399' => 'CNPJ Entidade Credenciada Inválido ou Ausente.',
            '400' => 'CPF Instrutor Inválido ou Ausente.',
            '401' => 'Município Evento Fora da Tabela ou Ausente.',
            '402' => 'UF Evento Fora da Tabela ou Ausente.',
            '403' => 'Evento Não Cadastrado no Prontuário do Condutor/Candidato.',
            '404' => 'Dados não Divergem dos Cadastrados na BINCO/BCA.',
            '405' => 'Atributos Divergem dos Cadastrados na BINCO/BCA.',
            '406' => 'Evento Rejeitado – Evento é Pré-Requisito Para CNH Autorizada/Emitida .',
            '407' => 'Código do Exame Fora da Tabela ou Ausente.',
            '409' => 'Resultado Inválido ou Ausente.',
            '410' => 'CPF Examinador 1 Inválido ou Ausente.',
            '411' => 'CPF Examinador 2 Inválido.',
            '412' => 'Categoria Pretendida Fora da Tabela ou Ausente.',
            '413' => 'Categoria Permitida Fora da Tabela ou Ausente.',
            '418' => 'UF Detran Infração Fora da Tabela ou Ausente.',
            '467' => 'Número-Chave (Formulário RENACH) inválido para Condutor.',
            '472' => 'Carga-horária Inválida.',
            '473' => 'Data-Validade Inválida ou Ausente ou Não se Aplica ao Curso/Exame.',
            '474' => 'Dados de Liberação inválidos para tipo de atualização informado.',
            '479' => 'Número-Certificado Inválido.',
            '512' => 'Data Inicio-Penalidade-Bloqueios com Data Calendário no Prontuário, Confirme.',
            '513' => 'Data Inicio-Penalidade-Bloqueios Igual Data Inicio-Penalidade-Bloqueios do Prontuário.',
            '593' => 'Carga horária insuficiente para o Curso/Exame',
            '603' => 'Condutor transferido CNH autorizada ou emitida',
            '0639' => 'Inexistência do profissional na base',
            '611' => 'Inexistência do Código da Entidade/Profissional na Base',
            '616' => 'Entidade ou Profissional Bloqueado',
            '625' => 'Entidade com credenciamento em situação inativa',
            '639' => 'Vínculo do profissional à entidade inexistente',
            '658' => 'Vínculo do profissional à entidade inativo',
            '659' => 'Vínculo do profissional à entidade bloqueado',
            '661' => 'Vínculo do profissional à entidade com mudança de UF',
            '662' => 'Evento não compatível com a entidade/profissional',
            '663' => 'Entidade não cadastrada/vinculada UF do evento',
            '752' => 'Número de Registro Inválido.',
            '801' => 'UF do Número Formulário RENACH Fora da Tabela de UF’s.',
            '804' => 'UF do Número Formulário RENACH Diferente da UF de Origem da Transação.',
            '837' => 'Código da Categoria Fora da Tabela.',
            '890' => 'Tipo da Chave de Pesquisa Inválido.',
            '998' => 'Tamanho da Transação Menor que o Tamanho Esperado.',
            '511' => 'Categoria D proveniente de B - Condutor não possui 1 ano na Categoria D.'
        ];

        return isset($mensagens[$codigo]) ? $mensagens[$codigo] : null;
    }

}
