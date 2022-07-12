<?php
require_once('autoload.php');

class AcaoRegistroAula extends AcaoBase {

    /**
     * {@inheritdoc}
     */
    protected function filtraConsulta() {
        $chaveSalaVirtual = isset($_GET['c_codigo']) ? $_GET['c_codigo'] : $_GET['codigoSalaVirtual'];
        $this->adicionaCondicao('SalaVirtual.codigo', '=', $chaveSalaVirtual);
        return parent::filtraConsulta();
    }


}