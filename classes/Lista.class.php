<?php

class Lista {

    private $valor;
    private $descricao;

    const TIPO_SELECT   = 1;
    const TIPO_CHECKBOX = 2;

    public function __construct($valor, $descricao) {
        $this->setValor($valor);
        $this->setDescricao($descricao);
    }

    /**
     * Get the value of valor
     */ 
    public function getValor() {
        return $this->valor;
    }

    /**
     * Set the value of valor
     * @return  self
     */ 
    public function setValor($valor) {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get the value of descricao
     */ 
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     * @return  self
     */ 
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }


}