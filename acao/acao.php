<?php
require_once('../classes/aluno.class.php');
require_once('../classes/dados/dados_aluno.php');
instanciaDadosModelo();


function processaAcao() {
    $acao = [
        'incluir' => (function() { processaInclusao();  }),
        'alterar' => (function() { processaAlteracao(); }),
        'excluir' => (function() { processaExclusao();  }),
    ];
    $acao[getAcao()]();
}


function processaInclusao() {

}


function processaAlteracao() {

}


function processaExclusao() {

}


function setDadosModelo() {
    
}


function instanciaModelo() {
    $classe = 'classes'.DIRECTORY_SEPARATOR.ucfirst('aluno');
    return new $classe();
}


function instanciaDadosModelo() {
    $classe = 'dados'.DIRECTORY_SEPARATOR.ucfirst('dadosAluno');
    $modelo = new $classe();
    return $modelo;
}


function getAcao() {
    return getPost('acao');
}


function getNomeClasse() {
    return getPost('classe');
}

/**
 * Retorna uma variável vinda do POST
 */
function getPost($post) {
    return isset($_POST[$post]) ? $_POST[$post] : false;
}