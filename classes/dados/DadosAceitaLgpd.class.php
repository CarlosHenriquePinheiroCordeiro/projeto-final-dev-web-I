<?php
require_once('autoload.php');

class DadosAceitaLgpd extends DadosUsuario {

    /**
     * {@inheritdoc}
     */
    public function getColunaAtivarDesativar() : string {
        return $this->getSiglaTabela().'Termo';
    }


}