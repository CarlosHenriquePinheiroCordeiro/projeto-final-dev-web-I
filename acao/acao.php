<?php
require_once('../autoload.php');

processaAcao();

/**
 * Processa a ação solicitada
 */
function processaAcao() {
    if (getAcao() == 'login') {
        processaLogin();
    }
    else if (getAcao() == 'logoff') {
        processaLogoff();
    } else {
        processaAcaoNormal();
    }
}

/**
 * Processa a ação de login
 */
function processaLogin() {
    $user = '';
    $pass = '';
    $tipo = '';
    $aceitaTermo = '';
    $stmt = Connect::getInstance()->query(getSqlLogin(getPost('user'), sha1(getPost('pass'))));
    while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user        = $linha['USUId'];
        $pass        = $linha['USUSenha'];
        $tipo        = $linha['TUSNome'];
        $aceitaTermo = $linha['USUTermo'];
    }
    if (getPost('user') == $user && $pass == sha1(getPost('pass'))) {
        session_start();
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        $_SESSION['tipo'] = $tipo;
        header('location:../home.php');
    } else {
        header('location:../index.php');
    }
}

/**
 * Retorna o SQL para a autenticação
 */
function getSqlLogin($user, $pass) {
    return 'SELECT *'
        .   ' FROM TBUsuario'
        .   ' JOIN TBTipoUsuario'
        .     ' ON TBTipoUsuario.TUSCodigo = TBUsuario.TUSCodigo'
        .  ' WHERE USUId = \''.$user.'\''
        .    ' AND USUSenha = \''.$pass.'\';';
}

/**
 * Processa a ação de logoff do sistema
 */
function processaLogoff() {
    session_start();
    session_destroy();
    header('location:index.php');
}

/**
 * Processa qualquer ação que não seja login
 */
function processaAcaoNormal() {
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