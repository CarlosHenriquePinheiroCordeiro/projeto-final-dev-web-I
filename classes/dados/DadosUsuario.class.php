<?php
require_once('autoload.php');

class DadosUsuario extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->bigint('USUCodigo', 'codigo')->chavePrimaria();
        $this->integer('TUSCodigo', 'TipoUsuario.codigo')->chaveEstrangeira()->referencia('TUSCodigo', 'codigo')->on('TBUsuario');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {
        $this->varchar('USUId'   , 'id');
        $this->varchar('USUSenha', 'senha');
        $this->boolean('USUAtivo', 'ativo');
        $this->boolean('USUTermo', 'termo');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBUsuario';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'USU';
    }


}