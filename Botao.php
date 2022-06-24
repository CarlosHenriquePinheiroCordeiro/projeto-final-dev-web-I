<?php

/**
 * Classe que contém os botões de ação do sistema
 */
abstract class Botao {

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


}