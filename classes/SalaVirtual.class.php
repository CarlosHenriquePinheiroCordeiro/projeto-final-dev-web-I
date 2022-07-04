<?php
require_once('autoload.php');

class SalaVirtual {

    private $codigo;
    private $descricao;
    private $Materia;

    public function __construct($codigo = false, $descricao = false, $Materia = null) {
        $this->setCodigo($codigo);
        $this->setDescricao($descricao);
        $this->setMateria($Materia);
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
     * Get the value of Materia
     */ 
    public function getMateria() {
        if ($this->Materia == null) {
            $this->Materia = new Materia();
        }
        return $this->Materia;
    }

    /**
     * Set the value of Materia
     * @return  self
     */ 
    public function setMateria($Materia) {
        $this->Materia = $Materia;
        return $this;
    }

    public function __toString() {
        return $this->getCodigo().' | '.$this->getDescricao().' | '.$this->getMateria();
    }

    
}