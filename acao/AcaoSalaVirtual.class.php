<?php
require_once('autoload.php');

class AcaoSalaVirtual extends AcaoBase {

    /**
     * {@inheritdoc}
     */
    protected function getAcoesConsulta(): array {
        $acoes = parent::getAcoesConsulta();
        $acoes[] = self::ACAO_PROFESSORES;
        $acoes[] = self::ACAO_ALUNOS;
        return $acoes;
    }


}