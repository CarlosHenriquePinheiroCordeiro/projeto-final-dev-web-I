<?php
require_once('autoload.php');

class DadosProfessor extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->bigint('PROCodigo', 'codigo'         )->chavePrimaria();
        $this->bigint('PESCodigo', 'Pessoa.codigo'  )->chavePrimaria()->chaveEstrangeira()->referencia('PESCodigo', 'codigo')->on('TBPessoa');
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


}