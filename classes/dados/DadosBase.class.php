<?php
require_once('../autoload.php');

/**
 * Classe base para as classes de Dados
 */
abstract class DadosBase implements InterfaceDados {

    /**  @var Relacionamento[] */
    protected $relacionamentos = [];
    protected $Modelo;

    public function __construct() {
        $this->definePrimarias();
        $this->defineEstrangeiras();
        $this->outrasColunas();
    }

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
     * Insere o modelo no banco de dados
     * @return boolean
     */
    public function insert() : bool {
        $sql = 'INSERT INTO '.$this->getTabela().' ('.implode(',', $this->getColunasParaSql()).') ';
        $sql .= 'VALUES ('.implode(', ',$this->getAtributosParaSql()).'); ';
        $pdo = $this->getConn();
        $pdo->prepare($sql);
        $pdo->execute();
        return true;
    }

    /**
     * Prepara os valores para o "prepare" do PDO
     */
    public function preparaValoresSql(PDO $pdo) {
        foreach ($this->getRelacionamentos() as $relacionamento) {
            $getter = 'get'.ucfirst($relacionamento->getAtributo());
            $pdo->bindParam(':'.$relacionamento->getAtributo(), $this->getModelo()->$getter(), $relacionamento->getTipo());
        }
    }

    /**
     * Retorna um array com as devidas colunas para a montagem de um SQL
     * @return array
     */
    protected function getColunasParaSql() {
        return array_map(function($relacionamento) {
            return $relacionamento->getColuna();
        }, $this->getRelacionamentos());
    }

    /**
     * Retorna um array com os devidos atributos, definidos para utilizar "prepare" em um SQL
     * @return array
     */
    protected function getAtributosParaSql() {
        return array_map(function($relacionamento) {
            return ':'.$relacionamento->getAtributo();
        }, $this->getRelacionamentos());
    }

    /**
     * Atualiza o modelo no banco de dados
     * @return boolean
     */
    public function update() : bool {
        return true;
    }

    /**
     * Exclui o modelo no banco de dados
     * @return boolean
     */
    public function delete() : bool {
        return true;
    }

    /**
     * Consulta os registros deste modelo
     * @return boolean
     */
    public function query() {
        return true;
    }

    /**
     * Retorna a conexão
     * @return PDO
     */
    private function getConn() : PDO {
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
    private function rollback() {
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