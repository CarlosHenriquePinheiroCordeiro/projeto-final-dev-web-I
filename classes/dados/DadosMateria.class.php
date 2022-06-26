<?php
require_once('..'.DIRECTORY_SEPARATOR.'autoload.php');

class DadosMateria extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->integer('matcodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {}

    /**
     * Define as outras colunas da tabela
     */
    public function outrasColunas() {
        $this->varchar('matnome', 'nome');
        $this->varchar('matdescricao', 'descricao');
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