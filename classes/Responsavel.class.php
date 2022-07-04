<?php
require_once('autoload.php');

class Responsavel {

    private $codigo;
    private $Pessoa;

    /**
     * Get the value of codigo
     */ 
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of Pessoa
     */ 
    public function getPessoa()
    {
        return $this->Pessoa;
    }

    /**
     * Set the value of Pessoa
     *
     * @return  self
     */ 
    public function setPessoa($Pessoa)
    {
        $this->Pessoa = $Pessoa;

        return $this;
    }

    public function __toString()
    {
        return $this->getCodigo().' | <br>Pessoa:'.$this->getPessoa();
    }


}