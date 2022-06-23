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
    $classeAcao->$acao();
}

/**
 * Retorna a classe de dados pronta para ser utilizada pela classe de Acao
 * @return mixed
 */
function getDadosParaAcao() : mixed {
    $dados = instanciaDadosModelo();
    $dados->setModelo(getModeloComDadosFormulario());
    return $dados;
}

/**
 * Retorna uma classe de modelo com os dados vindos do formulário
 * @return mixed
 */
function getModeloComDadosFormulario() : mixed {
    $dados = instanciaDadosModelo();
    $modelo = instanciaModelo();
    foreach ($dados->getRelacionamentos() as $relacionamento) {
        if ($relacionamento->isEstrangeira()) {
            setaValorChaveEstrangeira($modelo, $relacionamento);
        } else {
            setaValorAtributo($modelo, $relacionamento->getAtributo());
        }
    }
    return $modelo;
}


function setaValorChaveEstrangeira(mixed $modelo, Relacionamento $relacionamento) {
    $caminho  = explode('.', $relacionamento->getAtributo());
    setValorRecursivo($modelo, $caminho);

}

function setValorRecursivo(mixed $modelo, array $caminho) {
    if (count($caminho) > 0) {
        $atributo = array_shift($caminho);
        if (ctype_upper($atributo[0])) {
            $getter = 'get'.$atributo;
            setValorRecursivo($modelo->$getter(), $caminho);
        } else {
            setaValorAtributo($modelo, $atributo);
        }
    }
}

/**
 * Seta o valor no atributo do relacionamento enviado
 * @param mixed $atributo
 * @param string $relacionamento
 */
function setaValorAtributo(mixed $modelo, string $atributo) {
    $setter = 'set'.ucfirst($atributo);
    $modelo->$setter(getPost($atributo));
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