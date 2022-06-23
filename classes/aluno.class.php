<?php
require_once('../autoload.php');

class Aluno {

    private $id;
    private $nome;
    private $data;

    private $Estrangeiro;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */ 
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of Estrangeiro
     */ 
    public function getEstrangeiro() {
        if (!isset($this->Estrangeiro)) {
            $this->Estrangeiro =  new Estrangeiro();
        }
        return $this->Estrangeiro;
    }

    /**
     * Set the value of Estrangeiro
     *
     * @return  self
     */ 
    public function setEstrangeiro($Estrangeiro) {
        $this->Estrangeiro = $Estrangeiro;
        return $this;
    }
}