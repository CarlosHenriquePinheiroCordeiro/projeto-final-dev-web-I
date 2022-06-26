<?php
require_once('autoload.php');

processaAcao();

/**
 * Processa qualquer ação que não seja login
 */
function processaAcao() {
    $acao = 'processa'.ucfirst(getAcao());
    if (getAcao() != false) {
        $classeAcao = instanciaClasseAcao();
        $classeAcao->setDados(getDadosParaAcao());
        $tela = getPost('tela');
        header('location:'.$tela);
    }
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
 * @return mixed
 */
function instanciaClasseAcao() : mixed {
    $classe = 'Acao'.getClasseAcao();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de modelo do objeto desejado
 * @return mixed
 */
function instanciaModelo() : mixed {
    $classe = getClasse();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de Dados do objeto desejado
 * @return mixed
 */
function instanciaDadosModelo() : mixed {
    $classe = 'Dados'.getClasse();
    return new $classe();
}

/**
 * Retorna a ação requisitada
 * @return string
 */
function getAcao() : string {
    return getPost('acao');
}

/**
 * Retorna o nome da classe de ação, tendo que ser definida sempre
 * @return string
 */
function getClasseAcao() : string {
    return getPost('classeAcao');
}

/**
 * Retorna o nome da classe desejada. Se não houver definida, pega o nome da classe de ação.
 * Pode se definir o nome da classe separada do nome da classe de ação para momentos específicos, como
 * a aceitação dos termos da LGPD
 * @return string
 */
function getClasse() : string {
    return getPost('classe') ? ucfirst(getPost('classe')) : ucfirst(getPost('classeAcao'));
}

/**
 * Retorna uma variável vinda do POST
 * @return string
 */
function getPost($post) : string {
    return isset($_POST[$post]) ? $_POST[$post] : false;
}