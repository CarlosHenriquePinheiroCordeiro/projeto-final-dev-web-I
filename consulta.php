<?php
require_once('autoload.php');

/**
 * Monta a consulta para a tela
 * @param string $classe
 * @param array $colunas
 */
function consulta(string $classe, array $consulta) {
    $modelo = newModelo($classe);
    $dados  = newDadosModelo($classe);
    $acao   = newClasseAcao($classe);
    $dados->setModelo($modelo);
    $acao->setDados($dados);
    echo $acao->consulta($consulta);
}

/**
 * Retorna uma nova instância da classe de Acao do objeto desejado
 * @param string $nomeClasse
 */
function newClasseAcao(string $nomeClasse) : mixed {
    $classe = 'Acao'.ucfirst($nomeClasse);
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de modelo do objeto desejado
 *  @param string $nomeClasse
 */
function newModelo(string $nomeClasse) : mixed {
    $classe = ucfirst($nomeClasse);
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de Dados do objeto desejado
 *  @param string $nomeClasse
 */
function newDadosModelo(string $nomeClasse) : mixed{
    $classe = 'Dados'.ucfirst($nomeClasse);
    return new $classe();
}