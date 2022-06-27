<?php

/**
 * Classe que contém os acessos para as rotinas do sistema
 */
abstract class Rotinas {

    const ADMINISTRADOR = 1;
    const PROFESSOR     = 2;
    const RESPONSÁVEL   = 3;
    const ALUNO         = 4;

    private static $rotinasPerfil = [
        self::ADMINISTRADOR => ['perfis', 'materia'],
        self::PROFESSOR     => ['materia'],
        self::RESPONSÁVEL   => ['vinculados'],
        self::ALUNO         => []
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
        return '<a href="consultaPerfis.php">Perfis</a>';
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
        return '<a href="consultaMateria.php">Matéria</a>';
    }


}