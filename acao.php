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
 * @param string $classe Nome da classe de ação
 * @param array $colunas Colunas da consulta
 * @param string $tela Nome da tela que as ações dos registros vão chamar
 */
function consulta(string $classe, array $consulta, string $tela = '', array $parametros = []) {
    $modelo = instanciaModelo($classe);
    $dados  = instanciaDadosModelo($classe);
    $acao   = instanciaClasseAcao($classe);
    $dados->setModelo($modelo);
    $acao->setDados($dados);
    echo $acao->consulta(ucfirst($classe), $consulta, $tela, $parametros);
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
 * Retorna todos os registros de determinado objeto em uma determinada forma de seleção para o HTML
 * @param string $classe
 * @param string $name
 * @param string $titulo
 * @param int    $tipo
 * @param mixed  $valor
 * @return string
 */
function getLista(string $classe, string $name, string $titulo, int $tipo, mixed $valor = null) {
    $classeDados = instanciaDadosModelo($classe);
    return $classeDados->getLista($name, $titulo, $tipo, $valor);
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
function getDadosParaAcao(string $classe = null) : mixed {
    $dados = instanciaDadosModelo($classe);
    $dados->setModelo(getModeloComDadosFormulario($classe));
    return $dados;
}

/**
 * Retorna uma classe de modelo com os dados vindos do formulário
 * @return mixed
 */
function getModeloComDadosFormulario(string $classe = null) : mixed {
    $modelo = instanciaModelo($classe);
    foreach (getCamposFormulario() as $campo => $valor) {
        $nomeCampo = str_replace('c_', '', $campo);
        $nomeCampo = str_replace('_', '.', $nomeCampo);
        setValorCampoModelo($modelo, $nomeCampo, $valor);
    }
    foreach (getCamposFormulario(true) as $campo => $valores) {
        $nomeCampo = str_replace('a_', '', $campo);
        $nomeCampo = str_replace('_', '.', $nomeCampo);
        setAssociativosModelo($modelo, $nomeCampo, $valores);
    }
    return $modelo;
}

/**
 * Seta o valor no modelo conforme o campo do formulário
 * @param mixed $modelo
 * @param string $campo
 * @param string $valor
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
 * Seta o valor das associativas do modelo
 * @param mixed $modelo
 * @param string $campo
 * @param array $valores
 */
function setAssociativosModelo(mixed $modelo, string $campo, array $valores) {
    $caminho     = explode('.', $campo);
    $associativo = array_shift($caminho);
    $metodoNew   = 'new'.$associativo;
    foreach ($valores as $valor) {
        $objAssociativo = $modelo->$metodoNew();
        setValorRecursivo($objAssociativo, $caminho, $valor);
    }
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
function instanciaModelo(string $nomeModelo = null) : mixed {
    $classe = $nomeModelo != null ? ucfirst($nomeModelo) : getClasse();
    return new $classe();
}

/**
 * Retorna uma nova instância da classe de Dados do objeto desejado
 * @return mixed
 */
function instanciaDadosModelo(string $nomeDados = null) : mixed {
    $classe = $nomeDados != null ? 'Dados'.ucfirst($nomeDados) : 'Dados'.getClasse();
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
function getCamposFormulario($associativos = false) : array {
    $campos = [];
    $regex = $associativos ? "/^a_.*/" : "/^c_.*/";
    foreach ($_POST as $chave => $valor) {
        if (preg_match_all($regex, $chave)) {
            $campos[$chave] = $valor;
        }
    }
    foreach ($_GET as $chave => $valor) {
        if (preg_match_all($regex, $chave)) {
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