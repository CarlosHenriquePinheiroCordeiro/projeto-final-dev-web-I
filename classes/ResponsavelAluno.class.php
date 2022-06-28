<?php
require_once('autoload.php');

class ResponsavelAluno {

    private $Responsavel;
    private $Aluno;

    /**
     * Get the value of Responsavel
     */ 
    public function getResponsavel()
    {
        if (!isset($this->Responsavel)) {
            $this->Responsavel = new Responsavel();
        }
        return $this->Responsavel;
    }

    /**
     * Set the value of Responsavel
     *
     * @return  self
     */ 
    public function setResponsavel($Responsavel)
    {
        $this->Responsavel = $Responsavel;

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
        return $this->getResponsavel().' | <br>Pessoa:'.$this->getAluno();
    }


}