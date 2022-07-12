<?php
require_once('autoload.php');

class DadosRegistroAula extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->integer('RAUCodigo', 'codigo')->chavePrimaria();
        $this->integer('PROCodigo', 'SalaVirtualProfessor.Professor.codigo' )->chaveEstrangeira()->referencia('PROCodigo', 'Professor.codigo')->on('TBSalaVirtualProfessor');
        $this->integer('SALCodigo', 'SalaVirtual.codigo'                    )->chaveEstrangeira()->referencia('SALCodigo', 'codigo'          )->on('TBSalaVirtual');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {
        $this->varchar('RAUDescricao', 'descricao');
        $this->varchar('RAUData'     , 'data');
        $this->integer('RAUQtdAulas' , 'qtdAulas');
        $this->json   ('RAUPresenca' , 'presenca');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBRegistroAula';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'RAU';
    }


}