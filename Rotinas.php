<?php

/**
 * Classe que contém os acessos para as rotinas do sistema
 */
abstract class Rotinas {

    private static $rotinasPerfil = [
        'Administrador' => ['perfis', 'materia'],
        'Professor'     => ['materia'],
        'Responsavel'   => ['vinculados'],
        'Aluno'         => []
    ];

    /**
     * Retorna os caminhos para as rotinas que o usuário, filtrado pelo tipo, pode acessar
     * @return array
     */
    public static function rotinasPorPerfil() : array {
        $rotinas = [];
        foreach (self::$rotinasPerfil[$_SESSION['tipo']] as $rotina) {
            $rotinas[] = self::$rotina();
        }
        return $rotinas;
    }

    /**
     * Retorna o caminho para a rotina de Perfis
     * @return string
     */
    private static function perfis() : string {
        return '<a href="perfis.php">Perfis</a>';
    }

    /**
     * Retorna o caminho para a rotina de Meu Perfil
     * @return string
     */
    private static function meuPerfil() : string {
        return '';
    }

    /**
     * Retorna o caminho para a rotina de Matéria
     * @return string
     */
    private static function materia() : string {
        return '<a href="materia.php">Matéria</a>';
    }


}