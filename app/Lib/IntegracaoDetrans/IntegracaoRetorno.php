<?php

class IntegracaoRetorno {

    private $codigo;
    private $mensagem;
    private $extra;

    /**
     * IntegracaoRetorno constructor.
     * @param $codigo
     * @param $mensagem
     * @param $extra
     */
    public function __construct($codigo, $mensagem, array $extra = [])
    {
        $this->codigo   = $codigo;
        $this->mensagem = $mensagem;
        $this->extra    = $extra;
    }


    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param mixed $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param mixed $extra
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;
    }

    public function getCodigoEMensagem()
    {
        if ($this->codigo != '' && $this->mensagem != '') {
            return $this->codigo . ' - ' . $this->mensagem;
        } elseif ($this->mensagem != '') {
            return $this->mensagem;
        } else {
            return $this->codigo;
        }
    }

    public function __toString()
    {
        return $this->getCodigoEMensagem();
    }
}
