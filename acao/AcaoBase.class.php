<?php
/**
 * Classe base para as classes de Acao
 */
abstract class AcaoBase {

    protected $Dados;
    
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
        // $this->getDados()->begin();
        // try {
        //     $sucesso = $this->getDados()->insert();
        //     $this->getDados()->commit();
        //     echo 'INCLUÍDO COM SUCESSO';
        // } catch (Throwable $th) {
        //     $this->getDados()->rollback();
        //     echo 'Erro inclusão';
        //     echo $th->getMessage();
        // }
        $sucesso = $this->getDados()->insert();
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
            echo 'Erro alteração';
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
            echo 'Erro exclusão';
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma exclusão ser feita
     */
    protected function depoisExecutarExclusao() {}

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