<?php
require_once('..'.DIRECTORY_SEPARATOR.'autoload.php');

class DadosAceitaLgpd extends DadosUsuario {

    /**
     * {@inheritdoc}
     */
    public function getColunaAtivarDesativar() : string {
        return $this->getSiglaTabela().'Termo';
    }


}