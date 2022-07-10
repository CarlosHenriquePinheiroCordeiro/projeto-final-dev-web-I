<?php
require_once('autoload.php');

class DadosSalaVirtual extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->integer('SALCodigo', 'codigo')->chavePrimaria();
        $this->integer('MATCodigo', 'Materia.codigo')->chaveEstrangeira()->referencia('MATCodigo', 'codigo')->on('TBMateria');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {
        $this->varchar('SALDescricao', 'descricao');
    }

    /**
     * {@inheritdoc}
     */
    protected function adicionaRelacionamentosAssociativos() {
        $this->addRelacionamentoAssociativo('SalaVirtualProfessor');
        $this->addRelacionamentoAssociativo('SalaVirtualAluno');
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
     * {@inheritdoc}
     */
    protected function filtraConsulta(): string {
        $filtroAssociativo = isset($_GET['codigoSalaVirtual']) ? $_GET['codigoSalaVirtual'] : false;
        if ($filtroAssociativo) {
            $this->adicionaCondicaoConsulta('codigo', '=', $filtroAssociativo);
        }
        return parent::filtraConsulta();
    }

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBSalaVirtual';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'SAL';
    }


}