<?php
require_once('autoload.php');

class Professor implements InterfaceLista {

    private $codigo;
    private $Pessoa;

    public function __construct($codigo = null, $Pessoa = null) {
        $this->setCodigo($codigo);
        $this->setPessoa($Pessoa);
    }

    /**
     * Get the value of codigo
     */ 
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get the value of Pessoa
     */ 
    public function getPessoa() {
        if ($this->Pessoa == null) {
            $this->Pessoa = new Pessoa();
        }
        return $this->Pessoa;
    }

    /**
     * Set the value of Pessoa
     *
     * @return  self
     */ 
    public function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
        return $this;
    }

    public function __toString() {
        return $this->getCodigo().' | <br>Pessoa:'.$this->getPessoa();
    }

    /**
     * {@inheritdoc}
     */
    public function toLista(): Lista {
        return new Lista($this->getCodigo(), $this->getCodigo().' - '.$this->getPessoa()->getNome());
    }


}