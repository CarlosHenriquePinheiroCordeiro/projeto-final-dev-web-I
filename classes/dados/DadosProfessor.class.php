<?php
require_once('autoload.php');

class DadosProfessor extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->bigint('PROCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {
        $this->bigint('PESCodigo', 'Pessoa.codigo')->chaveEstrangeira()->referencia('PESCodigo', 'codigo')->on('TBPessoa');
    }

    /**
     * Define as outras colunas da tabela
     */
    public function outrasColunas() {}

    /**
     * Retorna o nome da tabela
     */
    public function getTabela() {
        return 'TBProfessor';
    }

    /**
     * Retorna o nome da tabela
     */
    public function getSiglaTabela() {
        return 'PRO';
    }


}