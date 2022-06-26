<?php

spl_autoload_register(function ($nomeClasse) {
    $folders = array(
        $nomeClasse,
        '.'.DIRECTORY_SEPARATOR.$nomeClasse,
        '..'.DIRECTORY_SEPARATOR.$nomeClasse,
        'acao',
        '.'.DIRECTORY_SEPARATOR.'acao', 
        '..'.DIRECTORY_SEPARATOR.'acao', 
        'classes', 
        '.'.DIRECTORY_SEPARATOR.'classes', 
        '..'.DIRECTORY_SEPARATOR.'classes', 
        'classes'.DIRECTORY_SEPARATOR.'dados', 
        '.'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'dados', 
        '..'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'dados', 
        'conf',
        '.'.DIRECTORY_SEPARATOR.'conf',
        '..'.DIRECTORY_SEPARATOR.'conf',
        'interfaces',
        '.'.DIRECTORY_SEPARATOR.'interfaces',
        '..'.DIRECTORY_SEPARATOR.'interfaces'
    );
    foreach ($folders as $folder) {
        if (file_exists($nomeClasse.'.php')) {
            require_once($nomeClasse.'.php');
        }
        if (file_exists($folder.DIRECTORY_SEPARATOR.$nomeClasse.'.class.php')) {
            require_once($folder.DIRECTORY_SEPARATOR.$nomeClasse.'.class.php');
        }
        if (file_exists($folder.DIRECTORY_SEPARATOR.$nomeClasse.'.interface.php')) {
            require_once($folder.DIRECTORY_SEPARATOR.$nomeClasse.'.interface.php');
        }
    }
});