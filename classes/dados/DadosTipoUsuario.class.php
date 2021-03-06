<?php
require_once('autoload.php');

class DadosTipoUsuario extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->bigint('TUSCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {
        $this->varchar('TUSNome', 'nome');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBTipoUsuario';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'TUS';
    }

    /**
     * {@inheritdoc}
     */
    protected function filtraConsulta(): string {
        $this->adicionaCondicaoConsulta('codigo', '<>', Usuario::PERFIL_ADMIN);
        return parent::filtraConsulta();
    }


}