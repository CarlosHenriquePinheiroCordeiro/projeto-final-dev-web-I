<?php
require_once('autoload.php');

class Professor {

    private $codigo;
    private $Pessoa;

    /**
     * Get the value of codigo
     */ 
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of Pessoa
     */ 
    public function getPessoa()
    {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = new Pessoa(1, 'Carlos', '2001-08-10', '12345678921', '4561235', new Usuario(1, 'idCarlos', 'senhaCarlos', 1, 1, new TipoUsuario(1, 'Admin')));
        }
        return $this->Pessoa;
    }

    /**
     * Set the value of Pessoa
     *
     * @return  self
     */ 
    public function setPessoa($Pessoa)
    {
        $this->Pessoa = $Pessoa;

        return $this;
    }

    public function __toString()
    {
        return $this->getCodigo().' | <br>Pessoa:'.$this->getPessoa();
    }


}