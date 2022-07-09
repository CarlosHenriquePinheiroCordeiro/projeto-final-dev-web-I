<?php
require_once('autoload.php');

class DadosProfessor extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->bigint('PROCodigo', 'codigo'         )->chavePrimaria();
        $this->bigint('PESCodigo', 'Pessoa.codigo'  )->chaveEstrangeira()->referencia('PESCodigo', 'codigo')->on('TBPessoa');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {}

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBProfessor';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'PRO';
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuscaDados(array $colunas = []): string {
        $sql = 'SELECT  TBProfessor.PROCodigo     as "codigo", '
            .           'TBProfessor.PESCodigo    as "Pessoa.codigo", '
            .           'TBPessoa.PESNome         as "Pessoa.nome" ';
        $sql .= ' FROM '.$this->getTabela();
        $sql .= $this->adicionaJoins();
        return $sql;
    }


}