<?php
namespace interface;

interface InterfaceDados {

    /**
     * Define as chaves primárias da tabela
     */
    function definePrimarias();

    /**
     * Define as chaves estrangeiras da tabela
     */
    function defineEstrangeiras();

    /**
     * Define as outras colunas da tabela
     */
    function outrasColunas();

    /**
     * Retorna o nome da tabela
     */
    function getTabela();

    /**
     * Retorna o prefixo (sigla) que representa a tabela, para as colunas. Por exemplo,
     * o prefixo "USU" da tabela Usuario, assim tendo o campo USUCodigo (código do usuário)
     */
    function getTbSigla();



}