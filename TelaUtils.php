<?php
require_once('autoload.php');

/**
 * Classe que contém os componentes básicos para as telas
 */
abstract class TelaUtils {

    /**
     * Traz <head> com os links padrões do sistema
     */
    public static function headPadraoPagina() : string {
        $padrao = '<link rel="stylesheet" href="style'.DIRECTORY_SEPARATOR.'style.css">';
        return  $padrao;
    }

    /**
     * Retorna o topo da página
     * @return string
     */
    public static function topoPagina($titulo) : string {
        $topoPagina =   '<header>';
        $topoPagina .=      '<nav>';
        $topoPagina .=          '<a class="logo" href="'.DIRECTORY_SEPARATOR.'">'.$titulo.'</a>';
        $topoPagina .=          '<ul class="nav-list">';
        $topoPagina .=              self::getRotinasTopoPagina();
        $topoPagina .=              self::getLogoff();
        $topoPagina .=          '</ul>';
        $topoPagina .=      '</nav>';
        $topoPagina .=  '</header>';
        return $topoPagina;
    }

    /**
     * Retorna as rotinas para o navbar da página
     */
    private static function getRotinasTopoPagina() : string {
        $rotinas = '';
        foreach (Rotinas::rotinasPorPerfil() as $rotina) {
            $rotinas .= '<li>'.$rotina.'</li>';
        }
        return $rotinas;
    }

    /**
     * Retorna o caminho da ação de logoff do sistema
     * @return string
     */
    private static function getLogoff() : string {
        return  '<li>'
            .       '<a href="acao'.DIRECTORY_SEPARATOR.'acaoLogin.php">Sair</a>'
            .   '</li>';
    }


    public static function getBotaoIncluir() {

    }


    public static function getBotaoAlterar($chave) {

    }

    
    public static function getBotaoExcluir($chave) {

    }


}

