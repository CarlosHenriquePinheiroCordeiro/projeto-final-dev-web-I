<?php
require_once('autoload.php');

class RegistroAula {

    private $codigo;
    private $descricao;
    private $data;
    private $presenca;
    private $SalaVirtualProfessor;
    private $SalaVirtual;

    public function __construct($codigo = null, $descricao = null, $data = null, $presenca = null, $SalaVirtualProfessor = null, $SalaVirtual = null) {
        $this->setCodigo($codigo);
        $this->setDescricao($descricao);
        $this->setData($data);
        $this->setPresenca($presenca);
        $this->setSalaVirtualProfessor($SalaVirtualProfessor);
        $this->setSalaVirtual($SalaVirtual);
    }

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

    /**
     * Get the value of data
     */ 
    public function getData() {
        return $this->data;
    }

    /**
     * Set the value of data
     * @return  self
     */ 
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * Get the value of presenca
     */ 
    public function getPresenca() {
        return $this->presenca;
    }

    /**
     * Set the value of presenca
     * @return  self
     */ 
    public function setPresenca($presenca) {
        $this->presenca = $presenca;
        return $this;
    }

    /**
     * Get the value of SalaVirtualProfessor
     */ 
    public function getSalaVirtualProfessor() {
        if ($this->SalaVirtualProfessor == null) {
            $this->SalaVirtualProfessor = new SalaVirtualProfessor();
        }
        return $this->SalaVirtualProfessor;
    }

    /**
     * Set the value of SalaVirtualProfessor
     * @return  self
     */ 
    public function setSalaVirtualProfessor($SalaVirtualProfessor) {
        $this->SalaVirtualProfessor = $SalaVirtualProfessor;
        return $this;
    }

    /**
     * Get the value of SalaVirtual
     */ 
    public function getSalaVirtual() {
        if ($this->SalaVirtual == null) {
            $this->SalaVirtual = new SalaVirtual();
        }
        return $this->SalaVirtual;
    }

    /**
     * Set the value of SalaVirtual
     * @return  self
     */ 
    public function setSalaVirtual($SalaVirtual) {
        $this->SalaVirtual = $SalaVirtual;
        return $this;
    }

    public function __toString() {
        return $this->getCodigo().' | '.$this->getDescricao().' | '.$this->getData().' | <br>SalaVirtual'.$this->getSalaVirtual();
    }


}