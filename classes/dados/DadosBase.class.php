<?php
require_once('../autoload.php');

/**
 * Classe base para as classes de Dados
 */
abstract class DadosBase extends Dados implements InterfaceDados {

    protected $relacionamentosExternos;

    public function __construct() {
        $this->definePrimarias();
        $this->outrasColunas();
        $this->defineEstrangeiras();
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
        return $stmt->execute();
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
        return array_map(function(Relacionamento $relacionamento) {
            return $relacionamento->getColuna();
        }, $relacionamentos);
    }

    /**
     * Retorna um array com os atributos referentes aos relacionamentos enviados como array
     * @param array $relacionamentos
     * @return string[]
     */
    protected function getAtributosRelacionamentos(array $relacionamentos) : array {
        return array_map(function(Relacionamento $relacionamento) {
            return $relacionamento->getAtributo();
        }, $relacionamentos);
    }

    /**
     * Retorna um array com os atributos, em forma de parâmetro para PDO, referentes aos relacionamentos enviados como array
     * @param array $relacionamentos
     * @return string[]
     */
    protected function getAtributosPrepareRelacionamentos(array $relacionamentos) : array {
        return array_map(function(Relacionamento $relacionamento) {
            $atributo = $relacionamento->getAtributo();
            if ($relacionamento->isEstrangeira()) {
                $atributo = str_replace('.', '', $atributo);
            }
            return ':'.$atributo;
        }, $relacionamentos);
    }

    /**
     * Prepara os valores para o "prepare" do PDO
     * @param PDOStatement $stmt
     */
    public function preparaValoresSql(PDOStatement $stmt, array $relacionamentos) {
        foreach ($relacionamentos as $relacionamento) {
            $atributo = $relacionamento->getAtributo();
            if ($relacionamento->isEstrangeira()) {
                $atributo = str_replace('.', '', $atributo);
            }
            $valor = $this->getValorModeloRelacionamento($this->getModelo(), $relacionamento);
            $stmt->bindValue(':'.$atributo, $valor, $relacionamento->getTipo());
        }
    }

    /**
     * Atualiza o modelo no banco de dados
     * @return boolean
     */
    public function update() : bool {
        $relacionamentos = $this->getRelacionamentosSemChavePrimaria();
        $sql  = 'UPDATE '.$this->getTabela();
        $sql .= 'SET '.implode(', ', $this->getColunasCondicao($relacionamentos)).' ';
        $sql .= $this->getCondicaoChaves();

        $pdo = $this->getConn();
        $stmt = $pdo->prepare($sql);
        $this->preparaValoresSql($stmt, $this->getRelacionamentos());
        return $stmt->execute();
    }

    /**
     * Retorna um array com as colunas para um "prepare" de update
     * @param array $relacionamentos
     * @return array
     */
    protected function getColunasCondicao(array $relacionamentos) : array {
        return array_map(function($relacionamento) {
            return $relacionamento->getColuna().' = :'.$relacionamento->getAtributo();
        }, $relacionamentos);
    }

    /**
     * Retorna uma string com as condições relaciondas às chaves (para um update ou delete)
     * @return string
     */
    protected function getCondicaoChaves() : string {
        $condicoes  = $this->getColunasCondicao($this->getChavesPrimarias());
        $sql        = ' WHERE '.array_shift($condicoes);
        if (count($condicoes) > 0) {
            $sql .= implode(' AND ', $condicoes);
        }
        return $sql.';';
    }

    /**
     * Exclui o modelo no banco de dados
     * @return boolean
     */
    public function delete() : bool {
        $sql = 'DELETE FROM '.$this->getTabela().' ';
        $sql .= $this->getCondicaoChaves();
        $chaves = $this->getChavesPrimarias();
        $pdo = $this->getConn();
        $stmt = $pdo->prepare($sql);
        $this->preparaValoresSql($stmt, $chaves);
        return $stmt->execute();
    }

    /**
     * Ativa a situação de um registro
     */
    public function ativar() : bool {
        return $this->updateSituacao(1);
    }

    /**
     * Desativa a situação de um registro
     */
    public function desativar() : bool {
        return $this->updateSituacao(0);
    }

    /**
     * Atualiza a situação de um registro
     */
    public function updateSituacao($situacao) : bool {
        $sql = 'UPDATE '.$this->getTabela().' ';
        $sql .= 'SET '.$this->getColunaAtivarDesativar().' = :situacao ';
        $sql .= $this->getCondicaoChaves();
        $pdo = $this->getConn();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':codigo'  , $this->getModelo()->getCodigo(), PDO::PARAM_INT);
        $stmt->bindValue(':situacao', $situacao                      , PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    /**
     * Consulta os registros deste modelo
     * @return boolean
     */
    public function query() : bool {
        return true;
    }

    /**
     * Retorna o nome da coluna para a situação do cadastro
     */
    public function getColunaAtivarDesativar() : string {
        return $this->getSiglaTabela().'Ativo';
    }


}