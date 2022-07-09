<?php
require_once('autoload.php');

class DadosMateria extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->integer('MATCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {
        $this->varchar('MATNome'     , 'nome');
        $this->varchar('MATDescricao', 'descricao');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBMateria';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'MAT';
    }


}