<?php
require_once('autoload.php');

class DadosResponsavel extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->bigint('RESCodigo', 'codigo')->chavePrimaria();
        $this->bigint('PESCodigo', 'Pessoa.codigo')->chavePrimaria()->chaveEstrangeira()->referencia('PESCodigo', 'codigo')->on('TBPessoa');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {}

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBResponsavel';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'RES';
    }


}