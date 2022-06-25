<?php

/**
 * Classe que contém os componentes básicos para as telas
 */
abstract class TelaUtils {

    public static function getTopoPagina() {

    }

    public function getRotinasTopoPagina() {
        
    }

    /**
     * Retorna o botão da ação de logoff do sistema
     * @return string
     */
    public static function getBotaoLogoff() {
        return '<div>'
            .       '<form action="acao/acao.php" method="post">'
            .           '<button type="submit" name="acao" value="logoff">Sair</button>'
            .       '</form>'
            .'</div>';
    }


    public static function getBotaoIncluir() {

    }


    public static function getBotaoAlterar($chave) {

    }

    
    public static function getBotaoExcluir($chave) {

    }


}