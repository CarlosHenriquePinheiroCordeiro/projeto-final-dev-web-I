<?php
require_once('autoload.php');

class DadosPessoa extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->integer('PESCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {
        $this->integer('USUCodigo', 'Usuario.codigo')->chaveEstrangeira()->referencia('USUCodigo', 'codigo')->on('TBUsuario');
    }

    /**
     * Define as outras colunas da tabela
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
     * Retorna o nome da tabela
     */
    public function getTabela() {
        return 'TBPessoa';
    }

    /**
     * Retorna o nome da tabela
     */
    public function getSiglaTabela() {
        return 'PES';
    }


}