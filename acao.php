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
function consulta(string $classe, string $tela, array $consulta) {
    $modelo = instanciaModelo($classe);
    $dados  = instanciaDadosModelo($classe);
    $acao   = instanciaClasseAcao($classe);
    $dados->setModelo($modelo);
    $acao->setDados($dados);
    echo $acao->consulta(ucfirst($classe), ucfirst($tela), $consulta);
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
    if (getAcao() != false && in_array(getAcao(), ACOES)) {
        $acao = 'processa'.ucfirst(getAcao());
        $classeAcao = instanciaClasseAcao();
        $classeAcao->setDados(getDadosParaAcao());
        $classeAcao->getDados()->begin();
        if ($classeAcao->$acao()) {
            $classeAcao->getDados()->commit();
        } else {
            $classeAcao->getDados()->rollback();
        }
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
    $modelo = instanciaModelo();
    foreach (getCamposFormulario() as $campo => $valor) {
        $nomeCampo = str_replace('c_', '', $campo);
        $nomeCampo = str_replace('_', '.', $nomeCampo);
        setValorCampoModelo($modelo, $nomeCampo, $valor);
    }
    return $modelo;
}

/**
 * Seta o valor no modelo conforme o campo do formulário
 * @param mixed $modelo
 * @param Relacionamento $relacionamento
 */
function setValorCampoModelo(mixed $modelo, string $campo, string $valor) {
    $caminho  = explode('.', $campo);
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
            setaValorAtributo($modelo, $atributo, $valor);
        }
    }
}

/**
 * Seta o valor no atributo do relacionamento enviado
 * @param mixed $atributo
 * @param string $relacionamento
 * @param mixed $valor
 */
function setaValorAtributo(mixed $modelo, string $atributo, mixed $valor) {
    $setter = 'set'.ucfirst($atributo);
    $modelo->$setter($valor);
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
 * @return mixed
 */
function getParametro($parametro) : mixed {
    return getPost($parametro) ? getPost($parametro) : getGet($parametro);
}

/**
 * Retorna os campos vindos do formulário enviado
 * @return array
 */
function getCamposFormulario() : array {
    $campos = [];
    foreach ($_POST as $chave => $valor) {
        if (preg_match("/c_.*/", $chave)) {
            $campos[$chave] = $valor;
        }
    }
    foreach ($_GET as $chave => $valor) {
        if (preg_match("/c_.*/", $chave)) {
            $campos[$chave] = $valor;
        }
    }
    return $campos;
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