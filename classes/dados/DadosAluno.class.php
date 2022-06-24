<?php
require_once('../autoload.php');

class DadosAluno extends DadosBase {

    /**
     * {@inheritdoc}
     */
    function definePrimarias() {
        
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
        
    }

    /**
     * {@inheritdoc}
     */
    function getTabela() {
        return 'tbaluno';
    }


}