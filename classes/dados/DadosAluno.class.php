<?php
require_once('autoload.php');

class DadosAluno extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->bigint('ALUCodigo', 'codigo')->chavePrimaria();
        $this->bigint('PESCodigo', 'Pessoa.codigo')->chaveEstrangeira()->referencia('PESCodigo', 'codigo')->on('TBPessoa');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {}

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBAluno';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'ALU';
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuscaDados(array $colunas = []): string {
        $sql = 'SELECT  TBAluno.ALUCodigo     as "codigo", '
            .           'TBAluno.PESCodigo    as "Pessoa.codigo", '
            .           'TBPessoa.PESNome     as "Pessoa.nome" ';
        $sql .= ' FROM '.$this->getTabela();
        $sql .= $this->adicionaJoins();
        return $sql;
    }


}