<?php
require_once('autoload.php');

class AcaoSalaVirtualProfessor extends AcaoBase {

    /**
     * {@inheritdoc}
     */
    protected function getAcoesConsulta(): array {
        $acoes = [];
        if ($this->getAcaoExcluir()) {
            $acoes[] = $this->getAcaoExcluir();
        }
        return $acoes;
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