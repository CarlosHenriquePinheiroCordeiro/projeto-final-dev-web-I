<?php
require_once('../autoload.php');

class DadosAluno extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    function definePrimarias() {
        $this->integer('id', 'id')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    function defineEstrangeiras() {
        
    }

    /**
     * Define as outras colunas da tabela
     */
    function outrasColunas() {
        $this->varchar('nome', 'nome');
        $this->date('dataTeste', 'data');
    }

    /**
     * Retorna o nome da tabela
     */
    function getTabela() {
        
    }

    /**
     * Retorna o prefixo (sigla) que representa a tabela, para as colunas. Por exemplo,
     * o prefixo "USU" da tabela Usuario, assim tendo o campo USUCodigo (código do usuário)
     */
    function getTbSigla() {
        
    }



}