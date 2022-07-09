<?php
require_once('autoload.php');

class DadosSalaVirtualProfessor extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->integer('SALCodigo', 'SalaVirtual.codigo')->chavePrimaria()->chaveEstrangeira()->referencia('SALCodigo', 'codigo')->on('TBSalaVirtual')->chavePai();
        $this->bigint ('PROCodigo', 'Professor.codigo'  )->chavePrimaria()->chaveEstrangeira()->referencia('PROCodigo', 'codigo')->on('TBProfessor');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {}

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBSalaVirtualProfessor';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {}

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuscaDados(array $colunas = []): string {
        $sql = 'SELECT  TBSalaVirtualProfessor.SALCodigo as "SalaVirtual.codigo", '
            .           'TBProfessor.PROCodigo    as "Professor.codigo", '
            .           'TBProfessor.PESCodigo    as "Professor.Pessoa.codigo", '
            .           'TBPessoa.PESNome         as "Professor.Pessoa.nome" ';
        $sql .= ' FROM '.$this->getTabela();
        $sql .= $this->adicionaJoins();
        $sql .= ' JOIN TBPessoa '
                .  'ON TBPessoa.PESCodigo = TBProfessor.PESCodigo ';
        return $sql;
    }


}