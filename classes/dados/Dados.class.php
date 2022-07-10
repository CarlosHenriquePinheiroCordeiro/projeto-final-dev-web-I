<?php
require_once('autoload.php');

abstract class Dados {

    /**  @var Relacionamento[] */
    protected $relacionamentos = [];
    protected $relacionamentosAssociativos = [];
    protected $Modelo;

    /**
     * Define um relacionamento como bigint.
     * Função feita apenas para declarar ao programador que se trata de um código bigint, mas pelo PDO apenas se tem o Integer para tipar
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento
     */
    public function bigint(string $coluna, string $atributo) : Relacionamento {
        return $this->adicionaRelacionamento($coluna, $atributo, Relacionamento::BIGINT);
    }

    /**
     * Define um relacionamento como Integer
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento
     */
    public function integer(string $coluna, string $atributo) : Relacionamento {
        return $this->adicionaRelacionamento($coluna, $atributo, Relacionamento::INTEGER);
    }

    /**
     * Define um relacionamento como Varchar
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento $rel
     */
    public function varchar(string $coluna, string $atributo) : Relacionamento {
        return $this->adicionaRelacionamento($coluna, $atributo, Relacionamento::VARCHAR);
    }

    /**
     * Define um relacionamento como Json
     * Função feita apenas para declarar ao programador que se trata de um JSON, mas pelo PDO apenas se tem o Varchar para tipar
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento $rel
     */
    public function json(string $coluna, string $atributo) : Relacionamento {
        return $this->adicionaRelacionamento($coluna, $atributo, Relacionamento::VARCHAR);
    }

    /**
     * Define um relacionamento como Boolean
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento
     */
    public function boolean(string $coluna, string $atributo) : Relacionamento {
        return $this->adicionaRelacionamento($coluna, $atributo, Relacionamento::BOOLEAN);
    }

    /**
     * Define um relacionamento como Date
     * Função feita apenas para declarar ao programador que se trata de um date, mas pelo PDO apenas se tem o String para tipar
     * @param string $coluna
     * @param string $atributo
     * @return Relacionamento
     */
    public function date(string $coluna, string $atributo) : Relacionamento {
        return $this->adicionaRelacionamento($coluna, $atributo, Relacionamento::DATE);
    }

    /**
     * Adiciona um relacionamento
     * @param string $coluna
     * @param string $atributo
     * @param int    $tipo
     */
    protected function adicionaRelacionamento(string $coluna, string $atributo, int $tipo) : Relacionamento {
        $rel = new Relacionamento($coluna, $atributo, $tipo);
        $this->relacionamentos[$atributo] = $rel;
        return $rel;
    }

    /**
     * Retorna um array com os relacionamentos que não sejam chaves primarias
     * @return Relacionamento[]
     */
    protected function getRelacionamentosSemChavePrimaria() : array {
        $rels = [];
        foreach ($this->getRelacionamentos() as $relacionamento) {
            if (($relacionamento->isPrimaria() && $relacionamento->isEstrangeira()) || !$relacionamento->isPrimaria()) {
                $rels[] = $relacionamento;
            }
        }
        return $rels;
    }

    /**
     * Retorna um array com os relacionamentos que são chaves primárias
     * @return Relacionamento[]
     */
    public function getChavesPrimarias() : array {
        $rels = [];
        foreach ($this->getRelacionamentos() as $relacionamento) {
            if ($relacionamento->isPrimaria()) {
                $rels[] = $relacionamento;
            }
        }
        return $rels;
    }

    /**
     * Retorna um array com os relacionamentos que são chaves estrangeiras
     * @return Relacionamento[]
     */
    public function getChavesEstrangeiras() : array {
        $rels = [];
        foreach ($this->getRelacionamentos() as $relacionamento) {
            if ($relacionamento->isEstrangeira()) {
                $rels[] = $relacionamento;
            }
        }
        return $rels;
    }

    /**
     * Retorna um array com os relacionamentos que são chaves pai, em uma relação associativa
     * @return Relacionamento[]
     */
    public function getChavesPai() : array {
        $rels = [];
        foreach ($this->getRelacionamentos() as $relacionamento) {
            if ($relacionamento->isChavePai()) {
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
     * Retorna o valor vindo do modelo referente ao atributo que o refere
     * @param mixed  $modelo
     * @param string $atributo
     * @return mixed
     */
    public function getValorModelo(mixed $modelo, string $atributo) {
        $caminho = explode('.', $atributo);
        return $this->getValorModeloRecursivo($modelo, $caminho);
    }

    /**
     * Retorna o valor vindo do modelo referente ao relacionamento que o refere de forma recursiva
     * @param mixed $modelo
     * @param array $relacionamento
     * @return mixed
     */
    public function getValorModeloRecursivo(mixed $modelo, array $caminho) {
        if (count($caminho) > 0) {
            $atributo = array_shift($caminho);
            $getter = 'get'.$atributo;
            if (ctype_upper($atributo[0])) {
                return $this->getValorModeloRecursivo($modelo->$getter(), $caminho);
            } else {
                return $modelo->$getter();
            }
        }
    }

    /**
     * Função que engloba as adições de relacionamentosAssociativos
     */
    protected function adicionaRelacionamentosAssociativos() {}

    /**
     * Adiciona um relacionamento associativo para esta classe]
     * @param string $nomeClasseDados
     */
    protected function addRelacionamentoAssociativo($nomeClasseDados) {
        $this->relacionamentosAssociativos[] = $nomeClasseDados;
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