<?php

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


}