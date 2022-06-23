<?php
require_once('../autoload.php');

/**
 * Classe base para as classes de Dados
 */
abstract class DadosBase extends Dados implements InterfaceDados {

    public function __construct() {
        $this->definePrimarias();
        $this->defineEstrangeiras();
        $this->outrasColunas();
    }

    /**
     * Insere o modelo no banco de dados
     * @return boolean
     */
    public function insert() : bool {
        $relacionamentos = $this->getRelacionamentosSemChavePrimaria();
        $sql = 'INSERT INTO '.$this->getTabela().' ('.implode(',', $this->getColunasRelacionamentos($relacionamentos)).') ';
        $sql .= 'VALUES ('.implode(', ',$this->getAtributosPrepareRelacionamentos($relacionamentos)).'); ';

        $pdo = $this->getConn();
        $stmt = $pdo->prepare($sql);
        $this->preparaValoresSql($stmt, $relacionamentos);
        $stmt->execute();
        return true;
    }

    /**
     * Retorna um array com os relacionamentos que não sejam chaves primarias
     * @return Relacionamento[]
     */
    protected function getRelacionamentosSemChavePrimaria() : array {
        $rels = [];
        foreach ($this->getRelacionamentos() as $relacionamento) {
            if (!$relacionamento->isPrimaria()) {
                $rels[] = $relacionamento;
            }
        }
        return $rels;
    }

    /**
     * Retorna um array com os relacionamentos que são chaves primárias
     * @return Relacionamento[]
     */
    protected function getChavesPrimarias() : array {
        $rels = [];
        foreach ($this->getRelacionamentos() as $relacionamento) {
            if ($relacionamento->isPrimaria()) {
                $rels[] = $relacionamento;
            }
        }
        return $rels;
    }

    /**
     * Retorna um array com as colunas referentes aos relacionamentos enviados como array
     * @param array $relacionamentos
     * @return string[]
     */
    protected function getColunasRelacionamentos(array $relacionamentos) : array {
        return array_map(function($relacionamento) {
            return $relacionamento->getColuna();
        }, $relacionamentos);
    }

    /**
     * Retorna um array com os atributos referentes aos relacionamentos enviados como array
     * @param array $relacionamentos
     * @return string[]
     */
    protected function getAtributosRelacionamentos(array $relacionamentos) : array {
        return array_map(function($relacionamento) {
            return $relacionamento->getAtributo();
        }, $relacionamentos);
    }

    /**
     * Retorna um array com os atributos, em forma de parâmetro para PDO, referentes aos relacionamentos enviados como array
     * @param array $relacionamentos
     * @return string[]
     */
    protected function getAtributosPrepareRelacionamentos(array $relacionamentos) : array {
        return array_map(function($relacionamento) {
            return ':'.$relacionamento->getAtributo();
        }, $relacionamentos);
    }

    /**
     * Prepara os valores para o "prepare" do PDO
     * @param PDOStatement $stmt
     */
    public function preparaValoresSql(PDOStatement $stmt, array $relacionamentos) {
        foreach ($relacionamentos as $relacionamento) {
            $getter = 'get'.ucfirst($relacionamento->getAtributo());
            $stmt->bindValue(':'.$relacionamento->getAtributo(), $this->getModelo()->$getter(), $relacionamento->getTipo());
        }
    }

    /**
     * Atualiza o modelo no banco de dados
     * @return boolean
     */
    public function update() : bool {
        $relacionamentos = $this->getRelacionamentosSemChavePrimaria();
        $sql = 'INSERT INTO '.$this->getTabela().' ('.implode(',', $this->getColunasRelacionamentos($relacionamentos)).') ';
        $sql .= 'VALUES ('.implode(', ',$this->getAtributosPrepareRelacionamentos($relacionamentos)).') ';

        $chaves        = $this->getChavesPrimarias();
        $chavePrimaria = array_shift($chaves);

        $pdo = $this->getConn();
        $stmt = $pdo->prepare($sql);
        $this->preparaValoresSql($stmt, $relacionamentos);
        $stmt->execute();
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
    public function query() : bool {
        return true;
    }


}