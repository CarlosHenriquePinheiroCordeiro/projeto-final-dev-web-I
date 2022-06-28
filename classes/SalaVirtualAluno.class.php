<?php
require_once('autoload.php');

class SalaVirtualAluno {

    private $SalaVirtual;
    private $Aluno;

    public function __construct($SalaVirtual = false, $Aluno = false)
    {
        $this->setSalaVirtual($SalaVirtual);
        $this->setAluno($Aluno);
    }

    /**
     * Get the value of SalaVirtual
     */ 
    public function getSalaVirtual()
    {
        return $this->SalaVirtual;
    }

    /**
     * Set the value of SalaVirtual
     *
     * @return  self
     */ 
    public function setSalaVirtual($SalaVirtual)
    {
        $this->SalaVirtual = $SalaVirtual;

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
        return 'SalaVirtual: '.$this->getSalaVirtual().' | Aluno: '.$this->getAluno();
    }

}