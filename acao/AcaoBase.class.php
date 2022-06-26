<?php
/**
 * Classe base para as classes de Acao
 */
abstract class AcaoBase {

    /** @var mixed */
    protected $Dados;
    
    /**
     * Retorna a consulta de dados
     * @param array $atributos
     * @return string
     */
    public function consulta(array $consulta) : string {
        $atributos = array_map(function($linha) {
            return $linha[0];
        }, $consulta);
        $dadosConsulta = $this->buscaDadosConsulta($atributos);
        var_dump($dadosConsulta);
        $this->montaConsulta($consulta, $dadosConsulta);
        return '';
    }

    /**
     * Busca os dados para a consulta
     * @param array $colunas
     * @return array
     */
    protected function buscaDadosConsulta(array $atributos) : array {
        return $this->getDados()->query($atributos);
    }

    /**
     * Monta a consulta para a tela
     * @param array $colunas
     * @param array $dados
     */
    protected function montaConsulta(array $colunas, array $dados) {

    }

    /**
     * Função feita para ser sobrescrita quando se deseja adicionar condições à uma consulta
     */
    protected function filtraConsulta() {}

    /**
     * Função feita para se sobrescrita qunado se deseja adicionar ordenações à uma consulta
     */
    protected function ordenar() {}

    /**
     * Adiciona uma condição à consulta
     */
    protected function adicionaCondicao(string $atributo, string $operador, string $valor) {
        $this->getDados()->adicionaCondicaoConsulta($atributo, $operador, $valor);
    }

    /**
     * Chama o processamento da inclusão de dados
     */
    public function processaInclusao() {
        $sucesso = false;
        $this->antesExecutarInclusao();
        $sucesso = $this->executaInclusao();
        $this->depoisExecutarInclusao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma inclusão seja feita
     */
    protected function antesExecutarInclusao() {}

    /**
     * Processa a inclusão de dados
     * @return boolean
     */
    protected function executaInclusao() : bool {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->insert();
            $this->getDados()->commit();
        } catch (Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a inclusão: '.$th->getMessage();
            echo $th->getMessage();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma inclusão ser feita
     */
    protected function depoisExecutarInclusao() {}
    
    /**
     * Chama o processamento da alteração de dados
     * @return boolean
     */
    public function processaAlteracao() : bool {
        $sucesso = false;
        $this->antesExecutarAlteracao();
        $sucesso = $this->executaAlteracao();
        $this->depoisExecutarAlteracao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma alteração seja feita
     */
    protected function antesExecutarAlteracao() {

    }

    /**
     * Processa a alteração de dados
     */
    protected function executaAlteracao() : bool {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->update();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a alteração: '.$th->getMessage();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma alteração ser feita
     */
    protected function depoisExecutarAlteracao() {}
    
    /**
     * Chama o processamento da exclusão de dados
     * @return boolean
     */
    public function processaExclusao() : bool {
        $sucesso = false;
        $this->antesExecutarExclusao();
        $sucesso = $this->executaExclusao();
        $this->depoisExecutarExclusao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma exclusão seja feita
     */
    protected function antesExecutarExclusao() {

    }

    /**
     * Processa a exclusão de dados
     */
    public function executaExclusao() : bool {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->delete();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a exclusão: '.$th->getMessage();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma exclusão ser feita
     */
    protected function depoisExecutarExclusao() {}

    /**
     * Chama o processamento da ativação de um registro
     * @return boolean
     */
    public function processaAtivacao() : bool {
        $sucesso = false;
        $this->antesExecutarAtivacao();
        $sucesso = $this->executarAtivacao();
        $this->depoisExecutarAtivacao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma ativação seja feita
     */
    protected function antesExecutarAtivacao() {}

    /**
     * Processa a ativação de um registro
     */
    protected function executarAtivacao() {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->ativar();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a ativação: '.$th->getMessage();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma ativação ser feita
     */
    protected function depoisExecutarAtivacao() {}

    /**
     * Chama o processamento da ativação de um registro
     * @return boolean
     */
    public function processaDesativacao() : bool {
        $sucesso = false;
        $this->antesExecutarDesativacao();
        $sucesso = $this->executarDesativacao();
        $this->depoisExecutarDesativacao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma desaativação seja feita
     */
    protected function antesExecutarDesativacao() {}

    /**
     * Processa a desativação de um registro
     */
    protected function executarDesativacao() : bool {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->desativar();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a desativação: '.$th->getMessage();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma desativação ser feita
     */
    protected function depoisExecutarDesativacao() {}

    /**
     * Get the value of Dados
     */ 
    public function getDados() : DadosBase {
        return $this->Dados;
    }

    /**
     * Set the value of Dados
     * @return  self
     */ 
    public function setDados(DadosBase $Dados) {
        $this->Dados = $Dados;
        return $this;
    }


}