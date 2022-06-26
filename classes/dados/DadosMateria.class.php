<?php
require_once('autoload.php');

class DadosMateria extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->integer('MATCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {}

    /**
     * Define as outras colunas da tabela
     */
    public function outrasColunas() {
        $this->varchar('MATNome'     , 'nome');
        $this->varchar('MATDescricao', 'descricao');
    }

    /**
     * Retorna o nome da tabela
     */
    public function getTabela() {
        return 'TBMateria';
    }

    /**
     * Retorna o nome da tabela
     */
    public function getSiglaTabela() {
        return 'MAT';
    }


}