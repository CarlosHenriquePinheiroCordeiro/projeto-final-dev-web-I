<?php
require_once('autoload.php');

/**
 * Classe base para as classes de Dados
 */
abstract class DadosBase extends Dados implements InterfaceDados {

    protected $condicaoConsulta  = [];
    protected $ordenacaoConsulta = [];

    public function __construct() {
        $this->definePrimarias();
        $this->outrasColunas();
        $this->defineEstrangeiras();
    }

    /**
     * Consulta os registros referentes ao modelo desta classe
     * @return array
     */
    public function query(array $colunas = []) : array {
        $sql = $this->getQueryBuscaDados($colunas);
        $sql .= $this->filtraConsulta();
        $stmt  = $this->getConn()->query($sql);
        $dados = [];
        while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nomeModelo = str_replace('Dados', '', get_class($this));
            $objeto = new $nomeModelo();
            foreach ($linha as $atributo => $valor) {
                $this->setaValorModelo($objeto, $atributo, $valor);
            }
            $dados[] = $objeto;
        }
        return $dados;
    }

    /**
     * Retorna o SQL para a query da busca dos dados
     * @param array $colunas
     * @return string
     */
    protected function getQueryBuscaDados(array $colunas = []) : string {
        $sql = 'SELECT ';
        $sql .= $this->colunasConsulta($colunas);
        $sql .= ' FROM '.$this->getTabela();
        $sql .= $this->adicionaJoins();
        return $sql;
    }

    /**
     * Retorna as colunas para a consulta
     * @param array $atributos
     * @return string
     */
    protected function colunasConsulta(array $atributos = []) : string {
        $colunas = [];
        if (count($atributos) > 0) {
            foreach ($atributos as $atributo) {
                if (count(explode('.', $atributo)) > 1) {
                    $colunas[] = $this->buscaColunaAtributoEstrangeiro($atributo);
                } else {
                    $colunas[] = $this->getRelacionamentos()[$atributo]->getColuna().' AS "'.$atributo.'"';
                }
            }
        } else {
            foreach ($this->getRelacionamentos() as $relacionamento) {
                if ($relacionamento->isEstrangeira()) {
                    $colunas[] = $relacionamento->getTabelaReferencia().'.'.$relacionamento->getColuna().' AS "'.$relacionamento->getAtributo().'"';
                } else {
                    $colunas[] = $this->getTabela().'.'.$relacionamento->getColuna().' AS "'.$relacionamento->getAtributo().'"';
                }
                
            }
        }
        $colunasConsulta = implode(',', $colunas);
        return $colunasConsulta;
    }

    /**
     * Busca o nome da coluna do atributo estrangeiro que se quer trazer na consulta
     * @param string $atributo
     * @return string
     */
    protected function buscaColunaAtributoEstrangeiro($atributo) : string {
        $caminho                = explode('.', $atributo);
        $atributoEstrangeiro    = array_pop($caminho);
        $nomeClasseDados        = 'Dados'.array_pop($caminho);
        $classeDados            = new $nomeClasseDados();
        return $classeDados->getRelacionamentos()[$atributoEstrangeiro]->getColuna().' AS "'.$atributo.'"';

    }

    /**
     * Retorna os joins para a consulta
     * @return string
     */
    protected function adicionaJoins() : string {
        $joins = ' ';
        foreach ($this->getChavesEstrangeiras() as $chave) {
            $joins .= 'JOIN ';
            $joins .= $chave->getTabelaReferencia();
            $joins .= ' ON ';
            $joins .= $this->getTabela().'.'.$chave->getColuna().' = '.$chave->getTabelaReferencia().'.'.$chave->getColuna().' ';
        }
        return $joins;
    }

    /**
     * Retorna as condições para a consulta
     * @return string
     */
    protected function filtraConsulta() : string {
        $filtros = '';
        if (count($this->condicaoConsulta) > 0) {
            $condicao = array_shift($this->condicaoConsulta);
            $filtros .= ' WHERE '.$this->getSqlCondicao($condicao);
            foreach ($this->condicaoConsulta as $condicao) {
                $filtros .= 'AND '.$this->getSqlCondicao($condicao);
            }
        }
        return $filtros;
    }

    /**
     * Retorna um SQL de condição a partir de uma condição setada para a consulta
     * @param array $condicao
     * @return string
     */
    protected function getSqlCondicao(array $condicao) : string {
        $valor = $condicao['valor'];
        if (in_array($condicao['tipo'], Relacionamento::VALOR_STRING)) {
            $valor = '\''.$valor.'\'';
        }
        return $condicao['coluna'].' '.$condicao['operador'].' '.$valor.' ';
    }

    /**
     * Seta o valor da chave estrangeira no modelo
     * @param mixed $modelo
     * @param Relacionamento $relacionamento
     */
    function setaValorModelo(mixed $modelo, string $atributo, mixed $valor) {
        $caminho  = explode('.', $atributo);
        $this->setValorRecursivo($modelo, $caminho, $valor);

    }

    /**
     * Seta o valor de forma recursiva no modelo
     * @param mixed $modelo
     * @param array $caminho
     * @param mixed $valor
     */
    function setValorRecursivo(mixed $modelo, array $caminho, mixed $valor) {
        if (count($caminho) > 0) {
            $atributo = array_shift($caminho);
            if (ctype_upper($atributo[0])) {
                $getter = 'get'.$atributo;
                setValorRecursivo($modelo->$getter(), $caminho, $valor);
            } else {
                $setter = 'set'.ucfirst($atributo);
                $modelo->$setter($valor);
            }
        }
    }

    /**
     * Adiciona uma condição à consulta
     * @param string $atributo
     * @param string $operador
     * @param string $valor
     */
    public function adicionaCondicaoConsulta(string $atributo, string $operador, string $valor) {
        $relacionamento = $this->getRelacionamentos()[$atributo];
        $this->condicaoConsulta[] = ['coluna' => $relacionamento->getColuna(), 'operador' => $operador, 'valor' => $valor, 'tipo' => $relacionamento->getTipo()];
    }

    /**
     * Adiciona uma ordenação à consulta
     * @param string $atributo
     * @param string $ordem
     */
    public function adicionaOrdenacaoConsulta(string $atributo, string $ordem = 'ASC') {
        $relacionamento = $this->getRelacionamentos()[$atributo];
        $this->ordenacaoConsulta[] = ['coluna' => $relacionamento->getColuna(), 'ordem' => $ordem];
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
     * Prepara os valores para o "prepare" do PDO
     * @param PDOStatement $stmt
     */
    public function preparaValoresSql(PDOStatement $stmt, array $relacionamentos) {
        foreach ($relacionamentos as $relacionamento) {
            $atributo      = $relacionamento->getAtributo();
            $colunaPrepare = str_replace('.', '', $atributo);
            $valor         = $this->getValorModelo($this->getModelo(), $atributo);
            echo ':'.$colunaPrepare.' = '.$valor.'<br>';
            $stmt->bindValue(':'.$colunaPrepare, $valor, $relacionamento->getTipo());
        }
    }

    /**
     * Atualiza o modelo no banco de dados
     * @return boolean
     */
    public function update() : bool {
        $relacionamentos = $this->getRelacionamentosSemChavePrimaria();
        $sql  = 'UPDATE '.$this->getTabela().' ';
        $sql .= 'SET '.implode(', ', $this->getColunasCondicao($relacionamentos)).' ';
        $sql .= $this->getCondicaoChaves();

        $pdo = $this->getConn();
        $stmt = $pdo->prepare($sql);
        $this->preparaValoresSql($stmt, $this->getRelacionamentos());
        echo $sql.'<br>';
        return $stmt->execute();
    }

    /**
     * Retorna um array com as colunas para um "prepare" de update
     * @param array $relacionamentos
     * @return array
     */
    protected function getColunasCondicao(array $relacionamentos) : array {
        return array_map(function($relacionamento) {
            return $relacionamento->getColuna().' = :'.str_replace('.', '', $relacionamento->getAtributo());
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
        echo $this->getModelo()->getCodigo();
        $stmt->bindValue(':codigo'  , $this->getModelo()->getCodigo(), PDO::PARAM_INT);
        $stmt->bindValue(':situacao', $situacao                      , PDO::PARAM_BOOL);
        return $stmt->execute();
    }

    /**
     * Se o modelo estiver com o valor da chave setado, preenche os seus outros atributos
     */
    public function buscaDados() {
        foreach ($this->getChavesPrimarias() as $primaria) {
            $atributo = $primaria->getAtributo();
            $valor    = $this->getValorModelo($this->getModelo(), $atributo);
            $this->adicionaCondicaoConsulta($atributo, '=', $valor);
        }
        $query = $this->query();
        $this->setModelo(end($query));
    }

    /**
     * Retorna o nome da coluna para a situação do cadastro
     */
    public function getColunaAtivarDesativar() : string {
        return $this->getSiglaTabela().'Ativo';
    }

    /**
     * Retorna o último ID inserido no banco de dados
     */
    public function getUltimoIdInserido() : string {
        return $this->getConn()->lastInsertId();
    }


}