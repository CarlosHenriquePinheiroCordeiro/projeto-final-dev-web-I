<?php
require_once('autoload.php');

class DadosSalaVirtualAluno extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->integer('SALCodigo', 'SalaVirtual.codigo')->chavePrimaria()->chaveEstrangeira()->referencia('SALCodigo', 'codigo')->on('TBSalaVirtual')->chavePai();
        $this->bigint ('ALUCodigo', 'Aluno.codigo'      )->chavePrimaria()->chaveEstrangeira()->referencia('ALUCodigo', 'codigo')->on('TBAluno');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {}

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBSalaVirtualAluno';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {}

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuscaDados(array $colunas = []): string {
        $sql = 'SELECT  TBSalaVirtualAluno.SALCodigo as "SalaVirtual.codigo", '
            .           'TBAluno.ALUCodigo           as "Aluno.codigo", '
            .           'TBAluno.PESCodigo           as "Aluno.Pessoa.codigo", '
            .           'TBPessoa.PESNome            as "Aluno.Pessoa.nome" ';
        $sql .= ' FROM '.$this->getTabela();
        $sql .= $this->adicionaJoins();
        $sql .= ' JOIN TBPessoa '
                .  'ON TBPessoa.PESCodigo = TBAluno.PESCodigo ';
        return $sql;
    }


}