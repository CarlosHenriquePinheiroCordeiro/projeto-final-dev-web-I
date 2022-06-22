<?php

abstract class AcaoBase {

    protected $Dados;
    
    
    public function processaInclusao() {
        $this->antesExecutarInclusao();
        $this->executaInclusao();
        $this->depoisExecutarInclusao();
    }

    public function antesExecutarInclusao() {

    }

    public function executaInclusao() {

    }

    public function depoisExecutarInclusao() {

    }
    
    
    public function processaAlteracao() {
    
    }

    public function antesExecutarAlteracao() {

    }

    public function executaAlteracao() {

    }

    public function depoisExecutarAlteracao() {

    }
    
    
    public function processaExclusao() {
    
    }

    public function antesExecutarExclusao() {

    }

    public function executaExclusao() {

    }

    public function depoisExecutarExclusao() {

    }

    /**
     * Get the value of Dados
     */ 
    public function getDados() {
        return $this->Dados;
    }

    /**
     * Set the value of Dados
     * @return  self
     */ 
    public function setDados($Dados) {
        $this->Dados = $Dados;
        return $this;
    }


}