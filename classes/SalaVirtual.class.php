<?php
require_once('autoload.php');

class SalaVirtual {

    private $codigo;
    private $nome;
    private $descricao;
    private $Materia;
    private $SalaVirtualAluno = [];
    private $SalaVirtualProfessor = [];

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
     * Get the value of nome
     */ 
    public function getNome(){
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

    /**
     * Get the value of SalaVirtualAluno
     */ 
    public function getSalaVirtualAluno() {
        return $this->SalaVirtualAluno;
    }

    /**
     * Set the value of SalaVirtualAluno
     *
     * @return  self
     */ 
    public function setSalaVirtualAluno($SalaVirtualAluno) {
        $this->SalaVirtualAluno = $SalaVirtualAluno;
        return $this;
    }

    public function newSalaVirtualAluno() {
        $salaVirtualAluno = new SalaVirtualAluno();
        $salaVirtualAluno->setSalaVirtual($this);
        $this->SalaVirtualAluno[] = $salaVirtualAluno;
        return $salaVirtualAluno;
    }

    public function resetSalaVirtualAluno() {
        $this->SalaVirtualAluno = [];
    }

    /**
     * Get the value of SalaVirtualProfessor
     */ 
    public function getSalaVirtualProfessor() {
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

    public function newSalaVirtualProfessor() {
        $salaVirtualProfessor = new SalaVirtualProfessor();
        $salaVirtualProfessor->setSalaVirtual($this);
        $this->SalaVirtualProfessor[] = $salaVirtualProfessor;
        return $salaVirtualProfessor;
    }

    public function resetSalaVirtualProfessor() {
        $this->SalaVirtualProfessor = [];
    }


}