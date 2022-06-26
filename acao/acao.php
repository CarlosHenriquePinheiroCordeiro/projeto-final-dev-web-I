<?php
require_once('..'.DIRECTORY_SEPARATOR.'autoload.php');

processaAcao();

/**
 * Processa qualquer ação que não seja login
 */
function processaAcao() {
    if (getAcao() != false) {
        $classeAcao = instanciaClasseAcao();
        $classeAcao->setDados(getDadosParaAcao());
        $acao = 'processa'.ucfirst(getAcao());
        $classeAcao->$acao();
        $tela = '..'.DIRECTORY_SEPARATOR.'tela'.DIRECTORY_SEPARATOR.getPost('tela');
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

function consulta(string $classe, array $colunas) {
    $modelo = instanciaModelo($classe);
    $dados  = instanciaDadosModelo($classe);
    $acao   = instanciaClasseAcao($classe);
    $dados->setModelo($modelo);
    $acao->setDados($dados);
    echo $acao->consulta($colunas);
}

/**
 * Retorna uma nova instância da classe de Acao do objeto desejado
 */
function instanciaClasseAcao($nomeClasse = false) {
    $nomeObjeto = $nomeClasse ? ucfirst($nomeClasse) : getClasseAcao();
    $classe = 'Acao'.$nomeObjeto;
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de modelo do objeto desejado
 */
function instanciaModelo($nomeClasse = false) {
    $classe = $nomeClasse ? ucfirst($nomeClasse) : getClasse();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de Dados do objeto desejado
 */
function instanciaDadosModelo($nomeClasse = false) {
    $nomeObjeto = $nomeClasse ? ucfirst($nomeClasse) : getClasse();
    $classe = 'Dados'.$nomeObjeto;
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