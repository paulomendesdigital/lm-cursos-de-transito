<?php

App::uses('IntegracaoRetorno', 'IntegracaoDetrans');
App::uses('IntegracaoException', 'IntegracaoDetrans');
App::uses('IntegracaoParams', 'IntegracaoDetrans');
App::uses('LogDetran', 'Model');

abstract class IntegracaoBase
{
    /**
     * Retorno da Transação
     * @var IntegracaoRetorno
     */
    protected $retorno;

    /**
     * @var LogDetran
     */
    protected $LogDetran;

    /**
     * Origem do Log
     * @var
     */
    protected $origem;

    public function __construct($origem = null)
    {
        $this->origem = $origem;
        $this->LogDetran = new LogDetran();
    }

    /**
     * Valida junto ao Sistema do Órgão de Trânsito se o condutor é publico alvo do referido curso.
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public abstract function validar(IntegracaoParams $objParams);

    /**
     * Consulta junto Sistema do Órgão de Trânsito as informações do condutor
     * @param IntegracaoParams $objParams
     * @return IntegracaoRetorno
     * @throws Exception
     */
    public abstract function consultar(IntegracaoParams $objParams);

    /**
     * Matricula o Condutor no Órgão de Trânsito
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public abstract function matricular(IntegracaoParams $objParams);

    /**
     * Envia o Crédito de Aula do Condutor no Órgão de Trânsito
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public abstract function creditar(IntegracaoParams $objParams);

    /**
     * Envia o Sinal de Conclusão do Curso no Órgão de Trânsito
     * @param IntegracaoParams $objParams
     * @return boolean
     * @throws Exception
     */
    public abstract function concluir(IntegracaoParams $objParams);

    /**
     * Retorna o Retorno da Transação
     * @return IntegracaoRetorno
     */
    public function getRetorno() {
        return $this->retorno;
    }

    /**
     * Atribui o Retorno da Transação
     * @param IntegracaoRetorno $retorno
     */
    protected function setRetorno(IntegracaoRetorno $retorno)
    {
        $this->retorno = $retorno;
    }

    /**
     * Cria um objeto novo de Retorno
     * @param $codigo
     * @param $mensagem
     * @param array $extra
     * @return IntegracaoRetorno
     */
    protected function createRetorno($codigo, $mensagem, array $extra = [])
    {
        $this->setRetorno(new IntegracaoRetorno($codigo, $mensagem, $extra));
        $this->updateLog(['codigo_retorno' => $codigo, 'mensagem_retorno' => $mensagem]);
        return $this->getRetorno();
    }

    /**
     * Prepara dados para gravação na tabela de Log
     * @param $log
     * @return array
     */
    protected function prepareLog($log) {
        $log['integracao'] = get_called_class();
        $log['data_log']   = date('Y-m-d H:i:s');
        $log['origem']     = $this->origem;

        if (isset($log['parametros']) && $log['parametros'] instanceof IntegracaoParams) {
            /** @var IntegracaoParams $params */
            $params = $log['parametros'];

            $log['order_id']         = $params->order_id;
            $log['order_courses_id'] = $params->order_courses_id;
            $log['cpf']              = preg_replace('/\D/', '', $params->cpf);
            $log['renach']           = strtoupper($params->renach);
            $log['cnh']              = preg_replace('/\D/', '', $params->cnh);

            if ($params->user_id) {
                $log['user_id'] = $params->user_id;
            } else if (class_exists('CakeSession')) {
                $log['user_id'] = CakeSession::read('Auth.User.id');
            }

            $log['parametros'] = $params->toJson();
        }

        if (isset($log['dados_enviados'])) {
            $log['dados_enviados'] = json_encode($log['dados_enviados']);
        }

        if (isset($log['dados_retornados'])) {
            $log['dados_retornados'] = json_encode($log['dados_retornados']);
        }

        return $log;
    }

    /**
     * Cria um novo registro de log
     * @param string $rotina
     * @param array $log
     */
    protected function createLog($rotina, $log)
    {
        $log['rotina'] = $rotina;
        $this->LogDetran->create($this->prepareLog($log));
        $this->LogDetran->save();
    }

    /**
     * Atualiza um registro de log
     * @param array $log
     */
    public function updateLog($log)
    {
        $this->LogDetran->set($this->prepareLog($log));
        $this->LogDetran->save();
    }

    /**
     * Testa a conexão com o WebService antes de executar o SOAP
     * No PHP 5.6 existe um bug no SoapClient que emite um Fatal Error quando não é possível se conectar ao webservice.
     * @param string $url
     * @param bool $checkOnly Se True só irá checar se a conexão é bem sucedida, se false retorna o conteúdo da URL.
     * @return bool|string
     */
    protected function verificaConexao($url, $checkOnly = true)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_HEADER, $checkOnly);
        curl_setopt($handle, CURLOPT_NOBODY, $checkOnly);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER,false);
        return curl_exec($handle);
    }

    /**
     * Testa a conexão na Primeira Porta do WSDL SOAP
     * @param string $url
     * @return bool
     */
    protected function verificaPortasSOAP($url)
    {
        if ($wsdl = $this->verificaConexao($url, false)) {

            $xml = new SimpleXmlElement($wsdl);

            $query   = "wsdl:service/wsdl:port";
            $address = $xml->xpath($query);

            if ($address && isset($address[0])) {
                $port = $address[0];
                $loc = $port->xpath('*[@location]');
                if ($loc && isset($loc[0]['location'])) {
                    return $this->verificaConexao($loc[0]['location']);
                }
            }
        }
        return false;
    }

    /**
     * Transforma um Objeto em Array Recursivamente
     * @param bool $obj
     * @return array|bool
     */
    protected function objToArray($obj = false)  {
        if (is_object($obj))
            $obj = get_object_vars($obj);
        if (is_array($obj)) {
            return array_map([$this, __FUNCTION__], $obj);
        } else {
            return $obj;
        }
    }

    /**
     * @return mixed
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * @param mixed $origem
     */
    public function setOrigem($origem)
    {
        $this->origem = $origem;
    }


}
