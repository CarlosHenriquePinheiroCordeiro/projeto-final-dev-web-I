<?php
require_once('autoload.php');

const ACOES = [
    'inclusao',
    'alteracao',
    'exclusao',
    'ativacao',
    'desativacao'
];

processaAcao();

/**
 * Monta a consulta para a tela
 * @param string $classe
 * @param array $colunas
 */
function consulta(string $classe, array $consulta) {
    $modelo = instanciaModelo($classe);
    $dados  = instanciaDadosModelo($classe);
    $acao   = instanciaClasseAcao($classe);
    $dados->setModelo($modelo);
    $acao->setDados($dados);
    echo $acao->consulta(ucfirst($classe), $consulta);
}

/**
 * Retorna um objeto para a tela
 * @param string $classe
 * @param mixed $chave
 * @return mixed
 */
function buscaDados(string $classe) {
    $dados = getDadosParaAcao($classe);
    $dados->buscaDados();
    return $dados->getModelo();
}

/**
 * Processa qualquer ação que não seja login
 */
function processaAcao() {
    echo getAcao();
    if (getAcao() != false && in_array(getAcao(), ACOES)) {
        $acao = 'processa'.ucfirst(getAcao());
        $classeAcao = instanciaClasseAcao();
        $classeAcao->setDados(getDadosParaAcao());
        $classeAcao->$acao();
        $tela = getParametro('tela');
        header('location:'.$tela);
    }
}

/**
 * Retorna a classe de dados pronta para ser utilizada pela classe de Acao
 * @param string $classe
 * @return mixed
 */
function getDadosParaAcao($classe = false) : mixed {
    $dados = instanciaDadosModelo($classe);
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
    $valor    = getParametro(str_replace('.', '_', $relacionamento->getAtributo()));
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
    $modelo->$setter(getParametro($atributo));
}

/**
 * Retorna uma nova instância da classe de Acao do objeto desejado
 * @return mixed
 */
function instanciaClasseAcao($nomeAcao = false) : mixed {
    $classe = $nomeAcao != false ? 'Acao'.ucfirst($nomeAcao) : 'Acao'.getClasseAcao();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de modelo do objeto desejado
 * @return mixed
 */
function instanciaModelo($nomeModelo = false) : mixed {
    $classe = $nomeModelo != false ? ucfirst($nomeModelo) : getClasse();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de Dados do objeto desejado
 * @return mixed
 */
function instanciaDadosModelo($nomeDados = false) : mixed {
    $classe = $nomeDados != false ? 'Dados'.ucfirst($nomeDados) : 'Dados'.getClasse();
    return new $classe();
}

/**
 * Retorna a ação requisitada
 * @return string
 */
function getAcao() : string {
    return getParametro('acao');
}

/**
 * Retorna o nome da classe de ação, tendo que ser definida sempre
 * @return string
 */
function getClasseAcao() : string {
    return getParametro('classeAcao');
}

/**
 * Retorna o nome da classe desejada. Se não houver definida, pega o nome da classe de ação.
 * Pode se definir o nome da classe separada do nome da classe de ação para momentos específicos, como
 * a aceitação dos termos da LGPD
 * @return string
 */
function getClasse() : string {
    return getParametro('classe') ? ucfirst(getParametro('classe')) : ucfirst(getParametro('classeAcao'));
}

/**
 * Retorna um parâmetro de formulário
 */
function getParametro($parametro) : mixed {
    return getPost($parametro) ? getPost($parametro) : getGet($parametro);
}

/**
 * Retorna uma variável vinda do POST
 * @return string
 */
function getPost($post) : string {
    return isset($_POST[$post]) ? $_POST[$post] : false;
}

/**
 * Retorna uma variável vinda do GET
 * @return string
 */
function getGet($get) : string {
    return isset($_GET[$get]) ? $_GET[$get] : false;
}