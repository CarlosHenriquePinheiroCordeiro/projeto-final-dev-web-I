<?php
require_once('autoload.php');

class RegistroAulaAluno {

    private $RegistroAula;
    private $Aluno;

    public function __construct($RegistroAula = false, $Aluno = false)
    {
        $this->setRegistroAula($RegistroAula);
        $this->setAluno($Aluno);
    }

    /**
     * Get the value of RegistroAula
     */ 
    public function getRegistroAula()
    {
        return $this->RegistroAula;
    }

    /**
     * Set the value of RegistroAula
     *
     * @return  self
     */ 
    public function setRegistroAula($RegistroAula)
    {
        $this->RegistroAula = $RegistroAula;

        return $this;
    }

    /**
     * Get the value of Aluno
     */ 
    public function getAluno()
    {
        return $this->Aluno;
    }

    /**
     * Set the value of Aluno
     *
     * @return  self
     */ 
    public function setAluno($Aluno)
    {
        $this->Aluno = $Aluno;

        return $this;
    }

    public function __toString()
    {
        return 'RegistroAula: '.$this->getRegistroAula().' | Aluno: '.$this->getAluno();
    }

}