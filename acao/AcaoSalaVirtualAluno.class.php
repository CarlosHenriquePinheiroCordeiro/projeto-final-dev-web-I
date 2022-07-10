<?php
require_once('autoload.php');

class AcaoSalaVirtualAluno extends AcaoBase {

    /**
     * {@inheritdoc}
     */
    protected function getAcoesConsulta(): array {
        return [self::ACAO_EXCLUIR];
    }

    /**
     * @inheritdoc
     */
    protected function filtraConsulta() {
        $chave = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : $_GET['codigoSalaVirtual'];
        if ($chave) {
            $this->adicionaCondicao('SalaVirtual.codigo', '=', $chave);
        }
    }


}