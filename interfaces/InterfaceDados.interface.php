<?php

interface InterfaceDados {

    /**
     * Define as chaves da tabela, tanto primárias quanto estrangeiras
     */
    function defineChaves();

    /**
     * Define as outras colunas da tabela
     */
    function outrasColunas();

    /**
     * Retorna o nome da tabela
     */
    function getTabela();

    /**
     * Retorna a sigla da tabela
     */
    function getSiglaTabela();


}