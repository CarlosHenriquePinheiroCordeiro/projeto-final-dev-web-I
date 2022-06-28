<?php
require_once('autoload.php');

class SalaVirtualProfessor {

    private $SalaVirtual;
    private $Professor;

    public function __construct($SalaVirtual = false, $Professor = false)
    {
        $this->setSalaVirtual($SalaVirtual);
        $this->setProfessor($Professor);
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
     * Get the value of Professor
     */ 
    public function getProfessor()
    {
        return $this->Professor;
    }

    /**
     * Set the value of Professor
     *
     * @return  self
     */ 
    public function setProfessor($Professor)
    {
        $this->Professor = $Professor;

        return $this;
    }

    public function __toString()
    {
        return 'SalaVirtual: '.$this->getSalaVirtual().' | Aluno: '.$this->getProfessor();
    }

}