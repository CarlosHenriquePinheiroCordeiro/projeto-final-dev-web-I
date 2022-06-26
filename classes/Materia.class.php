<?php
require_once('autoload.php');

class Materia {

    private $codigo;
    private $nome;
    private $descricao;

    /**
     * Get the value of codigo
     */ 
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     * @return  self
     */ 
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get the value of nome
     */ 
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set the value of nome
     * @return  self
     */ 
    public function setNome($nome) {
        $this->nome = $nome;
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