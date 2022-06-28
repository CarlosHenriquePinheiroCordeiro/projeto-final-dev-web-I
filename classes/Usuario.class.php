<?php
require_once('autoload.php');

class Usuario {
    
    private $codigo;
    private $id;
    private $senha;
    private $ativo;
    private $termo;

    /**  @var TipoUsuario */
    private $TipoUsuario;

    public function __construct($codigo = false, $id = false, $senha = false, $ativo = false, $termo = false, $TipoUsuario = false)
    {
        $this->setCodigo($codigo);
        $this->setId($id);
        $this->setSenha($senha);
        $this->setAtivo($ativo);
        $this->setTermo($termo);
        $this->setTipoUsuario($TipoUsuario);
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
     * Get the value of id
     */ 
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     * @return  self
     */ 
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of senha
     */ 
    public function getSenha() {
        return $this->senha;
    }

    /**
     * Set the value of senha
     *
     * @return  self
     */ 
    public function setSenha($senha) {
        $this->senha = $senha;
        return $this;
    }

    /**
     * Get the value of ativo
     */ 
    public function getAtivo() {
        return $this->ativo;
    }

    /**
     * Set the value of ativo
     * @return  self
     */ 
    public function setAtivo($ativo) {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get the value of termo
     */ 
    public function getTermo() {
        return $this->termo;
    }

    /**
     * Set the value of termo
     * @return  self
     */ 
    public function setTermo($termo) {
        $this->termo = $termo;
        return $this;
    }

    /**
     * Get the value of TipoUsuario
     */ 
    public function getTipoUsuario() {
        return $this->TipoUsuario;
    }

    /**
     * Set the value of TipoUsuario
     * @return  self
     */ 
    public function setTipoUsuario($TipoUsuario) {
        $this->TipoUsuario = $TipoUsuario;
        return $this;
    }

    public function __toString()
    {
        return $this->getCodigo().' | '.$this->getId().' | '.$this->getSenha().' | '.$this->getAtivo().' | '.$this->getTermo().' | <br>TipoUsuário: '.$this->getTipoUsuario();
    }

    
}