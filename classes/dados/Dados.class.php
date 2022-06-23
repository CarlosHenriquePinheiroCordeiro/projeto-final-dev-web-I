<?php
require_once('../autoload.php');

abstract class Dados {

    /**  @var Relacionamento[] */
    protected $relacionamentos = [];
    protected $Modelo;

    /**
     * Define um relacionamento como Integer
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento
     */
    public function integer(string $coluna, string $atributo) : Relacionamento {
        $rel = new Relacionamento($coluna, $atributo, Relacionamento::INTEGER);
        $this->relacionamentos[] = $rel;
        return $rel;
    }

    /**
     * Define um relacionamento como Varchar
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento $rel
     */
    public function varchar(string $coluna, string $atributo) : Relacionamento {
        $rel = new Relacionamento($coluna, $atributo, Relacionamento::VARCHAR);
        $this->relacionamentos[] = $rel;
        return $rel;
    }

    /**
     * Define um relacionamento como Date
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento
     */
    public function date(string $coluna, string $atributo) : Relacionamento {
        $rel = new Relacionamento($coluna, $atributo, Relacionamento::DATE);
        $this->relacionamentos[] = $rel;
        return $rel;
    }

    /**
     * Define um relacionamento como Date
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento
     */
    public function chaveEstrangeira(string $coluna, string $atributo) : Relacionamento {
        $fKey = new Relacionamento($coluna, $atributo);
        $this->foreignKeys[]   = $fKey;
        $this->relacionamentos[] = $fKey;
        return $fKey;
    }

    /**
     * Retorna a conexão
     * @return PDO
     */
    protected function getConn() : PDO {
        return Connect::getInstance();
    }

    /**
     * Começa uma transação no banco de dados
     */
    public function begin() {
        $this->getConn()->beginTransaction();
    }

    /**
     * Comita a transação no banco de dados
     */
    public function commit() {
        $this->getConn()->commit();
    }

    /**
     * Volta atrás na transação no banco de dados
     */
    public function rollback() {
        $this->getConn()->rollBack();
    }

    /**
     * Get the value of Modelo
     */ 
    public function getModelo() {
        return $this->Modelo;
    }

    /**
     * Set the value of Modelo
     * @return  self
     */ 
    public function setModelo($Modelo) {
        $this->Modelo = $Modelo;
        return $this;
    }

    /**
     * Get the value of relacionamentos
     */ 
    public function getRelacionamentos() {
        return $this->relacionamentos;
    }


}