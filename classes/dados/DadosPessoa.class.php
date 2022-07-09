<?php
require_once('autoload.php');

class DadosPessoa extends DadosBase {

    /**
     * {@inheritdoc}
     */
    public function defineChaves() {
        $this->integer('PESCodigo', 'codigo'        )->chavePrimaria();
        $this->integer('USUCodigo', 'Usuario.codigo')->chaveEstrangeira()->referencia('USUCodigo', 'codigo')->on('TBUsuario');
    }

    /**
     * {@inheritdoc}
     */
    public function outrasColunas() {
        $this->varchar('PESNome'          , 'nome');
        $this->date   ('PESDataNascimento', 'dataNascimento');
        $this->varchar('PESCpf'           , 'cpf');
        $this->varchar('PESRg'            , 'rg');
    }

    /**
     * {@inheritdoc}
     */
    protected function adicionaJoins(): string {
        $join = parent::adicionaJoins();
        $join .= ' JOIN TBTipoUsuario'
                .  ' ON TBTipoUsuario.TUSCodigo = TBUsuario.TUSCodigo';
        return $join;
    }

    /**
     * {@inheritdoc}
     */
    protected function getQueryBuscaDados(array $colunas = []): string {
        $sql = 'SELECT  TBPessoa.PESCodigo as "codigo", '
            .           'TBPessoa.PESNome   as "nome", '
            .           'TBPessoa.PESDataNascimento as "dataNascimento", '
            .           'TBPessoa.PESCpf as "cpf", '
            .           'TBPessoa.PESRg as "rg", '
            .           'TBUsuario.USUCodigo as "Usuario.codigo", '
            .           'TBUsuario.USUId as "Usuario.id", '
            .           'TBUsuario.USUSenha as "Usuario.senha", '
            .           'TBUsuario.USUAtivo as "Usuario.ativo", '
            .           'TBUsuario.USUTermo as "Usuario.termo", '
            .           'TBTipoUsuario.TUSCodigo as "Usuario.TipoUsuario.codigo", '
            .           'TBTipoUsuario.TUSNome as "Usuario.TipoUsuario.nome" ';
        $sql .= ' FROM '.$this->getTabela();
        $sql .= $this->adicionaJoins();
        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function getTabela() {
        return 'TBPessoa';
    }

    /**
     * {@inheritdoc}
     */
    public function getSiglaTabela() {
        return 'PES';
    }


}