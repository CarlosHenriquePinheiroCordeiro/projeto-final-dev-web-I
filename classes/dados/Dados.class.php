<?php
require_once('..'.DIRECTORY_SEPARATOR.'autoload.php');

abstract class Dados {

    /**  @var Relacionamento[] */
    protected $relacionamentos = [];
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
        $this->relacionamentos[] = $rel;
        return $rel;
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
     * Retorna o valor vindo do modelo referente ao relacionamento que o refere
     * @param mixed $modelo
     * @param Relacionamento $relacionamento
     * @return mixed
     */
    protected function getValorModeloRelacionamento(mixed $modelo, Relacionamento $relacionamento) {
        $caminho = explode('.', $relacionamento->getAtributo());
        return $this->getValorModeloRelacionamentoRecursivo($modelo, $caminho);
    }

    /**
     * Retorna o valor vindo do modelo referente ao relacionamento que o refere de forma recursiva
     * @param mixed $modelo
     * @param array $relacionamento
     * @return mixed
     */
    protected function getValorModeloRelacionamentoRecursivo(mixed $modelo, array $caminho) {
        if (count($caminho) > 0) {
            $atributo = array_shift($caminho);
            $getter = 'get'.$atributo;
            if (ctype_upper($atributo[0])) {
                return $this->getValorModeloRelacionamentoRecursivo($modelo->$getter(), $caminho);
            } else {
                return $modelo->$getter();
            }
        }
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