<?php
require_once('autoload.php');

class AcaoSalaVirtualProfessor extends AcaoBase {

    /**
     * @inheritdoc
     */
    protected function filtraConsulta() {
        $chave = isset($_GET['c_SalaVirtual_codigo']) ? $_GET['c_SalaVirtual_codigo'] : false;
        if ($chave) {
            $this->adicionaCondicao('SalaVirtual.codigo', '=', $chave);
        }
    }


}