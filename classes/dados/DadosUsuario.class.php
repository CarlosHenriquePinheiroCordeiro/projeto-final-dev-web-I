<?php
require_once('autoload.php');

class DadosUsuario extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->bigint('USUCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {
        $this->integer('TUSCodigo', 'TipoUsuario.codigo')->chaveEstrangeira()->referencia('TUSCodigo', 'codigo')->on('TBUsuario');
    }

    /**
     * Define as outras colunas da tabela
     */
    public function outrasColunas() {
        $this->varchar('USUId'   , 'id');
        $this->varchar('USUSenha', 'senha');
        $this->boolean('USUAtivo', 'ativo');
        $this->boolean('USUTermo', 'termo');
    }

    /**
     * Retorna o nome da tabela
     */
    public function getTabela() {
        return 'TBUsuario';
    }

    /**
     * Retorna o nome da tabela
     */
    public function getSiglaTabela() {
        return 'USU';
    }


}