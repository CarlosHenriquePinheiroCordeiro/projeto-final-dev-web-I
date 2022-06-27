<?php
require_once('autoload.php');

class AcaoUsuario extends AcaoBase {

    /**
     * {@inheritdoc}
     */
    protected function getAcoesConsulta() : array {
        $acoes = parent::getAcoesConsulta();
        $acoes[] = self::ACAO_ATIVAR;
        $acoes[] = self::ACAO_DESATIVAR;
        return $acoes;
    }


}