<?php
require_once('../autoload.php');

class DadosAluno extends DadosBase {

    /**
     * {@inheritdoc}
     */
    function definePrimarias() {
        $this->integer('id', 'id')->chavePrimaria();
    }

    /**
     * {@inheritdoc}
     */
    function defineEstrangeiras() {
        
    }

    /**
     * {@inheritdoc}
     */
    function outrasColunas() {
        $this->varchar('nome', 'nome');
        $this->date('dataTeste', 'data');
    }

    /**
     * {@inheritdoc}
     */
    function getTabela() {
        return 'tbaluno';
    }



}