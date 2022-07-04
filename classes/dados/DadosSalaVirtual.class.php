<?php
require_once('autoload.php');

class DadosSalaVirtual extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->integer('SALCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {
        $this->integer('MATCodigo', 'Materia.codigo')->chaveEstrangeira()->referencia('MATCodigo', 'codigo')->on('TBMateria');
    }

    /**
     * Define as outras colunas da tabela
     */
    public function outrasColunas() {
        $this->varchar('SALDescricao', 'descricao');
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuscaDados(array $colunas = []): string {
        $sql = 'SELECT  TBSalaVirtual.SALCodigo     as "codigo", '
            .           'TBSalaVirtual.SALDescricao as "descricao", '
            .           'TBMateria.MATCodigo        as "Materia.codigo", '
            .           'TBMateria.MATNome          as "Materia.nome" ';
        $sql .= ' FROM '.$this->getTabela();
        $sql .= $this->adicionaJoins();
        return $sql;
    }

    /**
     * Retorna o nome da tabela
     */
    public function getTabela() {
        return 'TBSalaVirtual';
    }

    /**
     * Retorna o nome da tabela
     */
    public function getSiglaTabela() {
        return 'SAL';
    }


}