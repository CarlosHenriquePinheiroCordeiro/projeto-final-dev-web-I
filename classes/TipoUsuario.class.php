<?php
require_once('autoload.php');

class TipoUsuario implements InterfaceLista {

    private $codigo;
    private $nome;

    public function __construct($codigo = false, $nome = false)
    {
        $this->setCodigo($codigo);
        $this->setNome($nome);
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
     * Get the value of nome
     */ 
    public function getNome() {
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
     * {@inheritdoc}
     */
    public function toLista() : Lista {
        return new Lista($this->getCodigo(), $this->getNome());
    }

    public function __toString() {
        return $this->getCodigo().' | '.$this->getNome();
    }


}