<?php
require_once('autoload.php');

if (getAcao() == 'login') {
    processaLogin();
}
else {
    processaLogoff();
}

/**
 * Processa a ação de login
 */
function processaLogin() {
    $codigoUser     = '';
    $codigoPessoa   = '';
    $user           = '';
    $pass           = '';
    $tipo           = '';
    $nomeTipo       = '';
    $ativo          = '';
    $aceitaTermo    = '';
    $stmt = Connect::getInstance()->query(getSqlLogin(getPost('user'), sha1(getPost('pass'))));
    while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codigoUser     = $linha['codigoUser'];
        $codigoPessoa   = $linha['codigoPessoa'];
        $user           = $linha['user'];
        $pass           = $linha['pass'];
        $tipo           = $linha['tipo'];
        $nomeTipo       = $linha['nomeTipo'];
        $ativo          = $linha['ativo'];
        $aceitaTermo    = $linha['aceitaTermo'];
    }
    $location = 'index.php';
    if (getPost('user') == $user && $pass == sha1(getPost('pass'))) {
        session_start();
        $_SESSION['codigoUser']     = $codigoUser;
        $_SESSION['codigoPessoa']   = $codigoPessoa;
        $_SESSION['user']           = $user;
        $_SESSION['pass']           = $pass;
        $_SESSION['tipo']           = $tipo;
        $_SESSION['nomeTipo']       = $nomeTipo;
        $_SESSION['ativo']          = $ativo;
        $_SESSION['aceitaTermo']    = $aceitaTermo;
        if ($ativo == 1) {
            $location = 'home.php';
            if (!$aceitaTermo) {
                $location = 'aceitaLgpd.php';
            }
        } else {
            session_destroy();
        }
    }
    header('location:'.$location);
}

/**
 * Retorna o SQL para a autenticação
 */
function getSqlLogin($user, $pass) {
    return 'SELECT   TBUsuario.USUCodigo   as "codigoUser", '
        .           'TBPessoa.PESCodigo    as "codigoPessoa", '
        .           'TBUsuario.USUId       as "user", '
        .           'TBUsuario.USUSenha    as "pass", '
        .           'TBUsuario.TUSCodigo   as "tipo", '
        .           'TBTipoUsuario.TUSNome as "nomeTipo", '
        .           'TBUsuario.USUAtivo    as "ativo", '
        .           'TBUsuario.USUTermo    as "aceitaTermo" '
        .   ' FROM TBUsuario'
        .   ' JOIN TBTipoUsuario'
        .     ' ON TBTipoUsuario.TUSCodigo = TBUsuario.TUSCodigo'
        .   ' LEFT JOIN TBPessoa'
        .     ' ON TBPessoa.USUCodigo = TBUsuario.USUCodigo'
        .  ' WHERE USUId = \''.$user.'\''
        .    ' AND USUSenha = \''.$pass.'\';';
}

/**
 * Processa a ação de logoff do sistema
 */
function processaLogoff() {
    session_start();
    session_destroy();
    header('location:..'.DIRECTORY_SEPARATOR.'index.php');
}

/**
 * Retorna a ação requisitada
 */
function getAcao() {
    return getPost('acao');
}

/**
 * Retorna uma variável vinda do POST
 */
function getPost($post) {
    return isset($_POST[$post]) ? $_POST[$post] : false;
}