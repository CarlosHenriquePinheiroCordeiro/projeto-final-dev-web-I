<?php
require_once('../autoload.php');
processaAcao();

/**
 * Chama o processamento da ação solicitada, na devida classe de Acao
 */
function processaAcao() {
    $classeAcao = instanciaAcaoClasse();
    $classeAcao->setDados(getDadosParaAcao());
    $acao = 'processa'.ucfirst(getAcao());
    try {
        $classeAcao->$acao();
    } catch (\Throwable $th) {
        echo 'Erro';
    }
    
}

/**
 * Retorna a classe de dados pronta para ser utilizada pela classe de Acao
 */
function getDadosParaAcao() {
    $dados = instanciaDadosModelo();
    $dados->setModelo(getModeloComDadosFormulario());
    return $dados;
}

/**
 * Retorna uma classe de modelo com os dados vindos do formulário
 */
function getModeloComDadosFormulario() {
    $dados = instanciaDadosModelo();
    $modelo = instanciaModelo();
    foreach ($dados->getRelacionamentos() as $relacionamento) {
        $setter = 'set'.ucfirst($relacionamento->getAtributo());
        $modelo->$setter(getPost($relacionamento->getAtributo()));
    }
    return $modelo;
}

/**
 * Retorna uma nova instância da classe de Acao do objeto desejado
 */
function instanciaAcaoClasse() {
    $classe = 'Acao'.getNomeClasse();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de modelo do objeto desejado
 */
function instanciaModelo() {
    $classe = getNomeClasse();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de Dados do objeto desejado
 */
function instanciaDadosModelo() {
    $classe = 'Dados'.getNomeClasse();
    return new $classe();
}

/**
 * Retorna a ação requisitada
 */
function getAcao() {
    return getPost('acao');
}

/**
 * Retorna o nome da classe desejada
 */
function getNomeClasse() {
    return getPost('classe');
}

/**
 * Retorna uma variável vinda do POST
 */
function getPost($post) {
    return isset($_POST[$post]) ? $_POST[$post] : false;
}