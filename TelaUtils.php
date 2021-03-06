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
        $topoPagina .=          '<a class="logo">'.$titulo.'</a>';
        $topoPagina .=          '<ul class="nav-list">';
        $topoPagina .=              '<li><a href="home.php">Página Inicial</a></li>';
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
            .       '<a href="login.php">Sair</a>'
            .   '</li>';
    }

    /**
     * Retorna o botão de Incluir
     */
    public static function botaoIncluir(string $classe, array $parametrosGet = null) : string {
        $botao = '';
        if ($_SESSION['tipo'] != Usuario::PERFIL_ALUNO) {
            $link = 'cad'.ucfirst($classe).'.php';
            if ($parametrosGet != null) {
                $link .= self::montaParametros($parametrosGet);
            }
            $botao = '<a href='.$link.' class="logo">Incluir</a>';
        }
        return $botao;
    }

    /**
     * Retorna o array de parâmetros para o link
     * @param array $parametros
     * @return string
     */
    private static function montaParametros(array $parametros) {
        return '?'.implode('&', $parametros);
    }

    /**
     * Retorna a tela que deve ser aberta após a ação requisitada ser concluída
     * @param string $tela
     */
    public static function telaRedirecionar(string $tela, array $parametros = null) {
        $value = $tela.'.php';
        if ($parametros != null) {
            $value .= self::montaParametros($parametros);
        }
        echo '<input type="hidden" name="tela" value="'.$value.'">';
    }

    /**
     * Retorna o input que informa a classe de ação do formulário
     * @param string $classe
     */
    public static function classeAcaoForm(string $classe) {
        echo '<input type="hidden" name="classeAcao" value="'.$classe.'">';
    }

    /**
     * Retorna o input que informa a classe de modelo do formulário.
     * Apenas é chamada quando se deseja trabalhar com uma classe de ação diferente da classe de modelo, apenas para casos específicos,
     * como por exemplo a aceitação dos termos da lgpd. Se não for o caso, basta apenas chamar "getClasseAcaoForm"
     * @param string $classe
     */
    public static function classeForm(string $classe) {
        echo '<input type="hidden" name="classe" value="'.$classe.'">';
    }

    /**
     * Retorna o botão de submit do formulário de inclusão
     */
    public static function submitInclusao() {
        self::submit('inclusao');
    }

    /**
     * Retorna o botão de submit do formulário, de acordo com a ação
     * @param string $acao
     */
    public static function submit(string $acao) {
        $nomeAcao = $acao == 'alterar' ? 'alteracao' : $acao;
        echo '<button type="submit" name="acao" value="'.$nomeAcao.'">Salvar</button>';
    }


}

