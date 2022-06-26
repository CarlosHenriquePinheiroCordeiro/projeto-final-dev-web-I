<?php
require_once('..'.DIRECTORY_SEPARATOR.'autoload.php');

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
    $user = '';
    $pass = '';
    $tipo = '';
    $aceitaTermo = '';
    $stmt = Connect::getInstance()->query(getSqlLogin(getPost('user'), sha1(getPost('pass'))));
    while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codigoUser  = $linha['USUCodigo'];
        $user        = $linha['USUId'];
        $pass        = $linha['USUSenha'];
        $tipo        = $linha['TUSNome'];
        $ativo       = $linha['USUAtivo'];
        $aceitaTermo = $linha['USUTermo'];
    }
    $location = '..'.DIRECTORY_SEPARATOR.'index.php';
    if (getPost('user') == $user && $pass == sha1(getPost('pass'))) {
        session_start();
        $_SESSION['codigoUser']     = $codigoUser;
        $_SESSION['user']           = $user;
        $_SESSION['pass']           = $pass;
        $_SESSION['tipo']           = $tipo;
        $_SESSION['ativo']          = $ativo;
        $_SESSION['aceitaTermo']    = $aceitaTermo;
        if ($ativo) {
            $location = '..'.DIRECTORY_SEPARATOR.'home.php';
            if (!$aceitaTermo) {
                $location = '..'.DIRECTORY_SEPARATOR.'aceitaLgpd.php';
            }
        }
    }
    header('location:'.$location);
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