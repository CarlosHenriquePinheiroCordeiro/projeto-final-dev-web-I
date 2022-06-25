<?php
require_once('../autoload.php');

processaAcao();

/**
 * Processa qualquer ação que não seja login
 */
function processaAcao() {
    $classeAcao = instanciaAcaoClasse();
    $classeAcao->setDados(getDadosParaAcao());
    $acao = 'processa'.ucfirst(getAcao());
    $classeAcao->$acao();
    header('location:../index.php');
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

/**
 * Seta o valor da chave estrangeira no modelo
 * @param mixed $modelo
 * @param Relacionamento $relacionamento
 */
function setaValorChaveEstrangeira(mixed $modelo, Relacionamento $relacionamento) {
    $caminho  = explode('.', $relacionamento->getAtributo());
    $valor    = getPost(str_replace('.', '_', $relacionamento->getAtributo()));
    setValorRecursivo($modelo, $caminho, $valor);

}

/**
 * Seta o valor de forma recursiva no modelo
 * @param mixed $modelo
 * @param array $caminho
 * @param mixed $valor
 */
function setValorRecursivo(mixed $modelo, array $caminho, mixed $valor) {
    if (count($caminho) > 0) {
        $atributo = array_shift($caminho);
        if (ctype_upper($atributo[0])) {
            $getter = 'get'.$atributo;
            setValorRecursivo($modelo->$getter(), $caminho, $valor);
        } else {
            $setter = 'set'.ucfirst($atributo);
            $modelo->$setter($valor);
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
    $classe = 'Acao'.getClasseAcao();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de modelo do objeto desejado
 */
function instanciaModelo() {
    $classe = getClasse();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de Dados do objeto desejado
 */
function instanciaDadosModelo() {
    $classe = 'Dados'.getClasse();
    return new $classe();
}

/**
 * Retorna a ação requisitada
 */
function getAcao() {
    return getPost('acao');
}

/**
 * Retorna o nome da classe de ação, tendo que ser definida sempre
 */
function getClasseAcao() {
    return getPost('classeAcao') ? getPost('classeAcao') : getPost('classe');
}

/**
 * Retorna o nome da classe desejada. Se não houver definida, pega o nome da classe de ação.
 * Pode se definir o nome da classe separada do nome da classe de ação para momentos específicos, como
 * a aceitação dos termos da LGPD
 */
function getClasse() {
    return getPost('classe') ? getPost('classe') : getPost('classeAcao');
}

/**
 * Retorna uma variável vinda do POST
 */
function getPost($post) {
    return isset($_POST[$post]) ? $_POST[$post] : false;
}