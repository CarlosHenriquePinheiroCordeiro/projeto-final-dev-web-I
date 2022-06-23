<?php
require_once('../autoload.php');

class DadosEstrangeiro extends DadosBase {

    /**
     * {@inheritdoc}
     */
    function definePrimarias() {
        $this->integer('codigo', 'codigo')->chavePrimaria();
    }

    /**
     * {@inheritdoc}
     */
    function defineEstrangeiras() {}

    /**
     * {@inheritdoc}
     */
    function outrasColunas() {
        $this->varchar('nome', 'nome');
    }

    /**
     * {@inheritdoc}
     */
    function getTabela() {
        return 'tbestrangeiro';
    }


}