<?php
require_once('autoload.php');

class SalaVirtualProfessor {

    private $SalaVirtual;
    private $Professor;

    public function __construct($SalaVirtual = null, $Professor = null){ 
        $this->setSalaVirtual($SalaVirtual);
        $this->setProfessor($Professor);
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
     *
     * @return  self
     */ 
    public function setSalaVirtual($SalaVirtual) {
        $this->SalaVirtual = $SalaVirtual;
        return $this;
    }

    /**
     * Get the value of Professor
     */ 
    public function getProfessor() {
        if ($this->Professor == null) {
            $this->Professor = new Professor();
        }
        return $this->Professor;
    }

    /**
     * Set the value of Professor
     *
     * @return  self
     */ 
    public function setProfessor($Professor) {
        $this->Professor = $Professor;
        return $this;
    }

    public function __toString(){
        return 'SalaVirtual: '.$this->getSalaVirtual().' | Aluno: '.$this->getProfessor();
    }


}