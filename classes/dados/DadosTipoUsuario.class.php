<?php
require_once('../autoload.php');

class DadosTipoUsuario extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->bigint('TUSCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {}

    /**
     * Define as outras colunas da tabela
     */
    public function outrasColunas() {
        $this->varchar('TUSNome', 'nome');
    }

    /**
     * Retorna o nome da tabela
     */
    public function getTabela() {
        return 'TBTipoUsuario';
    }

    /**
     * Retorna o nome da tabela
     */
    public function getSiglaTabela() {
        return 'TUS';
    }


}